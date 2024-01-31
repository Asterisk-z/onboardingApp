<?php

namespace App\Http\Controllers;

use App\Events\ApplicationSubmissionEvent;
use App\Helpers\MailContents;
use App\Helpers\ResponseStatusCodes;
use App\Helpers\Utility;
use App\Models\Application;
use App\Models\ApplicationExtra;
use App\Models\ApplicationField;
use App\Models\ApplicationFieldOption;
use App\Models\ApplicationFieldUpload;
use App\Models\Invoice;
use App\Models\ProofOfPayment;
use App\Models\Role;
use App\Models\User;
use App\Notifications\InfoNotification;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Rmunate\Utilities\SpellNumber;
use Symfony\Component\HttpFoundation\Response;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Storage;
use NumberFormatter;

class MembershipApplicationController extends Controller
{
    public function application(Request $request)
    {
        $user = $request->user();

        $data = Application::where([
            'submitted_by' => $user->id,
        ]);

        $data = Utility::applicationDetails($data);
        $data = $data->first();

        return successResponse("Here you go", $data ?? []);
    }

    public function getField(Request $request)
    {
        $application_fields = ApplicationField::where('parent_id', null);

        if ($request->page) {
            $application_fields->where('page', $request->page);
        }

        if ($request->category) {
            $application_fields->where('category', $request->category);
        }

        $data = $application_fields->orderBy('id', 'ASC')->get();

        return successResponse('Fields Fetched Successfully', $data);
    }

    public function getFieldExtra(Request $request)
    {
        $application_fields = ApplicationExtra::query();
        $data = [];

        if ($request->category && $request->name) {
            $application_fields->where('category_id', $request->category)->where('name', $request->name);
            $data = $application_fields->orderBy('id', 'ASC')->first();
        }

        return successResponse('Fields Fetched Successfully', $data);
    }

    public function getFieldOption(Request $request)
    {
        $application_fields = ApplicationFieldOption::query();

        if ($request->category) {
            $application_fields->where('category', $request->category);
        }

        if ($request->field_name) {
            $application_fields->where('field_name', $request->field_name);
        }

        $data = $application_fields->orderBy('id', 'ASC')->get();

        return successResponse('Fields Fetched Successfully', $data);
    }

