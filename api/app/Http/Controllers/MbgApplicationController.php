<?php

namespace App\Http\Controllers;

use App\Helpers\MailContents;
use App\Helpers\Utility;
use App\Models\Application;
use App\Models\Invoice;
use App\Models\Role;
use App\Models\SystemSetting;
use App\Models\User;
use App\Notifications\InfoNotification;
use App\Traits\ApplicationTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
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
            'office_to_perform_next_action' => Application::office['MBG']
        ]);

        $data = Utility::applicationDetails($data);
        $data = $data->get();

        return successResponse("Here you go", $data ?? []);
    }

    public function paymentInformation(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:applications,id'
        ]);

        return $this->subPaymentInformation($request);
    }

    public function latestEvidence(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:applications,id'
        ]);

        return $this->subLatestEvidence($request);
    }

    public function paymentReviewDetails(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:applications,id'
        ]);

        return $this->subPaymentReviewDetails($request);

    }

    public function fsdReviewSummary(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:applications,id'
        ]);

        $application = Application::find($request->application_id);
        
        $comment = $application->statusModel() ? $application->statusModel()->comment : null;
        
        $data = [
            'fsd_comment' => $comment,
            "fsd_received_amount" => $application->amount_received_by_fsd
        ];

        return successResponse("Here you go", $data ?? []);
    }

    public function concession(Request $request){
        $request->validate([
            'concession_amount' => 'sometimes|nullable|numeric|min:100',
            'concession_file' => 'sometimes|nullable|mimes:jpeg,png,jpg,pdf,doc,docx,csv,xls,xlsx|max:5048',
            "application_id" => 'required|exists:applications,id'
        ]);

        $user = $request->user();
        $application = Application::find($request->application_id);
        $apllication_details = Application::where([
            'applications.id'  => $request->application_id
        ]);
        $apllication_details = Utility::applicationDetails($apllication_details);
        $apllication_details = $apllication_details->first();

        $errorMsg = "Unable to complete your request at this point.";
        if($application->office_to_perform_next_action != Application::office['MBG']){
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        if($application->currentStatus() != Application::statuses['ACS']){
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        if($request->concession_amount && ! $request->concession_file){
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, "An approval mandate is required to grant concession.");
        }

        if($request->concession_amount){
            $concession_file = $request->hasFile('concession_file') ? $request->file('concession_file')->storePublicly('concession', 'public') : null;

            $invoice = Invoice::find($application->invoice_id);

            $invoice->contents()->create([
                "name" => "Concession",
                "value" => strip_tags($request->concession_amount),
                "is_discount" => 1,
                "parent_id" => null,
                "type" => "credit"
            ]);

            $invoiceContents = $invoice->contents;
            $total = $vat = 0;

            foreach($invoiceContents as $invoiceContent){
                if($invoiceContent->name == 'VAT'){
                    continue;
                }
                if($invoiceContent->type == 'credit'){
                    $total -= $invoiceContent->value;
                }

                if($invoiceContent->type == 'debit'){
                    $total += $invoiceContent->value;
                }
            }

            if($vatContent = $invoice->contents()->where('name', 'VAT')->first()){
                if($tax = SystemSetting::where('name', 'tax')->first()){
                    $tax_val = $tax->value ?? 0;
                    $vat = (0.01 * $tax_val) * $total;
                }
                $vatContent->value = $vat;
                $vatContent->save();
            }

            logAction($user->email, 'Concession added', "Concession was granted to {$apllication_details->company_name}.", $request->ip());
        }

        Utility::applicationStatusHelper($application, Application::statuses['APU'], Application::office['AP']);
        
        $application = $application->refresh();
        $application->concession_stage = true;
        $application->concession_file = $concession_file ?? null;
        $application->save();

        logAction($user->email, 'Concession stage Passed', "Application successfully passed through concession stage.", $request->ip());

        //Notify applicant
        $applicant = $application->applicant;
        $applicant->notify(new InfoNotification(MailContents::invoiceMail(), MailContents::invoiceSubject()));

        //Notify fsd if concession was added
        if($request->concession_amount){
            $MBGs = Utility::getUsersEmailByCategory(Role::MBG);
            $MEGs = Utility::getUsersEmailByCategory(Role::MEG);
            $FSDs = Utility::getUsersByCategory(Role::FSD);
            $CCs = array_merge($MBGs, $MEGs);
            Notification::send($FSDs, new InfoNotification(MailContents::concessionMail($apllication_details->company_name), MailContents::concessionSubject(), $CCs));
        }

        return successResponse("Application Updated Successfully");
    }

    public function mbgReview(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:applications,id',
            'status' => 'required|in:decline,approve',
            'comment' => 'required|string'
        ]);

        $user = $request->user();
        $application = Application::find($request->application_id);

        $errorMsg = "Unable to complete your request at this point.";
        if($application->office_to_perform_next_action != Application::office['MBG']){
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        $applicant = User::find($application->submitted_by);
        $institution = $application->institution;
        $membershipCategory = $institution->membershipCategories->first();
        $name = $applicant->first_name.' '.$applicant->last_name;

        $data = Application::where('applications.id', $request->application_id);
        $data = Utility::applicationDetails($data);
        $data = $data->first();

        if($request->status == 'decline'){
            if(str_contains(strtolower("Incomplete Payment"), strtolower($request->comment))){
                $companyEmail = $data->company_email; 
                $contactEmail = $data->primary_contact_email;

                $categoryName = $membershipCategory->name;

                $emailData = [
                    'name' => $name,
                    'subject' => 'Membership Application Payment Declined',
                    'content' => "Please be informed that your payment as a {$categoryName} was declined.
                            <p>Reason: {$request->comment}</p>
                            <p>Kindly contact Uju Iwuamadi +234 -1-2778771</p>"
                ];
                
                // Recipient email addresses
                $toEmails = [$applicant->email, $companyEmail, $contactEmail];
                
                // CC email addresses
                $Meg = Utility::getUsersEmailByCategory(Role::MEG);
                $Mbg = Utility::getUsersEmailByCategory(Role::MBG);
                $fsd = Utility::getUsersEmailByCategory(Role::FSD);
                $ccEmails = array_merge($Meg, $Mbg, $fsd);

                Utility::emailHelper($emailData, $toEmails, $ccEmails);
                Utility::applicationStatusHelper($application, Application::statuses['APU'], Application::office['AP'], $request->comment);
            }else{
                Utility::applicationStatusHelper($application, Application::statuses['MRF'], Application::office['FSD'], $request->comment);
                $application = $application->refresh();

                $MBGs = Utility::getUsersEmailByCategory(Role::MBG);
                $MEGs = Utility::getUsersEmailByCategory(Role::MEG);
                $FSDs = Utility::getUsersByCategory(Role::FSD);
                $CCs = array_merge($MBGs, $MEGs);
                Notification::send($FSDs, new InfoNotification(MailContents::mbgPaymentRejectedMail($data->company_name, $request->comment), MailContents::mbgPaymentRejectedSubject(), $CCs));
                logAction($user->email, 'MBG Declined', "MBG Declined FSD review of applicant payment", $request->ip());
            }
        }

        if($request->status == 'approve'){
            Utility::applicationStatusHelper($application, Application::statuses['AER'], Application::office['MEG'], $request->comment);
            $application = $application->refresh();
            $application->mbg_review_stage = 1;
            $application->save();
            
            $MBGs = Utility::getUsersEmailByCategory(Role::MBG);
            $MEGs = Utility::getUsersByCategory(Role::MEG);
            $CCs = $MBGs;
            Notification::send($MEGs, new InfoNotification(MailContents::mbgPaymentApprovedMail($data->company_name), MailContents::mbgPaymentApprovedSubject(), $CCs));
            logAction($user->email, 'MBG Approved', "MBG Approved FSD review of applicant payment", $request->ip());
        }

        return successResponse("Application Updated Successfully");
    }
}
