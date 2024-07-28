<?php

namespace App\Jobs;

use App\Helpers\MailContents;
use App\Helpers\Utility;
use App\Models\Application;
use App\Models\Institution;
use App\Models\InstitutionMembership;
use App\Models\Role;
use App\Models\User;
use App\Notifications\InfoNotification;
use App\Notifications\InfoTableNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class FinalApplicationProcessingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $applicationID;
    protected $force;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($applicationID, $force = false)
    {
        $this->applicationID = $applicationID;
        $this->force = $force;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $application = Application::find($this->applicationID);
        $applicant = User::find($application->submitted_by);

        if (!$application->meg2_review_stage || !$application->is_meg_executed_membership_agreement || !$application->is_applicant_executed_membership_agreement || $application->completed_at) {
            return;
        }

        $data = Application::where('applications.id', $this->applicationID);
        $data = Utility::applicationDetails($data);
        $data = $data->first();

        $categoryName = $data->category_name;
        $companyName = $data->company_name;
        $companyEmail = $data->company_email;
        $primaryContactEmail = $data->primary_contact_email;

        if ($application->e_success_letter_send) {
            return;
        }

        //SEND APPLICANT MAIL
        $emailData = [
            'name' => $companyName,
            'subject' => MailContents::SuccessfulApplicationSubject(),
            'content' => MailContents::SuccessfulApplicationMail($categoryName),
        ];

        $attachment = [
            [
                "name" => Utility::getFileName("{$companyName} Membership Agreement", $application->meg_executed_membership_agreement),
                "saved_path" => config('app.url') . '' . config('app.storage_path') . '' . $application->meg_executed_membership_agreement,
            ],
            [
                "name" => Utility::getFileName("{$companyName} E-Success Letter", $application->e_success_letter),
                "saved_path" => config('app.url') . '' . config('app.storage_path') . '' . $application->e_success_letter,
            ],
        ];

        // CC email addresses
        $Meg = Utility::getUsersEmailByCategory(Role::MEG);
        $Mbg = Utility::getUsersEmailByCategory(Role::MBG);
        $big = Utility::getUsersEmailByCategory(Role::BIG);
        $ccEmails = array_merge($Meg, $Mbg, $big);

        if (stripos($categoryName, "Registration Member") !== false) {
            $blg = Utility::getUsersEmailByCategory(Role::BLG);
            $ccEmails = array_merge($ccEmails, $blg);
        }

        // CONVERT INSTITUTION CATEGORY
        if ($application->application_type == Application::type['CON']) {

            $old_application = Application::where('membership_category_id', $application->old_membership_category_id)
                ->where('institution_id', $application->institution_id)->first();
            $old_application->application_type_status = Application::typeStatus['ASN'];
            $old_application->save();

            $institution = InstitutionMembership::where('institution_id', $application->institution_id)->where('membership_category_id', $application->old_membership_category_id)->first();
            $institution->membership_category_id = $application->membership_category_id;
            $institution->save();

        }

        if ($application->application_type == Application::type['ADD']) {

            InstitutionMembership::updateOrCreate([
                'institution_id' => $application->institution_id,
                'membership_category_id' => $application->membership_category_id,
            ], [
                'institution_id' => $application->institution_id,
                'membership_category_id' => $application->membership_category_id,
            ]);
        }

        Utility::applicationStatusHelper($application, Application::statuses['MPC'], Application::office['MEG2'], Application::office['AP']);

        $application->e_success_letter_send = 1;
        $application->completed_at = now();
        $application->application_type_status = Application::typeStatus['ASC'];
        $application->save();

        $toEmails = [$applicant->email, $companyEmail];

        if ($primaryContactEmail) {
            array_push($toEmails, $primaryContactEmail);
        }

        Utility::notifyApplicantFinal($application->id, $emailData, $toEmails, $ccEmails, $attachment);

        //Send MSG CC MEG'
        $Msg = Utility::getUsersByCategory(Role::MSG);
        $Meg = Utility::getUsersEmailByCategory(Role::MEG);
        $data = [
            "header" => ["Name", "Membership Category", "Company email address"],
            "body" => [
                [$companyName, $categoryName, $companyEmail],
            ],
        ];

        Notification::send($Msg, new InfoTableNotification(MailContents::msgProfilingMail($categoryName), MailContents::msgProfilingSubject($categoryName), $data, $Meg));

        //FMDQ Help Desk Cc MEG
        $HelpDesk = Utility::getUsersByCategory(Role::HELPDESK);
        $Meg = Utility::getUsersEmailByCategory(Role::MEG);
        Notification::send($HelpDesk, new InfoNotification(MailContents::helpdeskupdateMail($companyName, $categoryName), MailContents::helpdeskupdateSubject($categoryName), $Meg));

        //TODO::SEND SECOND MAIL TO HELPDESK
        $institution = Institution::find($application->institution_id);
        $membershipCategory = $application->membershipCategory;
        $compulsoryPositions = $membershipCategory->positions()->where('is_compulsory', 1)->pluck('position_id')->toArray();

        $keyofficers = User::whereIn('position_id', $compulsoryPositions)->where('institution_id', $institution->id)->get();
        Utility::sendMailGroupNotification($keyofficers, $membershipCategory);
    }
}
