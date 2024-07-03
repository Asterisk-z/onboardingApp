<?php
namespace App\Helpers;

use App\Models\Invoice;
use Carbon\Carbon;

class InvoiceGenerator
{

    public static function generateInvoiceNumber()
    {
        $year = Carbon::now()->format('Y');
        $nextInvoiceNumber = self::getNextInvoiceNumber();

        return "INV{$year}{$nextInvoiceNumber}";
    }

    public static function generateInvoiceReference()
    {
        $yearMonth = Carbon::now()->format('Y-m');
        $nextReferenceNumber = self::getNextReferenceNumber();

        return "MR{$nextReferenceNumber}";
        // return "REF{$yearMonth}-{$nextReferenceNumber}";

    }

    private static function getNextInvoiceNumber()
    {
        $invoice = Invoice::all();
        return self::padToDigits(count($invoice) + 1, 6);
    }

    private static function getNextReferenceNumber()
    {
        $invoice = Invoice::all();
        return self::padToDigits(count($invoice) + 1, 4);
    }

    private static function padToDigits($number, $lenght)
    {
        return str_pad($number, $lenght, '0', STR_PAD_LEFT);
    }

}
