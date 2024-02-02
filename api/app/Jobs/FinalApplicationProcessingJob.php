<?php

namespace App\Jobs;

use App\Helpers\MailContents;
use App\Helpers\Utility;
use App\Models\Application;
use App\Models\Institution;
use App\Models\Role;
use App\Models\User;
use App\Notifications\InfoNotification;
use App\Notifications\InfoTableNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class FinalApplicationProcessingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $applicationID;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($applicationID)
    {
        $this->applicationID = $applicationID;
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

        if(! $application->meg2_review_stage || ! $application->is_meg_executed_membership_agreement || ! $application->is_applicant_executed_membership_agreement || $application->completed_at)
            return;

        $data = Application::where('applications.id', $this->applicationID);
        $data = Utility::applicationDetails($data);
        $data = $data->first();
        
        $categoryName = $data->category_name;
        $companyName = $data->company_name;
        $companyEail = $data->company_email;

        //Generated E-success letter
        if(! $application->e_success_letter){
            //generate
            $application->e_success_letter = '';
            $application->save();
        }

        //CHECK IF ALL ARS HAVE BEEN ADDED
        if(! $application->all_ar_uploaded){
            Utility::notifyApplicantAndContactArUpdate($application);
            return;
        }

        if($application->e_success_letter_send){                                                                                                                                                                                                                                                                                                                                                                                                               
            return;
        }

        Utility::applicationStatusHelper($application, Application::statuses['MPC'], Application::office['MEG'], Application::office['AP']);

        //SEND APPLICANT MAIL
        $emailData = [
            'name' => $companyName,
            'subject' => MailContents::SuccessfulApplicationSubject(),
            'content' => MailContents::SuccessfulApplicationMail($categoryName)
        ];

        $attachment = [
            [
                "name" => "{$companyName} Membership Agreement",
                "saved_path" => config('app.url') .'/storage/'.$application->meg_executed_membership_agreement
            ],
            [
                "name" => "e-Success Letter",
                "saved_path" => config('app.url') .'/storage/'.$application->meg_executed_membership_agreement
            ]
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

        $application->e_success_letter_send = 1;
        $application->completed_at = now();
        $application->save();

        Utility::notifyApplicantAndContact($application->id, $applicant, $emailData, $ccEmails, $attachment);

        //Send MSG CC MEG
        $Msg = Utility::getUsersByCategory(Role::MSG);
        $Meg = Utility::getUsersEmailByCategory(Role::MEG);
        $data = [
            "header" => ["Name", "Membership Category", "Company email address"],
            "body" => [
                [$companyName, $categoryName, $companyEail]
            ]
        ];

        Notification::send($Msg, new InfoTableNotification(MailContents::msgProfilingMail($categoryName), MailContents::msgProfilingSubject($categoryName), $data, $Meg));

        //FMDQ Help Desk Cc MEG
        $HelpDesk = Utility::getUsersByCategory(Role::HELPDESK);
        $Meg = Utility::getUsersEmailByCategory(Role::MEG);
        Notification::send($HelpDesk, new InfoNotification(MailContents::helpdeskupdateMail($companyName, $categoryName), MailContents::helpdeskupdateSubject($categoryName), $Meg));

        //TODO::SEND SECOND MAIL TO HELPDESK

        $institution = Institution::find($application->institution_id);
        $membershipCategory = $institution->membershipCategories->first();
        $compulsoryPositions = $membershipCategory->positions()->where('is_compulsory', 1)->pluck('position_id')->toArray();

        $keyofficers = User::whereIn('position_id', $compulsoryPositions)->where('institution_id', $institution->id)->get();
        Utility::sendMailGroupNotification($keyofficers, $membershipCategory);
    }
}
