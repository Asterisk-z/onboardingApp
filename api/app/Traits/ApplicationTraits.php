<?php

namespace App\Traits;

use App\Models\Application;
use App\Models\Invoice;
use App\Models\ProofOfPayment;

trait ApplicationTraits
{
    public function subPaymentInformation($application_id)
    {
        $application = Application::find($application_id);
        $invoice = Invoice::find($application->invoice_id);

        return $invoice;
    }

    public function subLatestEvidence($application_id)
    {
        $application = Application::find($application_id);
        $proof = ProofOfPayment::find($application->proof_of_payment);

        return $proof;
    }

    public function subPaymentReviewDetails($application_id)
    {
        $application = Application::find($application_id);
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

        return $data;

    }
}
