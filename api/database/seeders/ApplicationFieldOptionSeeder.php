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
                "category" => "1",
                "field_name" => "bankingLicense",
                "option_name" => "International Banking Licence",
                "option_value" => "internationalBankingLicence",
            ],
            [
                "category" => "1",
                "field_name" => "bankingLicense",
                "option_name" => "National Banking Licence",
                "option_value" => "nationalBankingLicence",
            ],
            [
                "category" => "1",
                "field_name" => "bankingLicense",
                "option_name" => "Regional Banking Licence",
                "option_value" => "regionalBankingLicence",
            ],
            [
                "category" => "1",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "₦",
                "option_value" => "₦",
            ],
            [
                "category" => "1",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "$",
                "option_value" => "$",
            ],
            [
                "category" => "1",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "C$",
                "option_value" => "C$",
            ],
            [
                "category" => "1",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "Fr",
                "option_value" => "Fr",
            ],
            [
                "category" => "1",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "€",
                "option_value" => "€",
            ],
            [
                "category" => "1",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "£",
                "option_value" => "£",
            ],
            [
                "category" => "1",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "¥",
                "option_value" => "¥",
            ],
            [
                "category" => "1",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "R",
                "option_value" => "R",
            ],

            [
                "category" => "1",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "₦",
                "option_value" => "₦",
            ],
            [
                "category" => "1",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "$",
                "option_value" => "$",
            ],
            [
                "category" => "1",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "C$",
                "option_value" => "C$",
            ],
            [
                "category" => "1",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "Fr",
                "option_value" => "Fr",
            ],
            [
                "category" => "1",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "€",
                "option_value" => "€",
            ],
            [
                "category" => "1",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "£",
                "option_value" => "£",
            ],
            [
                "category" => "1",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "¥",
                "option_value" => "¥",
            ],
            [
                "category" => "1",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "R",
                "option_value" => "R",
            ],
            [
                "category" => "1",
                "field_name" => "productOfInterest",
                "option_name" => "Bonds",
                "option_value" => "bonds",
            ],
            [
                "category" => "1",
                "field_name" => "productOfInterest",
                "option_name" => "Treasury Bills ",
                "option_value" => "treasuryBills",
            ],
            [
                "category" => "1",
                "field_name" => "productOfInterest",
                "option_name" => "Commercial Papers",
                "option_value" => "commercialPapers",
            ],
            [
                "category" => "1",
                "field_name" => "productOfInterest",
                "option_name" => "Money Market",
                "option_value" => "moneyMarket",
            ],
            [
                "category" => "1",
                "field_name" => "productOfInterest",
                "option_name" => "Foreign Exchange",
                "option_value" => "foreignExchange",
            ],
            [
                "category" => "1",
                "field_name" => "productOfInterest",
                "option_name" => "Derivatives",
                "option_value" => "derivatives",
            ],
            [
                "category" => "1",
                "field_name" => "productOfInterest",
                "option_name" => "Others",
                "option_value" => "others",
            ],
            [
                "category" => "1",
                "field_name" => "directionOfTrades",
                "option_name" => "Buy",
                "option_value" => "buy",
            ],
            [
                "category" => "1",
                "field_name" => "directionOfTrades",
                "option_name" => "Sell",
                "option_value" => "sell",
            ],
            [
                "category" => "1",
                "field_name" => "directionOfTrades",
                "option_name" => "Both",
                "option_value" => "both",
            ],
            // [
            //     "category" => "1",
            //     "field_name" => "bankingLicense",
            //     "option_name" => "dede",
            //     "option_value" => "dede",
            // ],
            // [
            //     "category" => "1",
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
