<?php

namespace App\Listeners;

use App\Events\ApplicationSubmissionEvent;
use App\Helpers\Utility;
use App\Models\ApplicationField;
use App\Models\Role;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ApplicationSubmissionListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ApplicationSubmissionEvent  $event
     * @return void
     */
    public function handle(ApplicationSubmissionEvent $event)
    {
        $user = $event->user;
        $application = $event->application;
        $institution = $event->institution;
        $membershipCategory = $event->membershipCategory;

        //SEND FIRST BATCH OF EMAIL
        $data = ApplicationField::where('name', 'companyEmailAddress')
        ->join('application_field_uploads', function ($join) use($application) {
            $join->on('application_fields.id', '=', 'application_field_uploads.application_field_id')
                ->where('application_field_uploads.application_id', '=', $application->id);
        })
        ->select('application_field_uploads.*')
        ->first();

        $companyEmail = $data->uploaded_field ? $data->uploaded_field : $data->uploaded_file;
        $companyEmail = filter_var($companyEmail, FILTER_VALIDATE_EMAIL) ? $companyEmail : '';

        $data = ApplicationField::where('name', 'applicationPrimaryContactEmailAddress')
        ->join('application_field_uploads', function ($join) use($application) {
            $join->on('application_fields.id', '=', 'application_field_uploads.application_field_id')
                ->where('application_field_uploads.application_id', '=', $application->id);
        })
        ->select('application_field_uploads.*')
        ->first();

        $contactEmail = $data->uploaded_field ? $data->uploaded_field : $data->uploaded_file;
        $contactEmail = filter_var($contactEmail, FILTER_VALIDATE_EMAIL) ? $contactEmail : '';

        $name = $user->first_name.' '.$user->last_name;
        $categoryName = $membershipCategory->name;

        $emailData = [
            'name' => $name,
            'subject' => 'New Membership Application',
            'content' => "Thank you for your interest in the $categoryName of FMDQ Securities Exchange Limited.
                        We are currently reviewing your application and will provide feedback within three (3) business
                        days",
        ];
        
        // Recipient email addresses
        $toEmails = [$user->email, $companyEmail, $contactEmail];
        
        // CC email addresses
        $Meg = Utility::getUsersEmailByCategory(Role::MEG);
        $ccEmails = $Meg;

        Utility::emailHelper($emailData, $toEmails, $ccEmails);

        //SEND EMAIL TO MEG, MBG and FSD

        $Mbg = Utility::getUsersEmailByCategory(Role::MBG);
        $fsd = Utility::getUsersEmailByCategory(Role::FSD);
        $tos = array_merge($Meg, $Mbg, $fsd);

        $emailD = [
            'name' => 'Team',
            'subject' => 'New Membership Application',
            'content' => "A new applicant, $name, has successfully submitted 
                            an application on the MROIS portal as a $categoryName",
        ];

        Utility::emailHelper($emailD, $tos);

        //SEND EMAIL TO MBG cc MEG and MBG for concession
        $to = $Mbg;
        $ccs  = array_merge($Meg, $fsd);

        $emailC = [
            'name' => 'Team',
            'subject' => 'New Membership Application: Concession Confirmation',
            'content' => "A new applicant, $name, has successfully submitted an application as a 
            $categoryName on the MROIS portal. Kindly grant a concession (where applicable)",
        ];

        Utility::emailHelper($emailC, $to, $ccs);
    }
}
