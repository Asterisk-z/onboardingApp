<?php

namespace App\Listeners;

use App\Events\ArAddedEvent;
use App\Helpers\MailContents;
use App\Helpers\Utility;
use App\Models\Application;
use App\Models\MembershipCategory;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use App\Notifications\InfoNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class CheckAllRequiredArListener implements ShouldQueue
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
     * @param  \App\Events\ArAddedEvent  $event
     * @return void
     */
    public function handle(ArAddedEvent $event)
    {
        $newAr = $event->newAr;
        $arPosition = $newAr->position_id;
        $institutionId = $event->institutionId;

        $applications = Application::where('institution_id', $institutionId)->whereIn('application_type_status', [Application::typeStatus['ASP'], Application::typeStatus['ASC']])->get();

        foreach ($applications as $application) {

            $membershipCategory = $application->membershipCategory;
            $compulsoryPositions = $membershipCategory->positions()->where('is_compulsory', 1)->pluck('position_id')->toArray();
            $uploadedPositions = User::where('institution_id', $institutionId)->pluck('position_id')->toArray();

            if ($application->completed_at) {
                //Check if the position of the AR added is important and send to group for profiling
                if (in_array($arPosition, $compulsoryPositions)) {
                    Utility::sendMailGroupNotification([$newAr], $membershipCategory);
                }
            }

            //All required ar are not yet updated
            if ($application->membership_agreement && $application->is_applicant_executed_membership_agreement && !$application->all_ar_uploaded) {
                $status = Status::find($application->status);
                //check if he completetes the required
                if (count(array_diff($compulsoryPositions, $uploadedPositions)) === 0) {
                    //update all_ar_uploaded
                    $application->all_ar_uploaded = 1;
                    $application->save();

                    // if he complete, to be double sure confirm status and that meg has not being sent mail alredy
                    if ($status->status === Application::statuses['AEM'] && !$application->is_sent_meg_mebership_agreement) {
                        //send meg mail

                        Utility::applicationStatusHelper($application, Application::statuses['AUARA'], Application::office['AP'], Application::office['MEG']);
                        Utility::applicationTimestamp($application, 'AAAA');

                        $applicant = User::find($application->submitted_by);

                        $data = Application::where('applications.id', $application->id);
                        $data = Utility::applicationDetails($data);
                        $data = $data->first();

                        $companyName         = $data->company_name;
                        $MEGs = Utility::getUsersByCategory(Role::MEG);
                        Notification::send($MEGs, new InfoNotification(MailContents::applicantUploadAgreementMail($companyName), MailContents::applicantUploadAgreementSubject()));

                        //Update since we have now sent agreement
                        $application->is_sent_meg_mebership_agreement = 1;
                        $application->save();
                    }
                }


                if ($status->status === Application::statuses['AEM']  && !$application->is_sent_meg_mebership_agreement && in_array($application->membership_category_id, [
                    MembershipCategory::CATEGORIES['AFFILIATE_MEMBER_STANDARD_INDIVIDUAL'],
                    MembershipCategory::CATEGORIES['AFFILIATE_MEMBER_STANDARD_CORPORATE'],
                    MembershipCategory::CATEGORIES['AFFILIATE_MEMBER_FOREIGN_EXCHANGE_TRADING'],
                    MembershipCategory::CATEGORIES['AFFILIATE_MEMBER_FIXED_INCOME'],
                    MembershipCategory::CATEGORIES['AFFILIATE_MEMBER_REGULATOR']])) {


                        Utility::applicationStatusHelper($application, Application::statuses['AUARA'], Application::office['AP'], Application::office['MEG']);
                        Utility::applicationTimestamp($application, 'AAAA');

                        $applicant = User::find($application->submitted_by);

                        $data = Application::where('applications.id', $application->id);
                        $data = Utility::applicationDetails($data);
                        $data = $data->first();

                        $companyName         = $data->company_name;
                        $MEGs = Utility::getUsersByCategory(Role::MEG);
                        Notification::send($MEGs, new InfoNotification(MailContents::applicantUploadAgreementMail($companyName), MailContents::applicantUploadAgreementSubject()));

                        //Update since we have now sent agreement
                        $application->is_sent_meg_mebership_agreement = 1;
                        $application->all_ar_uploaded = 1;
                        $application->save();
                }


            }




        }

        // $application = Application::where('institution_id', $institutionId)->where('application_type', Application::type['APP'])->first();
        // $membershipCategory = $application->membershipCategory;
        // $compulsoryPositions = $membershipCategory->positions()->where('is_compulsory', 1)->pluck('position_id')->toArray();
        // $uploadedPositions = User::where('institution_id', $institutionId)->pluck('position_id')->toArray();

        // if($application->completed_at) {
        //     //Check if the position of the AR added is important and send to group for profiling
        //     if(in_array($arPosition, $compulsoryPositions)){
        //         Utility::sendMailGroupNotification([$newAr], $membershipCategory);
        //     }
        //     return;
        // }

        // //All required ar are not yet updated
        // if($application->membership_agreement && $application->is_applicant_executed_membership_agreement && ! $application->all_ar_uploaded) {
        //     //check if he completetes the required
        //     if(count(array_diff($compulsoryPositions, $uploadedPositions)) === 0) {
        //         //update all_ar_uploaded
        //         $application->all_ar_uploaded = 1;
        //         $application->save();

        //         // if he complete, to be double sure confirm status and that meg has not being sent mail alredy
        //         $status = Status::find($application->status);
        //         if($status->status === Application::statuses['AEM'] && ! $application->is_sent_meg_mebership_agreement) {
        //             //send meg mail

        //             Utility::applicationStatusHelper($application, Application::statuses['AUARA'], Application::office['AP'], Application::office['MEG']);

        //             $applicant = User::find($application->submitted_by);
        //             $name = $applicant->first_name . ' ' . $applicant->last_name;
        //             $MEGs = Utility::getUsersByCategory(Role::MEG);
        //             Notification::send($MEGs, new InfoNotification(MailContents::applicantUploadAgreementMail($name), MailContents::applicantUploadAgreementSubject()));

        //             //Update since we have now sent agreement
        //             $application->is_sent_meg_mebership_agreement = 1;
        //             $application->save();
        //         }
        //     }

        // }
    }
}
