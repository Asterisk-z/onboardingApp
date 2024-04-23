<?php

namespace App\Http\Controllers;

use App\Events\ApplicationSubmissionEvent;
use App\Helpers\MailContents;
use App\Helpers\ResponseStatusCodes;
use App\Helpers\Utility;
use App\Http\Resources\ApplicationFieldResource;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use App\Models\ApplicationExtra;
use App\Models\ApplicationField;
use App\Models\ApplicationFieldApplicationFieldUpload;
use App\Models\ApplicationFieldOption;
use App\Models\ApplicationFieldUpload;
use App\Models\Invoice;
use App\Models\ProofOfPayment;
use App\Models\Role;
use App\Models\User;
use App\Notifications\InfoNotification;
use App\Services\FactoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use NumberFormatter;
use Symfony\Component\HttpFoundation\Response;

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

    public function getDetail(Request $request)
    {
        $user = $request->user();
        $data = [];
        $application = Application::where(['uuid' => $request->application_uuid])->first();
        $application_requirements = ApplicationFieldUpload::where('application_id', $application->id)->with('field')->get();

        $data = [
            'application' => $application,
            'application_requirements' => $application_requirements,
        ];

        return successResponse("Here you go", $data ?? []);
    }

    public function getInitial(Request $request)
    {
        $user = $request->user();
        $data = [];
        $application = Application::where(['uuid' => $request->application_uuid])->first();

        if ($application->application_type == Application::type['CON']) {
            $application = Application::where(['institution_id' => $application->institution_id, 'membership_category_id' => $application->old_membership_category_id, 'application_type_status' => Application::typeStatus['ASC']])->first();
        } else {
            $application = Application::where(['institution_id' => $application->institution_id, 'application_type_status' => Application::typeStatus['ASC']])->first();

        }
        $application_requirements = ApplicationFieldUpload::where('application_id', $application->id)->with('field')->get();

        $data = [
            'application' => $application,
            'application_requirements' => $application_requirements,
        ];

        return successResponse("Here you go", $data ?? []);
    }

    public function getPreview(Request $request)
    {
        // $application = Application::find($request->application_id);

        $data = Application::where([
            'applications.id' => $request->application_id,
        ]);

        $data = Utility::applicationDetails($data);
        $data = $data->get();

        return successResponse("Here you go", ApplicationResource::collection($data));

        $application_fields = ApplicationField::where('application_fields.parent_id', null);

        if ($request->page) {
            $application_fields->where('application_fields.page', $request->page);
        }

        if ($request->category) {
            $application_fields->where('application_fields.category', $request->category);
        }

        $application_fields->leftJoin('application_field_application_field_uploads', function ($join) use ($request) {
            $join->on('application_field_application_field_uploads.application_field_id', '=', 'application_fields.id')
                ->where('application_field_application_field_uploads.application_id', $request->application_id);
        })->leftJoin('application_field_uploads', 'application_field_application_field_uploads.application_field_upload_id', '=', 'application_field_uploads.id')
            ->select('application_fields.*', 'application_field_uploads.uploaded_file', 'application_field_uploads.uploaded_field', DB::raw('application_field_uploads.id as application_field_upload_id'));

        $data = $application_fields->orderBy('application_fields.id', 'ASC')->get();

        return successResponse('Fields Fetched Successfully', ApplicationFieldResource::collection($data));
    }

    public function getField(Request $request)
    {
        // $application = Application::find($request->application_id);
        $application_fields = ApplicationField::where('application_fields.parent_id', null);

        if ($request->page) {
            $application_fields->where('application_fields.page', $request->page);
        }

        if ($request->category) {
            $application_fields->where('application_fields.category', $request->category);
        }

        $application_fields->leftJoin('application_field_application_field_uploads', function ($join) use ($request) {
            $join->on('application_field_application_field_uploads.application_field_id', '=', 'application_fields.id')
                ->where('application_field_application_field_uploads.application_id', $request->application_id);
        })->leftJoin('application_field_uploads', 'application_field_application_field_uploads.application_field_upload_id', '=', 'application_field_uploads.id')
            ->select('application_fields.*', 'application_field_uploads.uploaded_file', 'application_field_uploads.uploaded_field', DB::raw('application_field_uploads.id as application_field_upload_id'));

        $data = $application_fields->orderBy('application_fields.id', 'ASC')->get();

        return successResponse('Fields Fetched Successfully', ApplicationFieldResource::collection($data));
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

    public function retainField(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required',
            'field_name' => 'required',
            'field_value' => 'required',
            'field_type' => 'required',
            'application_id' => 'required',
        ]);

        $application = Application::find($request->application_id);

        if (!ApplicationField::where('category', $request->category_id)
            ->where('name', $request->field_name)
            ->where('type', $request->field_type)->exists() || !$application) {
            return;
        }

        $applicationField = ApplicationField::where('category', $request->category_id)
            ->where('name', $request->field_name)
            ->where('type', $request->field_type)->first();

        $data = ['uploaded_field' => $request->field_value];

        if ($application->status == Application::AWAITINGAPPROVAL) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, "Your application has already been submitted and it is currently under review.");
        }

        if ($request->field_type == 'file') {
            $data['uploaded_field'] = null;
            $data = ['uploaded_file' => $request->field_value];
        }

        $upload_action = ApplicationFieldUpload::updateOrCreate(
            ['application_field_id' => $applicationField->id, 'application_id' => $application->id],
            $data
        );

        ApplicationFieldApplicationFieldUpload::updateOrCreate(
            [
                'application_id' => $application->id,
                'application_field_id' => $applicationField->id,
                'application_field_upload_id' => $upload_action->id,
            ],
            [
                'application_id' => $application->id,
                'application_field_id' => $applicationField->id,
                'application_field_upload_id' => $upload_action->id,
            ]);

        return successResponse('Fields Fetched Successfully', auth()->user()->institution->application);
    }

    public function uploadField(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required',
            'field_name' => 'required',
            'field_value' => 'required',
            'field_type' => 'required',
            'application_id' => 'required',
        ]);

        $application = Application::find($request->application_id);

        if (!ApplicationField::where('category', $request->category_id)
            ->where('name', $request->field_name)
            ->where('type', $request->field_type)->exists() || !$application) {
            return;
        }

        $applicationField = ApplicationField::where('category', $request->category_id)
            ->where('name', $request->field_name)
            ->where('type', $request->field_type)->first();

        $data = ['uploaded_field' => $request->field_value];

        if ($application->status == Application::AWAITINGAPPROVAL) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, "Your application has already been submitted and it is currently under review.");
        }

        if ($request->field_type == 'file') {

            $attachment = null;

            if ($request->hasFile('field_value')) {
                $attachment = $request->file('field_value')->storePublicly('application', 'public');
            }
            $data['uploaded_field'] = null;
            $data = ['uploaded_file' => $attachment];
        }

        $upload_action = ApplicationFieldUpload::updateOrCreate(
            ['application_field_id' => $applicationField->id, 'application_id' => $application->id],
            $data
        );

        ApplicationFieldApplicationFieldUpload::updateOrCreate(
            [
                'application_id' => $application->id,
                'application_field_id' => $applicationField->id,
                'application_field_upload_id' => $upload_action->id,
            ],
            [
                'application_id' => $application->id,
                'application_field_id' => $applicationField->id,
                'application_field_upload_id' => $upload_action->id,
            ]);

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
        $request->validate([
            'application_id' => 'required|exists:applications,id',
        ]);
        //Get authenticated user
        $user = auth()->user();

        $application_id = $request->application_id;

        //Get the application model
        $application = Application::find($application_id);

        $errorMsg = "Unable to complete your request at this point.";

        if ($application->reupload) {
            return $this->processReupload($request);
        }

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
        $membershipCategory = $application->membershipCategory;

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
        return successResponse("Your Application has been submitted and is under review. You will be notified of any feedback soon");
    }

    protected function processReupload(Request $request)
    {
        $user = auth()->user();

        $application_id = $request->application_id;

        //Get the application model
        $application = Application::find($application_id);
        $applicant = User::find($application->submitted_by);
        $applicantName = $applicant->first_name . " " . $applicant->last_name;

        $errorMsg = "Unable to complete your request at this point.";

        if (strtolower($application->currentStatus()) != strtolower(Application::statuses['MDD'])) {
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
        $membershipCategory = $application->membershipCategory;

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

        Utility::applicationStatusHelper($application, Application::statuses['ARD'], Application::office['AP'], Application::office['MEG']);

        logAction($user->email, 'Application re-uploaded', 'Membership application has been re-uploaded successfully.', $request->ip());
        $MEGs = Utility::getUsersByCategory(Role::MEG);
        Notification::send($MEGs, new InfoNotification(MailContents::documentReuploadMail($applicantName), MailContents::documentReuploadSubject()));

        return successResponse("Your Application has been submitted and is under review. You will be notified of any feedback soon");
    }

    public function disclosure(Request $request)
    {
        $request->validate([
            'status' => 'required',
        ]);
        $user = $request->user();

        $application = Application::find($request->application_id);

        $errorMsg = "Unable to complete your request at this point.";

        if ($application->submitted_by != $user->id || $application->disclosure_stage) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        $application->disclosure_stage = 1;
        $application->disclosure_status = $request->status == 'accept' ? 1 : 0;

        $application->save();

        return successResponse("Disclosure completed you can continue application");

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
            "file_path" => route('invoice', ['uuid' => $application->invoiceToken]),
        ]);
    }

    public function downloadApplicantInvoice($invoiceToken)
    {
        // set_time_limit(300);

        $application = Application::where('invoiceToken', $invoiceToken)->first();
        if (!$application) {
            abort(404, "Unable to fulfil your request");
        }
        $applicant = $application->applicant;
        $invoice = Invoice::find($application->invoice_id);
        $invoiceContents = $invoice->contents;

        $data = Application::where('applications.id', $application->id);
        $data = Utility::applicationDetails($data);
        $data = $data->first();
        $address = $data->registeredOfficeAddress;
        $companyName = $data->company_name;

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

        // $pdfC = view('letter')->render();
        // return PDF::loadHTML($pdfC)->download('letter.pdf');

        return view('invoice', compact('invoice', 'invoiceContents', 'applicant', 'vat', 'total', 'amountInWords', 'amountDue', 'address', 'companyName'));
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

        if ($invoice->is_paid) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, "Payment has already been made for this application.");
        }

        $proof = ProofOfPayment::create([
            'proof' => $request->file('proof_of_payment')->storePublicly('proof_of_payment', 'public'),
        ]);

        Utility::applicationStatusHelper($application, Application::statuses['PPU'], Application::office['AP'], Application::office['FSD']);
        $application->proof_of_payment = $proof->id;
        $application->save();

        $application->proof_of_payment()->save($proof);

        logAction($user->email, 'Proof of payment uploaded', "Applicant successfully uploaded proof of payment.", $request->ip());

        $MBGs = Utility::getUsersEmailByCategory(Role::MBG);
        $MEGs = Utility::getUsersEmailByCategory(Role::MEG);
        $FSDs = Utility::getUsersByCategory(Role::FSD);
        $CCs = array_merge($MBGs, $MEGs);
        Notification::send($FSDs, new InfoNotification(MailContents::paymentMail($user), MailContents::paymentSubject(), $CCs));

        return successResponse("Payment has been processed and under review");
    }

    public function onlinePayment(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:applications,id',
        ]);

        $user = $request->user();
        $application = Application::find($request->application_id);
        $invoice = Invoice::find($application->invoice_id);

        $errorMsg = "Unable to complete your request at this point.";

        if ($application->submitted_by != $user->id) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        if ($invoice->is_paid) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, "Payment has already been made for this application.");
        }

        $total = Utility::getTotalFromInvoice($invoice);

        try {
            $service = FactoryService::createService();
            $response = $service->handle($user, $invoice->reference, $total);

            if ($response['statusCode'] == "00") {
                return successResponse("Please proceed to payment", $response["data"]);
            } else {
                return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, "Unable to process your request");
            }
        } catch (\InvalidArgumentException $exception) {
            logger($exception);
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
