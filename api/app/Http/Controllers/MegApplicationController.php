<?php

namespace App\Http\Controllers;

use App\Helpers\MailContents;
use App\Helpers\Utility;
use App\Http\Resources\ApplicationResource;
use App\Jobs\FinalApplicationProcessingJob;
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
            'concession_stage' => true,
            'office_to_perform_next_action' => Application::office['MEG'],
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
            'comment' => 'required|string',
        ]);

        $user = $request->user();
        $application = Application::find($request->application_id);

        $errorMsg = "Unable to complete your request at this point.";
        if ($application->office_to_perform_next_action != Application::office['MEG']) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        if ($application->currentStatus() != Application::statuses['MAFR'] &&
            $application->currentStatus() != Application::statuses['M2DMR'] &&
            $application->currentStatus() != Application::statuses['ARD']) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        $applicant = User::find($application->submitted_by);
        $data = Application::where('applications.id', $request->application_id);
        $data = Utility::applicationDetails($data);
        $data = $data->first();

        if ($request->status == 'decline') {
            $companyName = $data->company_name;
            $emailData = [
                'name' => $companyName,
                'subject' => 'MROIS Application Rejected - Incomplete Documentation',
                'content' => "<p>Please be informed that we could not continue with your application because of the following:
                        <p>Reason: {$request->comment}</p></p>",
            ];
            $Meg = Utility::getUsersEmailByCategory(Role::MEG);
            Utility::notifyApplicantAndContact($request->application_id, $applicant, $emailData, $Meg);
            Utility::applicationStatusHelper($application, Application::statuses['MDD'], Application::office['MEG'], Application::office['AP'], $request->comment);

            logAction($user->email, 'MEG Declined', "MEG Declined applicant Document", $request->ip());

            $application->reupload = true;
            $application->show_form = 1;
            $application->save();

            return successResponse("Application updated successfully");
        }

        if ($request->status == 'approve') {

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

    public function uploadMemberAgreement(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:applications,id',
            'executed_member_agreement' => 'required|mimes:jpeg,png,jpg,pdf,doc,docx,csv,xls,xlsx|max:5048',
        ]);

        $user = $request->user();
        $application = Application::find($request->application_id);

        $errorMsg = "Unable to complete your request at this point.";

        if ($application->office_to_perform_next_action != Application::office['MEG']) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        if ($application->currentStatus() != Application::statuses['AEM']) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        $application->meg_executed_membership_agreement = $request->hasFile('executed_member_agreement') ? $request->file('executed_member_agreement')->storePublicly('meg_executed_member_agreement', 'public') : null;
        $application->is_meg_executed_membership_agreement = 1;
        $application->save();

        logAction($user->email, 'Membership agreement uploaded by MEG', "Executed membership agreement uploaded by MEG.", $request->ip());
        Utility::applicationStatusHelper($application, Application::statuses['MEM'], Application::office['MEG'], Application::office['AP']);

        FinalApplicationProcessingJob::dispatch($request->application_id);

        return successResponse("Agreement uploaded successfully");

    }

    public function completeCompanyApplication(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:applications,id',
        ]);

        $user = $request->user();
        $application = Application::find($request->application_id);

        $application_data = Application::where('applications.id', $request->application_id);
        $application_data = Utility::applicationDetails($application_data);
        $application_data = $application_data->first();

        $application->institution()->update(['name' => $application_data->company_name]);

        $errorMsg = "Unable to complete your request at this point.";

        if ($application->completed_at) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        logAction($user->email, 'MEG completed Application', "MEG completed Application for {$application_data->company_name}.", $request->ip());
        Utility::applicationStatusHelper($application, Application::statuses['MAA'], Application::office['MEG'], Application::office['AP']);

        FinalApplicationProcessingJob::dispatch($request->application_id, true);

        return successResponse("You have successfully mark this application as completed");
    }
}