    public function uploadField(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required',
            'field_name' => 'required',
            'field_value' => 'required',
            'field_type' => 'required',
        ]);

        if (!ApplicationField::where('category', $request->category_id)
            ->where('name', $request->field_name)
            ->where('type', $request->field_type)->exists()) {
            return;
        }

        $applicationField = ApplicationField::where('category', $request->category_id)
            ->where('name', $request->field_name)
            ->where('type', $request->field_type)->first();

        $data = ['uploaded_field' => $request->field_value];

        if (auth()->user()->institution->application->status == Application::AWAITINGAPPROVAL) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, "Your application has already been submitted and it is currently under review.");
        }

        if ($request->field_type == 'file') {

            if ($request->hasFile('field_value')) {
                $attachment = Utility::saveFile('application/' . auth()->user()->institution->application->id . '/' . $request->field_name, $request->file('field_value'));
            }
            $data['uploaded_field'] = null;
            $data = ['uploaded_file' => $attachment['path']];
        }

        ApplicationFieldUpload::updateOrCreate(
            ['application_field_id' => $applicationField->id, 'application_id' => auth()->user()->institution->application->id],
            $data
        );

        return successResponse('Fields Fetched Successfully', auth()->user()->institution->application);
    }

    /**
     * This method does the final submission of an application
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function complete(Request $request)
    {
        //Get authenticated user
        $user = auth()->user();

        $application_id = $user->institution->application->id;

        //Get the application model
        $application = Application::find($application_id);

        $errorMsg = "Unable to complete your request at this point.";

        if (strtolower($application->currentStatus()) != strtolower(Application::statuses['PEN'])) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        if ($application->office_to_perform_next_action != Application::office['AP']) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        //Get the insitution from the application
        $institution = $application->institution;

        if (!$institution) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        //Checks that the institution returned is the same as that of the authenticated user
        if ($user->institution_id != $institution->id) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        //Get the first membership of an institution
        $membershipCategory = $institution->membershipCategories->first();

        if (!$membershipCategory) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        //Get all the required fields per membership category
        $requiredFieldIds = $membershipCategory->fields->where('required', 1)->pluck('id')->toArray();

        //Check for any missing required field by comparing what is required and all that was uploaded
        $applicationFieldIds = $application->uploads->pluck('application_field_id')->toArray();

        $missingFieldIds = array_diff(
            $requiredFieldIds,
            $applicationFieldIds
        );

        if (!empty($missingFieldIds)) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, "Submission failed. There are required fields you are yet to fill.");
        }

        Utility::applicationStatusHelper($application, Application::statuses['AS'], Application::office['AP'], Application::office['MBG']);

        logAction($user->email, 'Application submitted', 'Membership application has been submitted successfully.', $request->ip());
        event(new ApplicationSubmissionEvent($user, $application, $institution, $membershipCategory));
        return successResponse("Your Application has been submitted and is under review. You will be notified any feedback soon");
    }

    public function downloadInvoice(Request $request)
    {
        $user = $request->user();
        $application = Application::find($request->application_id);

        $errorMsg = "Unable to complete your request at this point.";

        if ($application->submitted_by != $user->id) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }
        
        // Download the stored PDF
        return response()->json([
            "file_path" => route('invoice', ['uuid' => $application->invoiceToken])
        ]);
    }

    public function downloadApplicantInvoice($invoiceToken)
    {
        $application = Application::where('invoiceToken', $invoiceToken)->first();
        $applicant = $application->applicant;
        $invoice = Invoice::find($application->invoice_id);
        $invoiceContents = $invoice->contents;

        $total = $vat = 0;

        foreach ($invoiceContents as $invoiceContent) {
            if ($invoiceContent->name == 'VAT') {
                $vat += $invoiceContent->value;
            }

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

        $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        
        $amountDue = number_format($total + $vat, 2);
        $amountInWords = $f->format($total + $vat);
        $total = number_format($total, 2);
        $vat = number_format($vat, 2);

        return view('invoice', compact('invoice','invoiceContents', 'applicant', 'vat', 'total', 'amountInWords', 'amountDue'));
    }

    /**
     * This method does the final submission of an application
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadProofOfPayment(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:applications,id',
            'proof_of_payment' => 'required|mimes:jpeg,png,jpg,pdf,doc,docx,csv,xls,xlsx|max:5048',
        ]);

        $user = $request->user();
        $application = Application::find($request->application_id);
        $invoice = Invoice::find($application->invoice_id);

        $errorMsg = "Unable to complete your request at this point.";

        if ($application->office_to_perform_next_action != Application::office['AP']) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        if (
            $application->currentStatus() != Application::statuses['CG'] &&
            $application->currentStatus() != Application::statuses['CNG'] &&
            $application->currentStatus() != Application::statuses['FDP'] &&
            $application->currentStatus() != Application::statuses['MDP']
        ) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        if ($application->submitted_by != $user->id) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        $proof = ProofOfPayment::create([
            'proof' => $request->file('proof_of_payment')->storePublicly('proof_of_payment', 'public'),
        ]);

        Utility::applicationStatusHelper($application, Application::statuses['PPU'], Application::office['AP'], Application::office['FSD']);
        $application->proof_of_payment = $proof->id;
        $application->save();

        $application->proof_of_payment()->save($proof);

        $invoice->date_paid = Carbon::now()->format('Y-m-d');
        $invoice->is_paid = 1;
        $invoice->save();

        logAction($user->email, 'Proof of payment uploaded', "Applicant successfully uploaded proof of payment.", $request->ip());

        $MBGs = Utility::getUsersEmailByCategory(Role::MBG);
        $MEGs = Utility::getUsersEmailByCategory(Role::MEG);
        $FSDs = Utility::getUsersByCategory(Role::FSD);
        $CCs = array_merge($MBGs, $MEGs);
        Notification::send($FSDs, new InfoNotification(MailContents::paymentMail($user), MailContents::paymentSubject(), $CCs));

        return successResponse("Your payment upload has been recieved and it is currently under review");
    }

    public function uploadMemberAgreement(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:applications,id',
            'executed_member_agreement' => 'required|mimes:jpeg,png,jpg,pdf,doc,docx,csv,xls,xlsx|max:5048',
        ]);

        $user = $request->user();
        $application = Application::find($request->application_id);
        $applicant = User::find($application->submitted_by);
        $name = $applicant->first_name . ' ' . $applicant->last_name;

        $errorMsg = "Unable to complete your request at this point.";

        if ($application->office_to_perform_next_action != Application::office['AP']) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        if ($application->currentStatus() != Application::statuses['M2AMR']) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        if ($application->submitted_by != $user->id) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        if ($application->is_applicant_executed_membership_agreement) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        $application->applicant_executed_membership_agreement = $request->hasFile('executed_member_agreement') ? $request->file('executed_member_agreement')->storePublicly('applicant_executed_member_agreement', 'public') : null;
        $application->is_applicant_executed_membership_agreement = 1;
        $application->save();

        logAction($user->email, 'Membership agreement uploaded by applicant', "Executed membership agreement uploaded by applicant.", $request->ip());
        Utility::applicationStatusHelper($application, Application::statuses['AEM'], Application::office['AP'], Application::office['MEG']);

        $MEGs = Utility::getUsersByCategory(Role::MEG);
        Notification::send($MEGs, new InfoNotification(MailContents::applicantUploadAgreementMail($name), MailContents::applicantUploadAgreementSubject()));

        return successResponse("Agreement uploaded successfully");
    }
}
