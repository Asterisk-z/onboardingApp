<?php
namespace App\Http\Controllers;

use App\Events\ESuccessLetterEvent;
use App\Helpers\ESuccessLetter;
use App\Helpers\MailContents;
use App\Helpers\Utility;
use App\Http\Resources\ApplicationResource;
use App\Jobs\FinalApplicationProcessingJob;
use App\Models\Application;
use App\Models\MemberESuccessLetter;
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
            'concession_stage'              => true,
            'office_to_perform_next_action' => Application::office['MEG2'],
        ]);

        $data = Utility::applicationDetails($data);
        $data = $data->get();

        return successResponse("Here you go", ApplicationResource::collection($data));
    }

    public function updateMemberSuccessLetter(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:applications,uuid',
            'name'           => 'required',
            'address'        => 'required',
            'member'         => 'required',
        ]);

        $user        = $request->user();
        $application = Application::where('uuid', $request->application_id)->first();

        $errorMsg = "Unable to complete your request at this point.";

        if (! $application->is_meg_executed_membership_agreement) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        if ($application->office_to_perform_next_action != Application::office['MEG2']) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg . "1");
        }

        $agreement = MemberESuccessLetter::updateOrCreate(["application_id" => $application->id], [
            "application_id" => $application->id,
            "companyName"    => request('name'),
            "address"        => request('address'),
            "designation"    => request('member'),
        ]);

        logAction($user->email, 'MEG Level 2 Updated E-Success Letter', "MEG Level 2 updated membership agreement details", $request->ip());

        event(new ESuccessLetterEvent($agreement));

        return successResponse("E-Success Letter has been updated successfully.");
    }

    public function meg2Approval(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:applications,id',
        ]);

        $user               = $request->user();
        $application        = Application::find($request->application_id);
        $membershipCategory = $application->membershipCategory;

        $errorMsg = "Unable to complete your request at this point.";

        if ($application->office_to_perform_next_action != Application::office['MEG2']) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        if ($application->currentStatus() != Application::statuses['MAMR']) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        $applicant = User::find($application->submitted_by);
        $name      = $applicant->first_name . ' ' . $applicant->last_name;

        $data = Application::where('applications.id', $request->application_id);
        $data = Utility::applicationDetails($data);
        $data = $data->first();

        $companyName = $data->company_name;

        $application                    = $application->refresh();
        $application->meg2_review_stage = 1;
        $application->save();

        // CC email addresses
        // $Meg = Utility::getUsersEmailByCategory(Role::MEG);

        //NOTIFY APPLICANT AND SEND MEMBERSHIP AGREEMENT
        // $emailData = [
        //     'name' => $name,
        //     'subject' => MailContents::memberAgreementSubject(),
        //     'content' => MailContents::memberAgreementMail()
        // ];

        // $attachment = [
        //     [
        //         "name" => "{$membershipCategory->name} Membership Agreement",
        //         "saved_path" => $membershipCategory->membership_agreement
        //     ]
        // ];

        // Utility::notifyApplicantAndContact($request->application_id, $applicant, $emailData, $Meg, $attachment);

        $MEGs  = Utility::getUsersByCategory(Role::MEG);
        $MEG2s = Utility::getUsersEmailByCategory(Role::MEG2);
        $CCs   = $MEG2s;

        $categoryNameWithPronoun = Utility::categoryNameWithPronoun($membershipCategory->name);
        $categoryName            = $membershipCategory->name;

        //NOTIFY MEG OF APPROVAL
        Notification::send($MEGs, new InfoNotification(MailContents::meG2ApprovalMail($companyName, $categoryName), MailContents::meG2ApprovalSubject(), $CCs));

        $application->membership_agreement = $membershipCategory->membership_agreement;
        $application->save();

        Utility::applicationStatusHelper($application, Application::statuses['M2AMR'], Application::office['MEG2'], Application::office['MEG']);
        Utility::applicationTimestamp($application, 'MAAD');

        logAction($user->email, 'MEG2 Approval', "MEG2 Approved MEG Review", $request->ip());

        return successResponse("Application Review has been submitted");
    }

    public function approveEsuccessLetter(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:applications,id',
        ]);

        $user               = $request->user();
        $application        = Application::find($request->application_id);
        $membershipCategory = $application->membershipCategory;

        if (! $agreement = MemberESuccessLetter::where('application_id', $application->id)->first()) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, "Update e-success letter details");
        }

        (new ESuccessLetter)->generate($application);

        $application->refresh();

        $errorMsg = "Unable to complete your request at this point.";

        if ($application->office_to_perform_next_action != Application::office['MEG2']) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg . "1");
        }

        // if ($application->currentStatus() != Application::statuses['MEM']) {
        //     return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg . "2");
        // }

        if (! $application->e_success_letter || $application->e_success_letter_send) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg . "3");
        }

        Utility::applicationStatusHelper($application, Application::statuses['M2AEL'], Application::office['MEG2'], Application::office['AP']);
        Utility::applicationTimestamp($application, 'M2EL');

        logAction($user->email, 'MEG2 Approval Of e-SUCCESS', "MEG2 Approved e-SUCCESS letter for sending", $request->ip());

        FinalApplicationProcessingJob::dispatch($request->application_id, true);

        return successResponse("E-success letter approved successfully");

    }
}
