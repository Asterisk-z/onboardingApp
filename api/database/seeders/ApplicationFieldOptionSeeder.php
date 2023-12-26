<?php

namespace Database\Seeders;

use App\Models\ApplicationFieldOption;
use Illuminate\Database\Seeder;

class ApplicationFieldOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ApplicationFieldOption::query()->truncate();
        $fields = [
            [
                "category" => "dmb",
                "field_name" => "bankingLicense",
                "option_name" => "International Banking Licence",
                "option_value" => "internationalBankingLicence",
            ],
            [
                "category" => "dmb",
                "field_name" => "bankingLicense",
                "option_name" => "National Banking Licence",
                "option_value" => "nationalBankingLicence",
            ],
            [
                "category" => "dmb",
                "field_name" => "bankingLicense",
                "option_name" => "Regional Banking Licence",
                "option_value" => "regionalBankingLicence",
            ],
            [
                "category" => "dmb",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "₦",
                "option_value" => "₦",
            ],
            [
                "category" => "dmb",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "$",
                "option_value" => "$",
            ],
            [
                "category" => "dmb",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "C$",
                "option_value" => "C$",
            ],
            [
                "category" => "dmb",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "Fr",
                "option_value" => "Fr",
            ],
            [
                "category" => "dmb",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "€",
                "option_value" => "€",
            ],
            [
                "category" => "dmb",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "£",
                "option_value" => "£",
            ],
            [
                "category" => "dmb",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "¥",
                "option_value" => "¥",
            ],
            [
                "category" => "dmb",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "R",
                "option_value" => "R",
            ],

            [
                "category" => "dmb",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "₦",
                "option_value" => "₦",
            ],
            [
                "category" => "dmb",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "$",
                "option_value" => "$",
            ],
            [
                "category" => "dmb",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "C$",
                "option_value" => "C$",
            ],
            [
                "category" => "dmb",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "Fr",
                "option_value" => "Fr",
            ],
            [
                "category" => "dmb",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "€",
                "option_value" => "€",
            ],
            [
                "category" => "dmb",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "£",
                "option_value" => "£",
            ],
            [
                "category" => "dmb",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "¥",
                "option_value" => "¥",
            ],
            [
                "category" => "dmb",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "R",
                "option_value" => "R",
            ],
            [
                "category" => "dmb",
                "field_name" => "productOfInterest",
                "option_name" => "Bonds",
                "option_value" => "bonds",
            ],
            [
                "category" => "dmb",
                "field_name" => "productOfInterest",
                "option_name" => "treasuryBills ",
                "option_value" => "Treasury Bills",
            ],
            [
                "category" => "dmb",
                "field_name" => "productOfInterest",
                "option_name" => "commercialPapers",
                "option_value" => "Commercial Papers",
            ],
            [
                "category" => "dmb",
                "field_name" => "productOfInterest",
                "option_name" => "Money Market",
                "option_value" => "Money Market",
            ],
            [
                "category" => "dmb",
                "field_name" => "productOfInterest",
                "option_name" => "foreignExchange",
                "option_value" => "Foreign Exchange",
            ],
            [
                "category" => "dmb",
                "field_name" => "productOfInterest",
                "option_name" => "Derivatives",
                "option_value" => "derivatives",
            ],
            [
                "category" => "dmb",
                "field_name" => "productOfInterest",
                "option_name" => "Others",
                "option_value" => "others",
            ],
            [
                "category" => "dmb",
                "field_name" => "directionOfTrades",
                "option_name" => "buy",
                "option_value" => "buy",
            ],
            [
                "category" => "dmb",
                "field_name" => "directionOfTrades",
                "option_name" => "sell",
                "option_value" => "sell",
            ],
            [
                "category" => "dmb",
                "field_name" => "directionOfTrades",
                "option_name" => "both",
                "option_value" => "both",
            ],
            // [
            //     "category" => "dmb",
            //     "field_name" => "bankingLicense",
            //     "option_name" => "dede",
            //     "option_value" => "dede",
            // ],
            // [
            //     "category" => "dmb",
            //     "field_name" => "bankingLicense",
            //     "option_name" => "dede",
            //     "option_value" => "dede",
            // ],
        ];

        foreach ($fields as $field) {
            if (ApplicationFieldOption::where('category', $field['category'])->where('field_name', $field['field_name'])->where('option_value', $field['option_value'])->exists()) {
                continue;
            }

            ApplicationFieldOption::create([
                "category" => $field['category'],
                "field_name" => $field['field_name'],
                "option_name" => $field['option_name'],
                "option_value" => $field['option_value'],
            ]);
        }
    }
}
