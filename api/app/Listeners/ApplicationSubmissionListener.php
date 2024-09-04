<?php

namespace App\Listeners;

use App\Events\ApplicationSubmissionEvent;
use App\Helpers\InvoiceGenerator;
use App\Helpers\Utility;
use App\Models\Application;
use App\Models\ApplicationField;
use App\Models\Invoice;
use App\Models\InvoiceContent;
use App\Models\MonthlyDiscount;
use App\Models\Role;
use App\Models\SystemSetting;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApplicationSubmissionListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ApplicationSubmissionEvent  $event
     * @return void
     */
    public function handle(ApplicationSubmissionEvent $event)
    {
        $user = $event->user;
        $application = $event->application;
        $institution = $event->institution;
        $membershipCategory = $event->membershipCategory;

        //Generate Bill and create Invoice
        $this->generateApplicationBill($user, $application, $membershipCategory, $institution);

        //SEND FIRST BATCH OF EMAIL
        $data = ApplicationField::where('name', 'companyEmailAddress')
            ->join('application_field_uploads', function ($join) use ($application) {
                $join->on('application_fields.id', '=', 'application_field_uploads.application_field_id')
                    ->where('application_field_uploads.application_id', '=', $application->id);
            })
            ->select('application_field_uploads.*')
            ->first();

        $companyEmail = $data->uploaded_field ? $data->uploaded_field : $data->uploaded_file;
        $companyEmail = filter_var($companyEmail, FILTER_VALIDATE_EMAIL) ? $companyEmail : '';

        $data = ApplicationField::where('name', 'applicationPrimaryContactEmailAddress')
            ->join('application_field_uploads', function ($join) use ($application) {
                $join->on('application_fields.id', '=', 'application_field_uploads.application_field_id')
                    ->where('application_field_uploads.application_id', '=', $application->id);
            })
            ->select('application_field_uploads.*')
            ->first();

        $contactEmail = $data->uploaded_field ? $data->uploaded_field : $data->uploaded_file;
        $contactEmail = filter_var($contactEmail, FILTER_VALIDATE_EMAIL) ? $contactEmail : '';

        $name = $user->first_name . ' ' . $user->last_name;
        $categoryName = $membershipCategory->name;

        $subject = $this->getSubject($application);

        if ($application) {
            $emailData = [
                'name' => $name,
                'subject' => $subject,
                'content' => "Thank you for your interest in the $categoryName of FMDQ Securities Exchange Limited.
                        We are currently reviewing your application and will provide feedback within three (3) business
                        days.",
            ];
        }

        // Recipient email addresses
        $toEmails = [$user->email, $companyEmail, $contactEmail];

        // CC email addresses
        $Meg = Utility::getUsersEmailByCategory(Role::MEG);
        $ccEmails = $Meg;

        Utility::emailHelper($emailData, $toEmails, $ccEmails);

        //SEND EMAIL TO MEG, MBG and FSD

        $Mbg = Utility::getUsersEmailByCategory(Role::MBG);
        $fsd = Utility::getUsersEmailByCategory(Role::FSD);
        $tos = array_merge($Meg, $Mbg, $fsd);

        $categoryNameWithPronoun = Utility::categoryNameWithPronoun($categoryName);

        $emailD = [
            'name' => 'Team',
            'subject' => $subject,
            'content' => "A new applicant, $name, has successfully submitted
                            an application on the MROIS Portal as $categoryNameWithPronoun.",
        ];

        Utility::emailHelper($emailD, $tos);

        //SEND EMAIL TO MBG cc MEG and MBG for concession
        $to = $Mbg;
        $ccs = array_merge($Meg, $fsd);

        $emailC = [
            'name' => 'Team',
            'subject' => 'New Membership Application: Concession Confirmation',
            'content' => "A new applicant, $name, has successfully submitted an application as $categoryNameWithPronoun
             on the MROIS Portal. Kindly grant a concession (where applicable).",
        ];

        Utility::emailHelper($emailC, $to, $ccs);
    }

    protected function generateApplicationBill($user, $application, $membershipCategory, $institution)
    {
        $year = Carbon::now()->format('Y');
        $discounted_percent = $discounted_amount = $vat = $total = 0;

        $application_fee = $membershipCategory->application_fee;
        $membership_dues = $membershipCategory->membership_dues;

        $application_month = Carbon::now()->format('m');
        if ($discounted = MonthlyDiscount::where('month', $application_month)->first()) {
            $discounted_percent = $discounted->discounted_percent ?? 0;
            $discounted_amount = 0.01 * $discounted_percent * $membership_dues;
        }

        $total = $application_fee + $membership_dues - $discounted_amount;

        if ($tax = SystemSetting::where('name', 'tax')->first()) {
            $tax_val = $tax->value ?? 0;
            $vat = (0.01 * $tax_val) * $total;
        }

        //Create Invoice
        $invoice = Invoice::create([
            'invoice_number' => InvoiceGenerator::generateInvoiceNumber(),
            'reference' => InvoiceGenerator::generateInvoiceReference(),
        ]);

        //Create Invoice content
        if ($application_fee) {
            InvoiceContent::create([
                "invoice_id" => $invoice->id,
                "name" => "{$membershipCategory->name} - Commercial (National) - Application Fee (Non-Refundable)",
                "value" => $application_fee,
                "is_discount" => 0,
                "parent_id" => null,
                "type" => "debit",
            ]);
        }

        $due = null;

        if ($membership_dues) {
            $due = InvoiceContent::create([
                "invoice_id" => $invoice->id,
                "name" => "{$membershipCategory->name} - {$year} Membership Dues",
                "value" => $membership_dues,
                "is_discount" => 0,
                "parent_id" => null,
                "type" => "debit",
            ]);
        }

        if ($discounted_amount && $due) {
            InvoiceContent::create([
                "invoice_id" => $invoice->id,
                "name" => "{$discounted_percent}% Discount on {$year} Membership Dues",
                "value" => $discounted_amount,
                "is_discount" => 1,
                "parent_id" => $due->id,
                "type" => "credit",
            ]);
        }

        if ($vat) {
            InvoiceContent::create([
                "invoice_id" => $invoice->id,
                "name" => "VAT",
                "value" => $vat,
                "is_discount" => 0,
                "parent_id" => null,
                "type" => "debit",
            ]);
        }

        //assignment
        $application->invoice_id = $invoice->id;
        $application->save();
        $application->invoice()->save($invoice);

        return;
    }

    protected function getSubject($application)
    {
        $type = $application->application_type;

        switch ($type) {
            case Application::type['CON']:
                $subject = 'New Membership Conversion';
                break;
            case Application::type['ADD']:
                $subject = 'New Membership Addition';
                break;
            default:
                $subject = 'New Membership Application';
                break;
        }

        return $subject;
    }
}
