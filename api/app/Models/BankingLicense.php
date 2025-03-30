<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankingLicense extends Model
{
    use HasFactory;

    const licenses = [
            [
                "category" => "1",
                "field_name" => "bankingLicense",
                "option_name" => "Commercial-International/National Banking Licence",
                "option_value" => "internationalBankingLicence",
                "application_fee"      =>  33750000.00,
                "membership_dues"      => 2000000.00,
            ],
            [
                "category" => "1",
                "field_name" => "bankingLicense",
                "option_name" => "Commercial Merchant Banking Licence",
                "option_value" => "merchantBankingLicence",
                "application_fee"      => 30000000.00,
                "membership_dues"      =>2000000.00,
            ],
            [
                "category" => "1",
                "field_name" => "bankingLicense",
                "option_name" => "Commercial Regional Banking Licence",
                "option_value" => "regionalBankingLicence",
                "application_fee"      => 22500000.00,
                "membership_dues"      =>2000000.00,
            ],
            [
                "category" => "1",
                "field_name" => "bankingLicense",
                "option_name" => "Non-Interest Banking Licence",
                "option_value" => "nonInterestBankingLicence",
                "application_fee"      => 22500000.00,
                "membership_dues"      =>2000000.00,
            ],
            [
                "category" => "1",
                "field_name" => "bankingLicense",
                "option_name" => "Motgage National/State Banking Licence",
                "option_value" => "motgageBankingLicence",
                "application_fee"      => 10000000.00,
                "membership_dues"      =>2000000.00,
            ]
        ];






}
