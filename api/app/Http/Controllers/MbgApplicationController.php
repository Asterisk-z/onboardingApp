<?php

namespace App\Http\Controllers;

use App\Helpers\MailContents;
use App\Helpers\Utility;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use App\Models\ArCreationRequest;
use App\Models\Invoice;
use App\Models\Role;
use App\Models\SystemSetting;
use App\Models\User;
use App\Notifications\InfoNotification;
use App\Traits\ApplicationTraits;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class MbgApplicationController extends Controller
{
    use ApplicationTraits;
    /**
     * get institutions that are due for concession stage
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function institutions(Request $request)
    {
        $data = Application::where([
            'office_to_perform_next_action' => Application::office['MBG'],
        ]);

        $data = Utility::applicationDetails($data);
        $data = $data->get();

        return successResponse("Here you go", ApplicationResource::collection($data));
    }

    public function paymentInformation(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:applications,id',
        ]);

        $data = $this->subPaymentInformation($request->application_id);

        return successResponse("Here you go", $data ?? []);
    }

    public function latestEvidence(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:applications,id',
        ]);

        $data = $this->subLatestEvidence($request->application_id);
        return successResponse("Here you go", $data ?? []);
    }

    public function paymentReviewDetails(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:applications,id',
        ]);

        $data = $this->subPaymentReviewDetails($request->application_id);
        return successResponse("Here you go", $data ?? []);
    }

    public function fsdReviewSummary(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:applications,id',
        ]);

        $application = Application::find($request->application_id);

        $comment = $application->statusModel() ? $application->statusModel()->comment : null;

        $data = [
            'fsd_comment' => $comment,
            "fsd_received_amount" => $application->amount_received_by_fsd,
        ];

        return successResponse("Here you go", $data ?? []);
    }

    public function concession(Request $request)
    {
        $request->validate([
            'concession_amount' => 'sometimes|nullable|numeric|min:100',
            'concession_file' => 'sometimes|nullable|mimes:jpeg,png,jpg,pdf,doc,docx,csv,xls,xlsx|max:5048',
            "application_id" => 'required|exists:applications,id',
        ]);

        $user = $request->user();
        $application = Application::find($request->application_id);
        $apllication_details = Application::where([
            'applications.id' => $request->application_id,
        ]);
        $apllication_details = Utility::applicationDetails($apllication_details);
        $apllication_details = $apllication_details->first();

        $errorMsg = "Unable to complete your request at this point.";
        if ($application->office_to_perform_next_action != Application::office['MBG']) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        if ($application->currentStatus() != Application::statuses['AS']) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        if ($request->concession_amount && !$request->concession_file) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, "An approval mandate is required to grant concession.");
        }

        $status = Application::statuses['CNG'];

        if ($request->concession_amount) {
            $status = Application::statuses['CG'];
            $concession_file = $request->hasFile('concession_file') ? $request->file('concession_file')->storePublicly('concession', 'public') : null;

            $invoice = Invoice::find($application->invoice_id);

            $invoice->contents()->create([
                "name" => "Concession",
                "value" => strip_tags($request->concession_amount),
                "is_discount" => 1,
                "parent_id" => null,
                "type" => "credit",
            ]);

            $invoiceContents = $invoice->contents;
            $total = $vat = 0;

            foreach ($invoiceContents as $invoiceContent) {
                if ($invoiceContent->name == 'VAT') {
                    continue;
                }
                if ($invoiceContent->type == 'credit') {
                    $total -= $invoiceContent->value;
                }

                if ($invoiceContent->type == 'debit') {
                    $total += $invoiceContent->value;
                }
            }

            if ($vatContent = $invoice->contents()->where('name', 'VAT')->first()) {
                if ($tax = SystemSetting::where('name', 'tax')->first()) {
                    $tax_val = $tax->value ?? 0;
                    $vat = (0.01 * $tax_val) * $total;
                }
                $vatContent->value = $vat;
                $vatContent->save();
            }

            logAction($user->email, 'Concession added', "Concession was granted to {$apllication_details->company_name}.", $request->ip());
        }

        Utility::applicationStatusHelper($application, $status, Application::office['MBG'], Application::office['AP']);
        Utility::applicationTimestamp($application, 'MCC');

        $application = $application->refresh();
        $application->concession_stage = true;
        $application->concession_file = $concession_file ?? null;
        $application->invoiceToken = Str::uuid();
        $application->save();

        $MEGs = Utility::getUsersEmailByCategory(Role::MEG);

        $CCs = array_merge($MEGs);

        logAction($user->email, 'Concession stage Passed', "Application successfully passed through concession stage.", $request->ip());

        //Notify applicant
        $applicant = $application->applicant;
        $applicant->notify(new InfoNotification(MailContents::invoiceMail(), MailContents::invoiceSubject(), $CCs));

        //Notify fsd if concession was added
        if ($request->concession_amount) {
            $MBGs = Utility::getUsersEmailByCategory(Role::MBG);
            $FSDs = Utility::getUsersByCategory(Role::FSD);
            $CCs = array_merge($MBGs, $MEGs);
            $applicationType = applicationType($application);
            Notification::send($FSDs, new InfoNotification(MailContents::concessionMail($apllication_details->company_name), MailContents::concessionSubject($applicationType), $CCs));
        }

        return successResponse("Application Updated Successfully");
    }

    public function mbgReview(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:applications,id',
            'status' => 'required|in:decline,approve',
            'comment' => 'required|string',
        ]);

        $user = $request->user();
        $application = Application::find($request->application_id);

        $errorMsg = "Unable to complete your request at this point.";
        if ($application->office_to_perform_next_action != Application::office['MBG']) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        if ($application->currentStatus() != Application::statuses['MDMR'] &&
            $application->currentStatus() != Application::statuses['FAP']) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        $applicant = User::find($application->submitted_by);
        $membershipCategory = $application->membershipCategory;
        $name = $applicant->first_name . ' ' . $applicant->last_name;

        $data = Application::where('applications.id', $request->application_id);
        $data = Utility::applicationDetails($data);
        $data = $data->first();

        $invoice = Invoice::find($application->invoice_id);

        if ($request->status == 'decline') {

            $categoryNameWithPronoun = Utility::categoryNameWithPronoun($membershipCategory->name);
            $emailData = [
                'name' => $name,
                'subject' => 'Membership Application Payment Declined',
                'content' => "Please be informed that your payment as {$categoryNameWithPronoun} was declined.
                        <pre>Reason: {$request->comment}</pre>
                        <p>For further clarification, kindly contact Membership & Subscriptions Group on +234 20-1-700-8555</p>",
            ];

            // CC email addresses
            $Meg = Utility::getUsersEmailByCategory(Role::MEG);
            $Mbg = Utility::getUsersEmailByCategory(Role::MBG);
            $fsd = Utility::getUsersEmailByCategory(Role::FSD);
            $ccEmails = array_merge($Meg, $Mbg, $fsd);
            // logger($applicant);
            Utility::notifyApplicantAndContact($request->application_id, $applicant, $emailData, $ccEmails);

            Utility::applicationStatusHelper($application, Application::statuses['MDP'], Application::office['MBG'], Application::office['AP'], $request->comment);
            logAction($user->email, 'MBG Declined', "MBG Declined FSD review of applicant payment due to incomplete payment", $request->ip());

            // if (str_contains(strtolower("Incomplete Payment"), strtolower($request->comment))) {

            //     $categoryName = $membershipCategory->name;

            //     $emailData = [
            //         'name' => $name,
            //         'subject' => 'Membership Application Payment Declined',
            //         'content' => "Please be informed that your payment as a {$categoryName} was declined.
            //                 <p>Reason: {$request->comment}</p>
            //                 <p>For further clarification, kindly contact Membership & Subscriptions Group on +234 20-1-700-8555</p>",
            //     ];

            //     // CC email addresses
            //     $Meg = Utility::getUsersEmailByCategory(Role::MEG);
            //     $Mbg = Utility::getUsersEmailByCategory(Role::MBG);
            //     $fsd = Utility::getUsersEmailByCategory(Role::FSD);
            //     $ccEmails = array_merge($Meg, $Mbg, $fsd);

            //     Utility::notifyApplicantAndContact($request->application_id, $applicant, $emailData, $ccEmails);

            //     Utility::applicationStatusHelper($application, Application::statuses['MDP'], Application::office['MBG'], Application::office['AP'], $request->comment);
            //     logAction($user->email, 'MBG Declined', "MBG Declined FSD review of applicant payment due to incomplete payment", $request->ip());
            // } else {
            //     Utility::applicationStatusHelper($application, Application::statuses['MDFR'], Application::office['MBG'], Application::office['FSD'], $request->comment);
            //     $application = $application->refresh();

            //     $MBGs = Utility::getUsersEmailByCategory(Role::MBG);
            //     $MEGs = Utility::getUsersEmailByCategory(Role::MEG);
            //     $FSDs = Utility::getUsersByCategory(Role::FSD);
            //     $CCs = array_merge($MBGs, $MEGs);
            //     Notification::send($FSDs, new InfoNotification(MailContents::mbgPaymentRejectedMail($data->company_name, $request->comment), MailContents::mbgPaymentRejectedSubject(), $CCs));
            //     logAction($user->email, 'MBG Declined', "MBG Declined FSD review of applicant payment", $request->ip());
            // }
        }

        if ($request->status == 'approve') {
            Utility::applicationStatusHelper($application, Application::statuses['MAFR'], Application::office['MBG'], Application::office['MEG'], $request->comment);
            Utility::applicationTimestamp($application, 'MAP');
            $application = $application->refresh();
            $application->mbg_review_stage = 1;
            $application->save();

            $invoice->date_paid = Carbon::now()->format('Y-m-d');
            $invoice->is_paid = 1;
            $invoice->save();

            $MBGs = Utility::getUsersEmailByCategory(Role::MBG);
            $MEGs = Utility::getUsersByCategory(Role::MEG);
            $CCs = $MBGs;
            Notification::send($MEGs, new InfoNotification(MailContents::mbgPaymentApprovedMail($data->company_name), MailContents::mbgPaymentApprovedSubject(), $CCs));
            logAction($user->email, 'MBG Approved', "MBG Approved FSD review of applicant payment", $request->ip());
        }

        return successResponse("Application Updated Successfully");
    }

    public function arCreationRequest(Request $request)
    {
        $ar_creation_request = ArCreationRequest::orderBy('created_at', 'DESC')->get();
        return successResponse("Here you go", $ar_creation_request);
    }

    public function reviewArSystemCreationRequest(Request $request)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'ar_request_id' => 'required|exists:ar_creation_requests,id',
        ]);

        $ar_creation_request = ArCreationRequest::find($request->ar_request_id);

        if ($ar_creation_request->next_office != 'MBG' && $ar_creation_request->mbg_status != 'Pending') {
            errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, "You are not permitted to perform this action at this time");
        }

        $system = $ar_creation_request->system;
        $user = $request->user();

        switch ($request->status) {
            case 'treated':
                $ar_creation_request->mbg_status = ucfirst($request->status);
                $ar_creation_request->next_office = 'MSG';
                $ar_creation_request->save();

                $MSGs = Utility::getUsersByCategory(Role::MSG);
                $MEGs = Utility::getUsersEmailByCategory(Role::MEG);
                $MBGs = Utility::getUsersEmailByCategory(Role::MBG);
                $CCs = array_merge($MBGs, $MEGs);
                Notification::send($MSGs, new InfoNotification(MailContents::mbgApproveProfileArSystemMail($system->name), MailContents::profileArSystemSubject($system->name), $CCs));

                logAction($user->email, 'AR CREATION REQUEST', "AR creation request on FMDQ system was treated by MBG", $request->ip());
                break;

            case 'rejected':
                $ar_creation_request->mbg_status = ucfirst($request->status);
                $ar_creation_request->save();

                $MBGs = Utility::getUsersEmailByCategory(Role::MBG);
                $MEGs = Utility::getUsersEmailByCategory(Role::MEG);
                $MSGs = Utility::getUsersEmailByCategory(Role::MSG);
                $CCs = array_merge($MSGs, $MEGs, $MBGs);

                $applicant = $ar_creation_request->user;
                $applicant->notify(new InfoNotification(MailContents::mbgRejectProfileArSystemMail($system->name), MailContents::mbgRejectProfileArSystemSubject($system->name), $CCs));

                logAction($user->email, 'AR CREATION REQUEST', "AR creation request on FMDQ system was rejected by MBG", $request->ip());

                break;

            default:
                # code...
                break;
        }

        return successResponse("Request status updated successfully");
    }
}
