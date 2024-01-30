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

        Utility::applicationStatusHelper($application, Application::statuses['MAFR'], Application::office['MBG'], Application::office['MEG'], $request->comment);
        
        $application = $application->refresh();
        $application->mbg_review_stage = 1;
        $application->save();
        
        $MEGs = Utility::getUsersEmailByCategory(Role::MEG);
        $MEG2s = Utility::getUsersByCategory(Role::MEG2);
        $CCs = $MEGs;

        Notification::send($MEG2s, new InfoNotification(MailContents::megReportValidationMail($data->company_name), MailContents::megReportValidationSubject(), $CCs));
        
        logAction($user->email, 'MEG Approved', "MBG Approved applicant Document", $request->ip());
        
        $application->application_report = $application_report;
        $application->save();

        return successResponse("Application Report has been submitted");        
    }
}
