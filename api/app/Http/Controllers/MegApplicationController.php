<?php

namespace App\Http\Controllers;

use App\Helpers\ESuccessLetter;
use App\Helpers\MailContents;
use App\Helpers\Utility;
use App\Http\Resources\ApplicationResource;
use App\Jobs\FinalApplicationProcessingJob;
use App\Models\Application;
use App\Models\DohSignature;
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
            $application->step = 1;
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

    public function sendMembershipAgreement(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:applications,id',
        ]);

        $user = $request->user();
        $application = Application::find($request->application_id);
        $membershipCategory = $application->membershipCategory;

        $errorMsg = "Unable to complete your request at this point.";

        if ($application->office_to_perform_next_action != Application::office['MEG']) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        if ($application->currentStatus() != Application::statuses['M2AMR']) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        $applicant = User::find($application->submitted_by);
        $name = $applicant->first_name . ' ' . $applicant->last_name;

        $data = Application::where('applications.id', $request->application_id);
        $data = Utility::applicationDetails($data);
        $data = $data->first();

        $application = $application->refresh();

        // CC email addresses
        $Meg = Utility::getUsersEmailByCategory(Role::MEG);

        // NOTIFY APPLICANT AND SEND MEMBERSHIP AGREEMENT
        $emailData = [
            'name' => $name,
            'subject' => MailContents::memberAgreementSubject(),
            'content' => MailContents::memberAgreementMail(),
        ];

        $attachment = [
            [
                "name" => "{$membershipCategory->name} Membership Agreement",
                "saved_path" => $membershipCategory->membership_agreement,
            ],
        ];

        Utility::notifyApplicantAndContact($request->application_id, $applicant, $emailData, $Meg, $attachment);

        Utility::applicationStatusHelper($application, Application::statuses['MSMA'], Application::office['MEG'], Application::office['AP']);

        logAction($user->email, 'MEG Sent Agreement', "MEG Send membership agreement to applicant", $request->ip());

        return successResponse("Membership agreement has been sent successfully.");
    }

    public function uploadMemberAgreement(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:applications,id',
            'executed_member_agreement' => 'required|mimes:jpeg,png,jpg,pdf,doc,docx,csv,xls,xlsx|max:5048',
        ]);

        $user = $request->user();
        $application = Application::find($request->application_id);
        $data = Application::where('applications.id', $request->application_id);
        $data = Utility::applicationDetails($data);
        $data = $data->first();

        $errorMsg = "Unable to complete your request at this point.";

        if ($application->office_to_perform_next_action != Application::office['MEG']) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        if ($application->currentStatus() != Application::statuses['AUARA']) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        $application->meg_executed_membership_agreement = $request->hasFile('executed_member_agreement') ? $request->file('executed_member_agreement')->storePublicly('meg_executed_member_agreement', 'public') : null;
        $application->is_meg_executed_membership_agreement = 1;
        $application->save();
        // logger('test1');
        logAction($user->email, 'Membership agreement uploaded by MEG', "Executed membership agreement uploaded by MEG.", $request->ip());
        Utility::applicationStatusHelper($application, Application::statuses['MEM'], Application::office['MEG'], Application::office['MEG2']);

        (new ESuccessLetter)->generate($application);
        // logger('test2');
        //Notify MEG2 THAT E-SUCCESS IS AVALIABLLE
        $MEGs = Utility::getUsersEmailByCategory(Role::MEG);
        $MEG2s = Utility::getUsersByCategory(Role::MEG2);
        $CCs = $MEGs;
        // logger('test3');
        Notification::send($MEG2s, new InfoNotification(MailContents::meg2EsuccessMail($data->company_name), MailContents::meg2EsuccessSubject(), $CCs));
        logger('test4');
        return successResponse("Agreement uploaded successfully");

    }

    public function completeCompanyApplication(Request $request)
    {
        return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, "API has been decommissioned");
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

    public function getSignature(Request $request)
    {
        $data = DohSignature::latest()->first();
        return successResponse("Here you go", $data);
    }

    public function createSignature(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'grade' => 'required|string',
            'division' => 'required|string',
            'signature' => 'required|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = $request->user();
        $data = $request->all();
        $data['user_id'] = $user->id;
        $data['signature'] = $request->hasFile('signature') ? $request->file('signature')->storePublicly('signature', 'public') : null;

        $sig = DohSignature::create($data);

        logAction($user->email, 'DOH Signature details updated', "DOH Signature details updated.", $request->ip());

        return successResponse("Here you go", $sig);
    }
}
