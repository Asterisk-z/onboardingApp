<?php

namespace App\Traits;

use App\Models\Application;
use App\Models\Invoice;
use App\Models\ProofOfPayment;

trait ApplicationTraits
{
    public function subPaymentInformation($request)
    {
        $application = Application::find($request->application_id);
        $invoice = $application->invoice;

        return successResponse("Here you go", $invoice ?? []);
    }

    public function subLatestEvidence($request)
    {
        $application = Application::find($request->application_id);
        $proof = ProofOfPayment::find($application->proof_of_payment);

        return successResponse("Here you go", $proof ?? []);
    }

    public function subPaymentReviewDetails($request)
    {
        $application = Application::find($request->application_id);
        $invoice = Invoice::find($application->invoice_id);
        $invoiceContents = $invoice->contents; 

        $concession = 0;
        if($con = $invoice->contents()->where('name', 'Concession')->first()){
            $concession = $con->value;
        }

        $total = 0;

        foreach($invoiceContents as $invoiceContent){
            if($invoiceContent->name == 'Concession'){
                continue;
            }
            if($invoiceContent->type == 'credit'){
                $total -= $invoiceContent->value;
            }

            if($invoiceContent->type == 'debit'){
                $total += $invoiceContent->value;
            }
        }

        $data = [
            'concession_amount' => $concession,
            'concession_file' => $application->concession_file ? config('app.url') .'/storage/app/public/'.$application->concession_file : null,
            'total' => $total
        ];

        return successResponse("Here you go", $data ?? []);

    }
}
