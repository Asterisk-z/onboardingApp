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

class MegApplicationController extends Controller
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
            'office_to_perform_next_action' => Application::office['MEG']
        ]);

        $data = Utility::applicationDetails($data);
        $data = $data->get();


        return successResponse("Here you go", ApplicationResource::collection($data));
    }

    public function megReview(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:applications,id',
            'status' => 'required|in:decline,approve',
            'application_report' => 'required_if:status,approve|mimes:jpeg,png,jpg,pdf,doc,docx,csv,xls,xlsx|max:5048',
            'comment' => 'required|string'
        ]);

        $user = $request->user();
        $application = Application::find($request->application_id);

        $errorMsg = "Unable to complete your request at this point.";
        if($application->office_to_perform_next_action != Application::office['MEG']){
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        if($application->currentStatus() != Application::statuses['MAFR'] &&
        $application->currentStatus() != Application::statuses['M2DMR']){
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        $applicant = User::find($application->submitted_by);
        $name = $applicant->first_name.' '.$applicant->last_name;

        $data = Application::where('applications.id', $request->application_id);
        $data = Utility::applicationDetails($data);
        $data = $data->first();

        if($request->status == 'decline'){
            $companyEmail = $data->company_email; 
            $companyName = $data->company_name; 
            $contactEmail = $data->primary_contact_email;

            $emailData = [
                'name' => $companyName,
                'subject' => 'MROIS Application Rejected - Incomplete Documentation',
                'content' => "<p>Please be informed that we could not continue with your application because of the following:
                        <p>Reason: {$request->comment}</p></p>"
            ];
            
            // Recipient email addresses
            $toEmails = [$applicant->email, $companyEmail, $contactEmail];
            
            // CC email addresses
            $Meg = Utility::getUsersEmailByCategory(Role::MEG);
            $ccEmails = $Meg;

            Utility::emailHelper($emailData, $toEmails, $ccEmails);
            Utility::applicationStatusHelper($application, Application::statuses['MDD'], Application::office['MEG'], Application::office['AP'], $request->comment);

            logAction($user->email, 'MEG Declined', "MEG Declined applicant Document", $request->ip());

            return successResponse("Application updated successfully");
        }

        if($request->status == 'approve'){

            Utility::applicationStatusHelper($application, Application::statuses['MAMR'], Application::office['MEG'], Application::office['MEG2'], $request->comment);
            $application = $application->refresh();
            $application->meg_review_stage = 1;
            $application->save();
            
            $MEGs = Utility::getUsersEmailByCategory(Role::MEG);
            $MEG2s = Utility::getUsersByCategory(Role::MEG2);
            $CCs = $MEGs;

            Notification::send($MEG2s, new InfoNotification(MailContents::megReportValidationMail($data->company_name), MailContents::megReportValidationSubject(), $CCs));
            
            logAction($user->email, 'MEG Approved', "MEG Approved applicant Document", $request->ip());
            
            $application->application_report = $request->hasFile('application_report') ? $request->file('application_report')->storePublicly('application_report', 'public') : null;
            $application->save();

            return successResponse("Application Report has been submitted");
        }        
    }
}
