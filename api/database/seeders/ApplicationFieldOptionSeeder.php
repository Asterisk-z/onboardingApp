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
            [
                "category" => "1",
                "field_name" => "companyDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "1",
                "field_name" => "companyDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "1",
                "field_name" => "companyDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "1",
                "field_name" => "companyDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "1",
                "field_name" => "companyDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "1",
                "field_name" => "companyDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "1",
                "field_name" => "companyDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "1",
                "field_name" => "companyDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "1",
                "field_name" => "companyDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "1",
                "field_name" => "companyDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "1",
                "field_name" => "mdceoDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "1",
                "field_name" => "mdceoDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "1",
                "field_name" => "mdceoDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "1",
                "field_name" => "mdceoDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "1",
                "field_name" => "mdceoDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "1",
                "field_name" => "mdceoDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "1",
                "field_name" => "mdceoDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "1",
                "field_name" => "mdceoDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "1",
                "field_name" => "mdceoDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "1",
                "field_name" => "mdceoDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "1",
                "field_name" => "mdceoDisciplinaryFive",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "1",
                "field_name" => "mdceoDisciplinaryFive",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "1",
                "field_name" => "mdceoDisciplinarySix",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "1",
                "field_name" => "mdceoDisciplinarySix",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "1",
                "field_name" => "mdceoDisciplinarySeven",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "1",
                "field_name" => "mdceoDisciplinarySeven",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "1",
                "field_name" => "mdceoDisciplinaryEight",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "1",
                "field_name" => "mdceoDisciplinaryEight",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "1",
                "field_name" => "treasureDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "1",
                "field_name" => "treasureDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "1",
                "field_name" => "treasureDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "1",
                "field_name" => "treasureDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "1",
                "field_name" => "treasureDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "1",
                "field_name" => "treasureDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "1",
                "field_name" => "treasureDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "1",
                "field_name" => "treasureDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "1",
                "field_name" => "treasureDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "1",
                "field_name" => "treasureDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "1",
                "field_name" => "treasureDisciplinaryFive",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "1",
                "field_name" => "treasureDisciplinaryFive",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "1",
                "field_name" => "chiefComplianceOfficerDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "1",
                "field_name" => "chiefComplianceOfficerDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "1",
                "field_name" => "chiefComplianceOfficerDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "1",
                "field_name" => "chiefComplianceOfficerDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "1",
                "field_name" => "chiefComplianceOfficerDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "1",
                "field_name" => "chiefComplianceOfficerDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "1",
                "field_name" => "chiefComplianceOfficerDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "1",
                "field_name" => "chiefComplianceOfficerDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "1",
                "field_name" => "chiefComplianceOfficerDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "1",
                "field_name" => "chiefComplianceOfficerDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "1",
                "field_name" => "chiefComplianceOfficerDisciplinaryFive",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "1",
                "field_name" => "chiefComplianceOfficerDisciplinaryFive",
                "option_name" => "No",
                "option_value" => "no",
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
