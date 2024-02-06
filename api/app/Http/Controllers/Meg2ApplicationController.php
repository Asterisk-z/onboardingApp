<?php

namespace App\Http\Controllers;

use App\Helpers\MailContents;
use App\Helpers\Utility;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use App\Models\Role;
use App\Models\User;
use App\Notifications\InfoNotification;
use App\Traits\ApplicationTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\Response;

class Meg2ApplicationController extends Controller
{
    use ApplicationTraits;
    /**
     * get institutions that are due for FSD review
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function institutions(Request $request)
    {
        $data = Application::where([
            'concession_stage'  => true,
            'office_to_perform_next_action' => Application::office['MEG2']
        ]);

        $data = Utility::applicationDetails($data);
        $data = $data->get();


        return successResponse("Here you go", ApplicationResource::collection($data));
    }

    public function meg2Approval(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:applications,id'
        ]);

        $user = $request->user();
        $application = Application::find($request->application_id);
        $institution = $application->institution;
        $membershipCategory = $institution->membershipCategories->first();

        $errorMsg = "Unable to complete your request at this point.";

        if($application->office_to_perform_next_action != Application::office['MEG2']){
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        if($application->currentStatus() != Application::statuses['MAMR']){
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        $applicant = User::find($application->submitted_by);
        $name = $applicant->first_name.' '.$applicant->last_name;

        $data = Application::where('applications.id', $request->application_id);
        $data = Utility::applicationDetails($data);
        $data = $data->first();

        $companyName = $data->company_name; 
        
        $application = $application->refresh();
        $application->meg2_review_stage = 1;
        $application->save();
        
        // CC email addresses
        $Meg = Utility::getUsersEmailByCategory(Role::MEG);

        //NOTIFY APPLICANT AND SEND MEMBERSHIP AGREEMENT
        $emailData = [
            'name' => $name,
            'subject' => MailContents::memberAgreementSubject(),
            'content' => MailContents::memberAgreementMail()
        ];
        
        $attachment = [
            [
                "name" => "{$membershipCategory->name} Membership Agreement",
                "saved_path" => $application->membership_agreement
            ]
        ];

        Utility::notifyApplicantAndContact($request->application_id, $applicant, $emailData, $Meg, $attachment);
        
        $MEGs = Utility::getUsersByCategory(Role::MEG);
        $MEG2s = Utility::getUsersEmailByCategory(Role::MEG2);
        $CCs = $MEG2s;

        //NOTIFY MEG OF APPROVAL
        Notification::send($MEGs, new InfoNotification(MailContents::meG2ApprovalMail($companyName, $membershipCategory->name), MailContents::meG2ApprovalSubject(), $CCs));

        $application->membership_agreement = $membershipCategory->membership_agreement;
        $application->save();

        Utility::applicationStatusHelper($application, Application::statuses['M2AMR'], Application::office['MEG2'], Application::office['AP']);
        
        logAction($user->email, 'MEG2 Approval', "MEG2 Approved MEG Review", $request->ip());

        return successResponse("Application Review has been submitted");        
    }
}
