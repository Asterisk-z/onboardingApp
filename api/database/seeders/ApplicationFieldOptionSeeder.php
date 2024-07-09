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
        // ApplicationFieldOption::query()->truncate();
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

        // DMS

        $fields = [

            [
                "category" => "2",
                "field_name" => "productOfInterest",
                "option_name" => "Bonds (FGN Bonds)",
                "option_value" => "bonds",
            ],
            [
                "category" => "2",
                "field_name" => "productOfInterest",
                "option_name" => "Treasury Bills ",
                "option_value" => "treasuryBills",
            ],
            [
                "category" => "2",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "₦",
                "option_value" => "₦",
            ],
            [
                "category" => "2",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "$",
                "option_value" => "$",
            ],
            [
                "category" => "2",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "C$",
                "option_value" => "C$",
            ],
            [
                "category" => "2",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "Fr",
                "option_value" => "Fr",
            ],
            [
                "category" => "2",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "€",
                "option_value" => "€",
            ],
            [
                "category" => "2",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "£",
                "option_value" => "£",
            ],
            [
                "category" => "2",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "¥",
                "option_value" => "¥",
            ],
            [
                "category" => "2",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "R",
                "option_value" => "R",
            ],

            [
                "category" => "2",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "₦",
                "option_value" => "₦",
            ],
            [
                "category" => "2",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "$",
                "option_value" => "$",
            ],
            [
                "category" => "2",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "C$",
                "option_value" => "C$",
            ],
            [
                "category" => "2",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "Fr",
                "option_value" => "Fr",
            ],
            [
                "category" => "2",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "€",
                "option_value" => "€",
            ],
            [
                "category" => "2",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "£",
                "option_value" => "£",
            ],
            [
                "category" => "2",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "¥",
                "option_value" => "¥",
            ],
            [
                "category" => "2",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "R",
                "option_value" => "R",
            ],
            [
                "category" => "2",
                "field_name" => "directionOfTrades",
                "option_name" => "Buy",
                "option_value" => "buy",
            ],
            [
                "category" => "2",
                "field_name" => "directionOfTrades",
                "option_name" => "Sell",
                "option_value" => "sell",
            ],
            [
                "category" => "2",
                "field_name" => "directionOfTrades",
                "option_name" => "Both",
                "option_value" => "both",
            ],
            [
                "category" => "2",
                "field_name" => "companyDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "2",
                "field_name" => "companyDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "2",
                "field_name" => "companyDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "2",
                "field_name" => "companyDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "2",
                "field_name" => "companyDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "2",
                "field_name" => "companyDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "2",
                "field_name" => "companyDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "2",
                "field_name" => "companyDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "2",
                "field_name" => "companyDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "2",
                "field_name" => "companyDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "2",
                "field_name" => "mdceoDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "2",
                "field_name" => "mdceoDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "2",
                "field_name" => "mdceoDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "2",
                "field_name" => "mdceoDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "2",
                "field_name" => "mdceoDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "2",
                "field_name" => "mdceoDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "2",
                "field_name" => "mdceoDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "2",
                "field_name" => "mdceoDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "2",
                "field_name" => "mdceoDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "2",
                "field_name" => "mdceoDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "2",
                "field_name" => "mdceoDisciplinaryFive",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "2",
                "field_name" => "mdceoDisciplinaryFive",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "2",
                "field_name" => "mdceoDisciplinarySix",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "2",
                "field_name" => "mdceoDisciplinarySix",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "2",
                "field_name" => "mdceoDisciplinarySeven",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "2",
                "field_name" => "mdceoDisciplinarySeven",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "2",
                "field_name" => "mdceoDisciplinaryEight",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "2",
                "field_name" => "mdceoDisciplinaryEight",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "2",
                "field_name" => "dealerDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "2",
                "field_name" => "dealerDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "2",
                "field_name" => "dealerDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "2",
                "field_name" => "dealerDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "2",
                "field_name" => "dealerDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "2",
                "field_name" => "dealerDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "2",
                "field_name" => "dealerDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "2",
                "field_name" => "dealerDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "2",
                "field_name" => "dealerDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "2",
                "field_name" => "dealerDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "2",
                "field_name" => "dealerDisciplinaryFive",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "2",
                "field_name" => "dealerDisciplinaryFive",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "2",
                "field_name" => "chiefComplianceOfficerDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "2",
                "field_name" => "chiefComplianceOfficerDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "2",
                "field_name" => "chiefComplianceOfficerDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "2",
                "field_name" => "chiefComplianceOfficerDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "2",
                "field_name" => "chiefComplianceOfficerDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "2",
                "field_name" => "chiefComplianceOfficerDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "2",
                "field_name" => "chiefComplianceOfficerDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "2",
                "field_name" => "chiefComplianceOfficerDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "2",
                "field_name" => "chiefComplianceOfficerDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "2",
                "field_name" => "chiefComplianceOfficerDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "2",
                "field_name" => "chiefComplianceOfficerDisciplinaryFive",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "2",
                "field_name" => "chiefComplianceOfficerDisciplinaryFive",
                "option_name" => "No",
                "option_value" => "no",
            ],

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

        // AMB

        $fields = [
            [
                "category" => "3",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "₦",
                "option_value" => "₦",
            ],
            [
                "category" => "3",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "$",
                "option_value" => "$",
            ],
            [
                "category" => "3",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "C$",
                "option_value" => "C$",
            ],
            [
                "category" => "3",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "Fr",
                "option_value" => "Fr",
            ],
            [
                "category" => "3",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "€",
                "option_value" => "€",
            ],
            [
                "category" => "3",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "£",
                "option_value" => "£",
            ],
            [
                "category" => "3",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "¥",
                "option_value" => "¥",
            ],
            [
                "category" => "3",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "R",
                "option_value" => "R",
            ],

            [
                "category" => "3",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "₦",
                "option_value" => "₦",
            ],
            [
                "category" => "3",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "$",
                "option_value" => "$",
            ],
            [
                "category" => "3",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "C$",
                "option_value" => "C$",
            ],
            [
                "category" => "3",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "Fr",
                "option_value" => "Fr",
            ],
            [
                "category" => "3",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "€",
                "option_value" => "€",
            ],
            [
                "category" => "3",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "£",
                "option_value" => "£",
            ],
            [
                "category" => "3",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "¥",
                "option_value" => "¥",
            ],
            [
                "category" => "3",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "R",
                "option_value" => "R",
            ],
            [
                "category" => "3",
                "field_name" => "productOfInterest",
                "option_name" => "Bonds",
                "option_value" => "bonds",
            ],
            [
                "category" => "3",
                "field_name" => "productOfInterest",
                "option_name" => "Treasury Bills ",
                "option_value" => "treasuryBills",
            ],
            [
                "category" => "3",
                "field_name" => "productOfInterest",
                "option_name" => "Commercial Papers",
                "option_value" => "commercialPapers",
            ],
            [
                "category" => "3",
                "field_name" => "productOfInterest",
                "option_name" => "Foreign Exchange",
                "option_value" => "foreignExchange",
            ],
            [
                "category" => "3",
                "field_name" => "productOfInterest",
                "option_name" => "Derivatives",
                "option_value" => "derivatives",
            ],
            [
                "category" => "3",
                "field_name" => "productOfInterest",
                "option_name" => "Others",
                "option_value" => "others",
            ],
            [
                "category" => "3",
                "field_name" => "directionOfTrades",
                "option_name" => "Buy",
                "option_value" => "buy",
            ],
            [
                "category" => "3",
                "field_name" => "directionOfTrades",
                "option_name" => "Sell",
                "option_value" => "sell",
            ],
            [
                "category" => "3",
                "field_name" => "directionOfTrades",
                "option_name" => "Both",
                "option_value" => "both",
            ],
            [
                "category" => "3",
                "field_name" => "companyDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "3",
                "field_name" => "companyDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "3",
                "field_name" => "companyDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "3",
                "field_name" => "companyDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "3",
                "field_name" => "companyDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "3",
                "field_name" => "companyDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "3",
                "field_name" => "companyDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "3",
                "field_name" => "companyDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "3",
                "field_name" => "companyDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "3",
                "field_name" => "companyDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "3",
                "field_name" => "companyDisciplinaryFive",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "3",
                "field_name" => "companyDisciplinaryFive",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "3",
                "field_name" => "companyDisciplinarySix",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "3",
                "field_name" => "companyDisciplinarySix",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "3",
                "field_name" => "companyDisciplinarySeven",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "3",
                "field_name" => "companyDisciplinarySeven",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "3",
                "field_name" => "companyDisciplinaryEight",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "3",
                "field_name" => "companyDisciplinaryEight",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "3",
                "field_name" => "companyDisciplinaryNine",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "3",
                "field_name" => "companyDisciplinaryNine",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "3",
                "field_name" => "mdceoDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "3",
                "field_name" => "mdceoDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "3",
                "field_name" => "mdceoDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "3",
                "field_name" => "mdceoDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "3",
                "field_name" => "mdceoDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "3",
                "field_name" => "mdceoDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "3",
                "field_name" => "mdceoDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "3",
                "field_name" => "mdceoDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "3",
                "field_name" => "mdceoDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "3",
                "field_name" => "mdceoDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "3",
                "field_name" => "mdceoDisciplinaryFive",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "3",
                "field_name" => "mdceoDisciplinaryFive",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "3",
                "field_name" => "mdceoDisciplinarySix",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "3",
                "field_name" => "mdceoDisciplinarySix",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "3",
                "field_name" => "mdceoDisciplinarySeven",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "3",
                "field_name" => "mdceoDisciplinarySeven",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "3",
                "field_name" => "mdceoDisciplinaryEight",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "3",
                "field_name" => "mdceoDisciplinaryEight",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "3",
                "field_name" => "treasureDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "3",
                "field_name" => "treasureDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "3",
                "field_name" => "treasureDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "3",
                "field_name" => "treasureDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "3",
                "field_name" => "treasureDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "3",
                "field_name" => "treasureDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "3",
                "field_name" => "treasureDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "3",
                "field_name" => "treasureDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "3",
                "field_name" => "treasureDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "3",
                "field_name" => "treasureDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "3",
                "field_name" => "treasureDisciplinaryFive",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "3",
                "field_name" => "treasureDisciplinaryFive",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "3",
                "field_name" => "chiefComplianceOfficerDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "3",
                "field_name" => "chiefComplianceOfficerDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "3",
                "field_name" => "chiefComplianceOfficerDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "3",
                "field_name" => "chiefComplianceOfficerDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "3",
                "field_name" => "chiefComplianceOfficerDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "3",
                "field_name" => "chiefComplianceOfficerDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "3",
                "field_name" => "chiefComplianceOfficerDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "3",
                "field_name" => "chiefComplianceOfficerDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "3",
                "field_name" => "chiefComplianceOfficerDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "3",
                "field_name" => "chiefComplianceOfficerDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "3",
                "field_name" => "chiefComplianceOfficerDisciplinaryFive",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "3",
                "field_name" => "chiefComplianceOfficerDisciplinaryFive",
                "option_name" => "No",
                "option_value" => "no",
            ],
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

        // AMI

        $fields = [
            [
                "category" => "4",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "₦",
                "option_value" => "₦",
            ],
            [
                "category" => "4",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "$",
                "option_value" => "$",
            ],
            [
                "category" => "4",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "C$",
                "option_value" => "C$",
            ],
            [
                "category" => "4",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "Fr",
                "option_value" => "Fr",
            ],
            [
                "category" => "4",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "€",
                "option_value" => "€",
            ],
            [
                "category" => "4",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "£",
                "option_value" => "£",
            ],
            [
                "category" => "4",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "¥",
                "option_value" => "¥",
            ],
            [
                "category" => "4",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "R",
                "option_value" => "R",
            ],

            [
                "category" => "4",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "₦",
                "option_value" => "₦",
            ],
            [
                "category" => "4",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "$",
                "option_value" => "$",
            ],
            [
                "category" => "4",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "C$",
                "option_value" => "C$",
            ],
            [
                "category" => "4",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "Fr",
                "option_value" => "Fr",
            ],
            [
                "category" => "4",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "€",
                "option_value" => "€",
            ],
            [
                "category" => "4",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "£",
                "option_value" => "£",
            ],
            [
                "category" => "4",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "¥",
                "option_value" => "¥",
            ],
            [
                "category" => "4",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "R",
                "option_value" => "R",
            ],
            [
                "category" => "4",
                "field_name" => "productOfInterest",
                "option_name" => "Bonds",
                "option_value" => "bonds",
            ],
            [
                "category" => "4",
                "field_name" => "productOfInterest",
                "option_name" => "Treasury Bills ",
                "option_value" => "treasuryBills",
            ],
            [
                "category" => "4",
                "field_name" => "productOfInterest",
                "option_name" => "Commercial Papers",
                "option_value" => "commercialPapers",
            ],
            [
                "category" => "4",
                "field_name" => "productOfInterest",
                "option_name" => "Foreign Exchange",
                "option_value" => "foreignExchange",
            ],
            [
                "category" => "4",
                "field_name" => "productOfInterest",
                "option_name" => "Derivatives",
                "option_value" => "derivatives",
            ],
            [
                "category" => "4",
                "field_name" => "productOfInterest",
                "option_name" => "Others",
                "option_value" => "others",
            ],
            [
                "category" => "4",
                "field_name" => "directionOfTrades",
                "option_name" => "Buy",
                "option_value" => "buy",
            ],
            [
                "category" => "4",
                "field_name" => "directionOfTrades",
                "option_name" => "Sell",
                "option_value" => "sell",
            ],
            [
                "category" => "4",
                "field_name" => "directionOfTrades",
                "option_name" => "Both",
                "option_value" => "both",
            ],
            [
                "category" => "4",
                "field_name" => "companyDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "4",
                "field_name" => "companyDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "4",
                "field_name" => "companyDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "4",
                "field_name" => "companyDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "4",
                "field_name" => "companyDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "4",
                "field_name" => "companyDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "4",
                "field_name" => "companyDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "4",
                "field_name" => "companyDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "4",
                "field_name" => "companyDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "4",
                "field_name" => "companyDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "4",
                "field_name" => "companyDisciplinaryFive",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "4",
                "field_name" => "companyDisciplinaryFive",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "4",
                "field_name" => "companyDisciplinarySix",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "4",
                "field_name" => "companyDisciplinarySix",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "4",
                "field_name" => "companyDisciplinarySeven",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "4",
                "field_name" => "companyDisciplinarySeven",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "4",
                "field_name" => "companyDisciplinaryEight",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "4",
                "field_name" => "companyDisciplinaryEight",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "4",
                "field_name" => "companyDisciplinaryNine",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "4",
                "field_name" => "companyDisciplinaryNine",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "4",
                "field_name" => "mdceoDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "4",
                "field_name" => "mdceoDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "4",
                "field_name" => "mdceoDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "4",
                "field_name" => "mdceoDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "4",
                "field_name" => "mdceoDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "4",
                "field_name" => "mdceoDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "4",
                "field_name" => "mdceoDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "4",
                "field_name" => "mdceoDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "4",
                "field_name" => "mdceoDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "4",
                "field_name" => "mdceoDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "4",
                "field_name" => "mdceoDisciplinaryFive",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "4",
                "field_name" => "mdceoDisciplinaryFive",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "4",
                "field_name" => "mdceoDisciplinarySix",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "4",
                "field_name" => "mdceoDisciplinarySix",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "4",
                "field_name" => "mdceoDisciplinarySeven",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "4",
                "field_name" => "mdceoDisciplinarySeven",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "4",
                "field_name" => "mdceoDisciplinaryEight",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "4",
                "field_name" => "mdceoDisciplinaryEight",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "4",
                "field_name" => "treasureDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "4",
                "field_name" => "treasureDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "4",
                "field_name" => "treasureDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "4",
                "field_name" => "treasureDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "4",
                "field_name" => "treasureDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "4",
                "field_name" => "treasureDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "4",
                "field_name" => "treasureDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "4",
                "field_name" => "treasureDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "4",
                "field_name" => "treasureDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "4",
                "field_name" => "treasureDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "4",
                "field_name" => "treasureDisciplinaryFive",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "4",
                "field_name" => "treasureDisciplinaryFive",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "4",
                "field_name" => "chiefComplianceOfficerDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "4",
                "field_name" => "chiefComplianceOfficerDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "4",
                "field_name" => "chiefComplianceOfficerDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "4",
                "field_name" => "chiefComplianceOfficerDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "4",
                "field_name" => "chiefComplianceOfficerDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "4",
                "field_name" => "chiefComplianceOfficerDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "4",
                "field_name" => "chiefComplianceOfficerDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "4",
                "field_name" => "chiefComplianceOfficerDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "4",
                "field_name" => "chiefComplianceOfficerDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "4",
                "field_name" => "chiefComplianceOfficerDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "4",
                "field_name" => "chiefComplianceOfficerDisciplinaryFive",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "4",
                "field_name" => "chiefComplianceOfficerDisciplinaryFive",
                "option_name" => "No",
                "option_value" => "no",
            ],
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

// AMI

        $fields = [
            [
                "category" => "5",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "₦",
                "option_value" => "₦",
            ],
            [
                "category" => "5",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "$",
                "option_value" => "$",
            ],
            [
                "category" => "5",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "C$",
                "option_value" => "C$",
            ],
            [
                "category" => "5",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "Fr",
                "option_value" => "Fr",
            ],
            [
                "category" => "5",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "€",
                "option_value" => "€",
            ],
            [
                "category" => "5",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "£",
                "option_value" => "£",
            ],
            [
                "category" => "5",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "¥",
                "option_value" => "¥",
            ],
            [
                "category" => "5",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "R",
                "option_value" => "R",
            ],

            [
                "category" => "5",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "₦",
                "option_value" => "₦",
            ],
            [
                "category" => "5",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "$",
                "option_value" => "$",
            ],
            [
                "category" => "5",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "C$",
                "option_value" => "C$",
            ],
            [
                "category" => "5",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "Fr",
                "option_value" => "Fr",
            ],
            [
                "category" => "5",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "€",
                "option_value" => "€",
            ],
            [
                "category" => "5",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "£",
                "option_value" => "£",
            ],
            [
                "category" => "5",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "¥",
                "option_value" => "¥",
            ],
            [
                "category" => "5",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "R",
                "option_value" => "R",
            ],
            [
                "category" => "5",
                "field_name" => "productOfInterest",
                "option_name" => "Bonds",
                "option_value" => "bonds",
            ],
            [
                "category" => "5",
                "field_name" => "productOfInterest",
                "option_name" => "Treasury Bills ",
                "option_value" => "treasuryBills",
            ],
            [
                "category" => "5",
                "field_name" => "productOfInterest",
                "option_name" => "Commercial Papers",
                "option_value" => "commercialPapers",
            ],
            [
                "category" => "5",
                "field_name" => "productOfInterest",
                "option_name" => "Foreign Exchange",
                "option_value" => "foreignExchange",
            ],
            [
                "category" => "5",
                "field_name" => "productOfInterest",
                "option_name" => "Derivatives",
                "option_value" => "derivatives",
            ],
            [
                "category" => "5",
                "field_name" => "productOfInterest",
                "option_name" => "Others",
                "option_value" => "others",
            ],
            [
                "category" => "5",
                "field_name" => "directionOfTrades",
                "option_name" => "Buy",
                "option_value" => "buy",
            ],
            [
                "category" => "5",
                "field_name" => "directionOfTrades",
                "option_name" => "Sell",
                "option_value" => "sell",
            ],
            [
                "category" => "5",
                "field_name" => "directionOfTrades",
                "option_name" => "Both",
                "option_value" => "both",
            ],
            [
                "category" => "5",
                "field_name" => "companyDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "5",
                "field_name" => "companyDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "5",
                "field_name" => "companyDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "5",
                "field_name" => "companyDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "5",
                "field_name" => "companyDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "5",
                "field_name" => "companyDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "5",
                "field_name" => "companyDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "5",
                "field_name" => "companyDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "5",
                "field_name" => "companyDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "5",
                "field_name" => "companyDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "5",
                "field_name" => "companyDisciplinaryFive",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "5",
                "field_name" => "companyDisciplinaryFive",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "5",
                "field_name" => "companyDisciplinarySix",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "5",
                "field_name" => "companyDisciplinarySix",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "5",
                "field_name" => "companyDisciplinarySeven",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "5",
                "field_name" => "companyDisciplinarySeven",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "5",
                "field_name" => "companyDisciplinaryEight",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "5",
                "field_name" => "companyDisciplinaryEight",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "5",
                "field_name" => "companyDisciplinaryNine",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "5",
                "field_name" => "companyDisciplinaryNine",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "5",
                "field_name" => "mdceoDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "5",
                "field_name" => "mdceoDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "5",
                "field_name" => "mdceoDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "5",
                "field_name" => "mdceoDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "5",
                "field_name" => "mdceoDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "5",
                "field_name" => "mdceoDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "5",
                "field_name" => "mdceoDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "5",
                "field_name" => "mdceoDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "5",
                "field_name" => "mdceoDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "5",
                "field_name" => "mdceoDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "5",
                "field_name" => "mdceoDisciplinaryFive",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "5",
                "field_name" => "mdceoDisciplinaryFive",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "5",
                "field_name" => "mdceoDisciplinarySix",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "5",
                "field_name" => "mdceoDisciplinarySix",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "5",
                "field_name" => "mdceoDisciplinarySeven",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "5",
                "field_name" => "mdceoDisciplinarySeven",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "5",
                "field_name" => "mdceoDisciplinaryEight",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "5",
                "field_name" => "mdceoDisciplinaryEight",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "5",
                "field_name" => "treasureDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "5",
                "field_name" => "treasureDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "5",
                "field_name" => "treasureDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "5",
                "field_name" => "treasureDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "5",
                "field_name" => "treasureDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "5",
                "field_name" => "treasureDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "5",
                "field_name" => "treasureDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "5",
                "field_name" => "treasureDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "5",
                "field_name" => "treasureDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "5",
                "field_name" => "treasureDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "5",
                "field_name" => "treasureDisciplinaryFive",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "5",
                "field_name" => "treasureDisciplinaryFive",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "5",
                "field_name" => "chiefComplianceOfficerDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "5",
                "field_name" => "chiefComplianceOfficerDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "5",
                "field_name" => "chiefComplianceOfficerDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "5",
                "field_name" => "chiefComplianceOfficerDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "5",
                "field_name" => "chiefComplianceOfficerDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "5",
                "field_name" => "chiefComplianceOfficerDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "5",
                "field_name" => "chiefComplianceOfficerDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "5",
                "field_name" => "chiefComplianceOfficerDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "5",
                "field_name" => "chiefComplianceOfficerDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "5",
                "field_name" => "chiefComplianceOfficerDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "5",
                "field_name" => "chiefComplianceOfficerDisciplinaryFive",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "5",
                "field_name" => "chiefComplianceOfficerDisciplinaryFive",
                "option_name" => "No",
                "option_value" => "no",
            ],
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

        // RGL

        $fields = [
            [
                "category" => "6",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "₦",
                "option_value" => "₦",
            ],
            [
                "category" => "6",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "$",
                "option_value" => "$",
            ],
            [
                "category" => "6",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "C$",
                "option_value" => "C$",
            ],
            [
                "category" => "6",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "Fr",
                "option_value" => "Fr",
            ],
            [
                "category" => "6",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "€",
                "option_value" => "€",
            ],
            [
                "category" => "6",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "£",
                "option_value" => "£",
            ],
            [
                "category" => "6",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "¥",
                "option_value" => "¥",
            ],
            [
                "category" => "6",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "R",
                "option_value" => "R",
            ],

            [
                "category" => "6",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "₦",
                "option_value" => "₦",
            ],
            [
                "category" => "6",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "$",
                "option_value" => "$",
            ],
            [
                "category" => "6",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "C$",
                "option_value" => "C$",
            ],
            [
                "category" => "6",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "Fr",
                "option_value" => "Fr",
            ],
            [
                "category" => "6",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "€",
                "option_value" => "€",
            ],
            [
                "category" => "6",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "£",
                "option_value" => "£",
            ],
            [
                "category" => "6",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "¥",
                "option_value" => "¥",
            ],
            [
                "category" => "6",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "R",
                "option_value" => "R",
            ],
            [
                "category" => "6",
                "field_name" => "companyDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "6",
                "field_name" => "companyDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "6",
                "field_name" => "companyDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "6",
                "field_name" => "companyDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "6",
                "field_name" => "companyDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "6",
                "field_name" => "companyDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "6",
                "field_name" => "companyDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "6",
                "field_name" => "companyDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "6",
                "field_name" => "companyDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "6",
                "field_name" => "companyDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "6",
                "field_name" => "mdceoDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "6",
                "field_name" => "mdceoDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "6",
                "field_name" => "mdceoDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "6",
                "field_name" => "mdceoDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "6",
                "field_name" => "mdceoDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "6",
                "field_name" => "mdceoDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "6",
                "field_name" => "mdceoDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "6",
                "field_name" => "mdceoDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "6",
                "field_name" => "mdceoDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "6",
                "field_name" => "mdceoDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "6",
                "field_name" => "mdceoDisciplinaryFive",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "6",
                "field_name" => "mdceoDisciplinaryFive",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "6",
                "field_name" => "mdceoDisciplinarySix",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "6",
                "field_name" => "mdceoDisciplinarySix",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "6",
                "field_name" => "mdceoDisciplinarySeven",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "6",
                "field_name" => "mdceoDisciplinarySeven",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "6",
                "field_name" => "mdceoDisciplinaryEight",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "6",
                "field_name" => "mdceoDisciplinaryEight",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "6",
                "field_name" => "treasureDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "6",
                "field_name" => "treasureDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "6",
                "field_name" => "treasureDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "6",
                "field_name" => "treasureDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "6",
                "field_name" => "treasureDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "6",
                "field_name" => "treasureDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "6",
                "field_name" => "treasureDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "6",
                "field_name" => "treasureDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "6",
                "field_name" => "treasureDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "6",
                "field_name" => "treasureDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "6",
                "field_name" => "treasureDisciplinaryFive",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "6",
                "field_name" => "treasureDisciplinaryFive",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "6",
                "field_name" => "chiefComplianceOfficerDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "6",
                "field_name" => "chiefComplianceOfficerDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "6",
                "field_name" => "chiefComplianceOfficerDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "6",
                "field_name" => "chiefComplianceOfficerDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "6",
                "field_name" => "chiefComplianceOfficerDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "6",
                "field_name" => "chiefComplianceOfficerDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "6",
                "field_name" => "chiefComplianceOfficerDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "6",
                "field_name" => "chiefComplianceOfficerDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "6",
                "field_name" => "chiefComplianceOfficerDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "6",
                "field_name" => "chiefComplianceOfficerDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "6",
                "field_name" => "chiefComplianceOfficerDisciplinaryFive",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "6",
                "field_name" => "chiefComplianceOfficerDisciplinaryFive",
                "option_name" => "No",
                "option_value" => "no",
            ],
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

        // RGC

        $fields = [

            [
                "category" => "7",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "₦",
                "option_value" => "₦",
            ],
            [
                "category" => "7",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "$",
                "option_value" => "$",
            ],
            [
                "category" => "7",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "C$",
                "option_value" => "C$",
            ],
            [
                "category" => "7",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "Fr",
                "option_value" => "Fr",
            ],
            [
                "category" => "7",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "€",
                "option_value" => "€",
            ],
            [
                "category" => "7",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "£",
                "option_value" => "£",
            ],
            [
                "category" => "7",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "¥",
                "option_value" => "¥",
            ],
            [
                "category" => "7",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "R",
                "option_value" => "R",
            ],

            [
                "category" => "7",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "₦",
                "option_value" => "₦",
            ],
            [
                "category" => "7",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "$",
                "option_value" => "$",
            ],
            [
                "category" => "7",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "C$",
                "option_value" => "C$",
            ],
            [
                "category" => "7",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "Fr",
                "option_value" => "Fr",
            ],
            [
                "category" => "7",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "€",
                "option_value" => "€",
            ],
            [
                "category" => "7",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "£",
                "option_value" => "£",
            ],
            [
                "category" => "7",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "¥",
                "option_value" => "¥",
            ],
            [
                "category" => "7",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "R",
                "option_value" => "R",
            ],
            [
                "category" => "7",
                "field_name" => "companyDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "7",
                "field_name" => "companyDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "7",
                "field_name" => "companyDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "7",
                "field_name" => "companyDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "7",
                "field_name" => "companyDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "7",
                "field_name" => "companyDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "7",
                "field_name" => "companyDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "7",
                "field_name" => "companyDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "7",
                "field_name" => "companyDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "7",
                "field_name" => "companyDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "7",
                "field_name" => "companyDisciplinaryFive",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "7",
                "field_name" => "companyDisciplinaryFive",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "7",
                "field_name" => "companyDisciplinarySix",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "7",
                "field_name" => "companyDisciplinarySix",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "7",
                "field_name" => "mdceoDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "7",
                "field_name" => "mdceoDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "7",
                "field_name" => "mdceoDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "7",
                "field_name" => "mdceoDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "7",
                "field_name" => "mdceoDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "7",
                "field_name" => "mdceoDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "7",
                "field_name" => "mdceoDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "7",
                "field_name" => "mdceoDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "7",
                "field_name" => "mdceoDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "7",
                "field_name" => "mdceoDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "7",
                "field_name" => "mdceoDisciplinaryFive",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "7",
                "field_name" => "mdceoDisciplinaryFive",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "7",
                "field_name" => "treasureDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "7",
                "field_name" => "treasureDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "7",
                "field_name" => "treasureDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "7",
                "field_name" => "treasureDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "7",
                "field_name" => "treasureDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "7",
                "field_name" => "treasureDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "7",
                "field_name" => "treasureDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "7",
                "field_name" => "treasureDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "7",
                "field_name" => "treasureDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "7",
                "field_name" => "treasureDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "7",
                "field_name" => "treasureDisciplinaryFive",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "7",
                "field_name" => "treasureDisciplinaryFive",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "7",
                "field_name" => "chiefComplianceOfficerDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "7",
                "field_name" => "chiefComplianceOfficerDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "7",
                "field_name" => "chiefComplianceOfficerDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "7",
                "field_name" => "chiefComplianceOfficerDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "7",
                "field_name" => "chiefComplianceOfficerDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "7",
                "field_name" => "chiefComplianceOfficerDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "7",
                "field_name" => "chiefComplianceOfficerDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "7",
                "field_name" => "chiefComplianceOfficerDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "7",
                "field_name" => "chiefComplianceOfficerDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "7",
                "field_name" => "chiefComplianceOfficerDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "7",
                "field_name" => "chiefComplianceOfficerDisciplinaryFive",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "7",
                "field_name" => "chiefComplianceOfficerDisciplinaryFive",
                "option_name" => "No",
                "option_value" => "no",
            ],
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

        // RGI

        $fields = [
            // [
            //     "category" => "8",
            //     "field_name" => "categoryOfMembership",
            //     "option_name" => "Registration Member (Listings)",
            //     "option_value" => "listings",
            // ],
            // [
            //     "category" => "8",
            //     "field_name" => "categoryOfMembership",
            //     "option_name" => "Registration Member (Quotations)",
            //     "option_value" => "quotations",
            // ],
            [
                "category" => "8",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "₦",
                "option_value" => "₦",
            ],
            [
                "category" => "8",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "$",
                "option_value" => "$",
            ],
            [
                "category" => "8",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "C$",
                "option_value" => "C$",
            ],
            [
                "category" => "8",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "Fr",
                "option_value" => "Fr",
            ],
            [
                "category" => "8",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "€",
                "option_value" => "€",
            ],
            [
                "category" => "8",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "£",
                "option_value" => "£",
            ],
            [
                "category" => "8",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "¥",
                "option_value" => "¥",
            ],
            [
                "category" => "8",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "R",
                "option_value" => "R",
            ],

            [
                "category" => "8",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "₦",
                "option_value" => "₦",
            ],
            [
                "category" => "8",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "$",
                "option_value" => "$",
            ],
            [
                "category" => "8",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "C$",
                "option_value" => "C$",
            ],
            [
                "category" => "8",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "Fr",
                "option_value" => "Fr",
            ],
            [
                "category" => "8",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "€",
                "option_value" => "€",
            ],
            [
                "category" => "8",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "£",
                "option_value" => "£",
            ],
            [
                "category" => "8",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "¥",
                "option_value" => "¥",
            ],
            [
                "category" => "8",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "R",
                "option_value" => "R",
            ],
            [
                "category" => "8",
                "field_name" => "companyDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "8",
                "field_name" => "companyDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "8",
                "field_name" => "companyDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "8",
                "field_name" => "companyDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "8",
                "field_name" => "companyDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "8",
                "field_name" => "companyDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "8",
                "field_name" => "companyDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "8",
                "field_name" => "companyDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "8",
                "field_name" => "companyDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "8",
                "field_name" => "companyDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "8",
                "field_name" => "mdceoDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "8",
                "field_name" => "mdceoDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "8",
                "field_name" => "mdceoDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "8",
                "field_name" => "mdceoDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "8",
                "field_name" => "mdceoDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "8",
                "field_name" => "mdceoDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "8",
                "field_name" => "mdceoDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "8",
                "field_name" => "mdceoDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "8",
                "field_name" => "mdceoDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "8",
                "field_name" => "mdceoDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "8",
                "field_name" => "mdceoDisciplinaryFive",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "8",
                "field_name" => "mdceoDisciplinaryFive",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "8",
                "field_name" => "mdceoDisciplinarySix",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "8",
                "field_name" => "mdceoDisciplinarySix",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "8",
                "field_name" => "mdceoDisciplinarySeven",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "8",
                "field_name" => "mdceoDisciplinarySeven",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "8",
                "field_name" => "mdceoDisciplinaryEight",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "8",
                "field_name" => "mdceoDisciplinaryEight",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "8",
                "field_name" => "treasureDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "8",
                "field_name" => "treasureDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "8",
                "field_name" => "treasureDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "8",
                "field_name" => "treasureDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "8",
                "field_name" => "treasureDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "8",
                "field_name" => "treasureDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "8",
                "field_name" => "treasureDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "8",
                "field_name" => "treasureDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "8",
                "field_name" => "treasureDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "8",
                "field_name" => "treasureDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "8",
                "field_name" => "treasureDisciplinaryFive",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "8",
                "field_name" => "treasureDisciplinaryFive",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "8",
                "field_name" => "chiefComplianceOfficerDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "8",
                "field_name" => "chiefComplianceOfficerDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "8",
                "field_name" => "chiefComplianceOfficerDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "8",
                "field_name" => "chiefComplianceOfficerDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "8",
                "field_name" => "chiefComplianceOfficerDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "8",
                "field_name" => "chiefComplianceOfficerDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "8",
                "field_name" => "chiefComplianceOfficerDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "8",
                "field_name" => "chiefComplianceOfficerDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "8",
                "field_name" => "chiefComplianceOfficerDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "8",
                "field_name" => "chiefComplianceOfficerDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "8",
                "field_name" => "chiefComplianceOfficerDisciplinaryFive",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "8",
                "field_name" => "chiefComplianceOfficerDisciplinaryFive",
                "option_name" => "No",
                "option_value" => "no",
            ],
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

        // RGI

        $fields = [
            [
                "category" => "9",
                "field_name" => "reasonForSeekingMembership",
                "option_name" => "Investor",
                "option_value" => "Investor",
            ],
            [
                "category" => "9",
                "field_name" => "reasonForSeekingMembership",
                "option_name" => "Research",
                "option_value" => "Research",
            ],
            [
                "category" => "9",
                "field_name" => "reasonForSeekingMembership",
                "option_name" => "Education",
                "option_value" => "Education",
            ],
            [
                "category" => "9",
                "field_name" => "reasonForSeekingMembership",
                "option_name" => "Other(s)",
                "option_value" => "Other(s)",
            ],
            [
                "category" => "9",
                "field_name" => "companyDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "9",
                "field_name" => "companyDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "9",
                "field_name" => "companyDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "9",
                "field_name" => "companyDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "9",
                "field_name" => "companyDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "9",
                "field_name" => "companyDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "9",
                "field_name" => "companyDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "9",
                "field_name" => "companyDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "9",
                "field_name" => "companyDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "9",
                "field_name" => "companyDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
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

        // RGI

        $fields = [
            [
                "category" => "10",
                "field_name" => "reasonForSeekingMembership",
                "option_name" => "Investor",
                "option_value" => "Investor",
            ],
            [
                "category" => "10",
                "field_name" => "reasonForSeekingMembership",
                "option_name" => "Research",
                "option_value" => "Research",
            ],
            [
                "category" => "10",
                "field_name" => "reasonForSeekingMembership",
                "option_name" => "Education",
                "option_value" => "Education",
            ],
            [
                "category" => "10",
                "field_name" => "reasonForSeekingMembership",
                "option_name" => "Other(s)",
                "option_value" => "Other(s)",
            ],
            [
                "category" => "10",
                "field_name" => "companyDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "10",
                "field_name" => "companyDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "10",
                "field_name" => "companyDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "10",
                "field_name" => "companyDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "10",
                "field_name" => "companyDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "10",
                "field_name" => "companyDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "10",
                "field_name" => "companyDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "10",
                "field_name" => "companyDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "10",
                "field_name" => "companyDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "10",
                "field_name" => "companyDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
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

// RGI

        $fields = [
            [
                "category" => "11",
                "field_name" => "companyDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "11",
                "field_name" => "companyDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "11",
                "field_name" => "companyDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "11",
                "field_name" => "companyDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "11",
                "field_name" => "companyDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "11",
                "field_name" => "companyDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "11",
                "field_name" => "companyDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "11",
                "field_name" => "companyDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "11",
                "field_name" => "companyDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "11",
                "field_name" => "companyDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
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

// RGI

        $fields = [
            [
                "category" => "12",
                "field_name" => "reasonForSeekingMembership",
                "option_name" => "Investor",
                "option_value" => "Investor",
            ],
            [
                "category" => "12",
                "field_name" => "reasonForSeekingMembership",
                "option_name" => "Research",
                "option_value" => "Research",
            ],
            [
                "category" => "12",
                "field_name" => "reasonForSeekingMembership",
                "option_name" => "Education",
                "option_value" => "Education",
            ],
            [
                "category" => "12",
                "field_name" => "reasonForSeekingMembership",
                "option_name" => "Other(s)",
                "option_value" => "Other(s)",
            ],
            [
                "category" => "12",
                "field_name" => "companyDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "12",
                "field_name" => "companyDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "12",
                "field_name" => "companyDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "12",
                "field_name" => "companyDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "12",
                "field_name" => "companyDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "12",
                "field_name" => "companyDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "12",
                "field_name" => "companyDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "12",
                "field_name" => "companyDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "12",
                "field_name" => "companyDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "12",
                "field_name" => "companyDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
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

// RGI

        $fields = [
            [
                "category" => "13",
                "field_name" => "reasonForSeekingMembership",
                "option_name" => "Investor",
                "option_value" => "Investor",
            ],
            [
                "category" => "13",
                "field_name" => "reasonForSeekingMembership",
                "option_name" => "Research",
                "option_value" => "Research",
            ],
            [
                "category" => "13",
                "field_name" => "reasonForSeekingMembership",
                "option_name" => "Education",
                "option_value" => "Education",
            ],
            [
                "category" => "13",
                "field_name" => "reasonForSeekingMembership",
                "option_name" => "Other(s)",
                "option_value" => "Other(s)",
            ],
            [
                "category" => "13",
                "field_name" => "companyDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "13",
                "field_name" => "companyDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "13",
                "field_name" => "companyDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "13",
                "field_name" => "companyDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "13",
                "field_name" => "companyDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "13",
                "field_name" => "companyDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "13",
                "field_name" => "companyDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "13",
                "field_name" => "companyDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "13",
                "field_name" => "companyDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "13",
                "field_name" => "companyDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
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

// RGI

        $fields = [
            [
                "category" => "14",
                "field_name" => "companyDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "14",
                "field_name" => "companyDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "14",
                "field_name" => "companyDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "14",
                "field_name" => "companyDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "14",
                "field_name" => "companyDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "14",
                "field_name" => "companyDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "14",
                "field_name" => "companyDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "14",
                "field_name" => "companyDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "14",
                "field_name" => "companyDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "14",
                "field_name" => "companyDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
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

        $fields = [
            [
                "category" => "15",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "₦",
                "option_value" => "₦",
            ],
            [
                "category" => "15",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "$",
                "option_value" => "$",
            ],
            [
                "category" => "15",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "C$",
                "option_value" => "C$",
            ],
            [
                "category" => "15",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "Fr",
                "option_value" => "Fr",
            ],
            [
                "category" => "15",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "€",
                "option_value" => "€",
            ],
            [
                "category" => "15",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "£",
                "option_value" => "£",
            ],
            [
                "category" => "15",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "¥",
                "option_value" => "¥",
            ],
            [
                "category" => "15",
                "field_name" => "authorisedShareCapitalCurrency",
                "option_name" => "R",
                "option_value" => "R",
            ],

            [
                "category" => "15",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "₦",
                "option_value" => "₦",
            ],
            [
                "category" => "15",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "$",
                "option_value" => "$",
            ],
            [
                "category" => "15",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "C$",
                "option_value" => "C$",
            ],
            [
                "category" => "15",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "Fr",
                "option_value" => "Fr",
            ],
            [
                "category" => "15",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "€",
                "option_value" => "€",
            ],
            [
                "category" => "15",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "£",
                "option_value" => "£",
            ],
            [
                "category" => "15",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "¥",
                "option_value" => "¥",
            ],
            [
                "category" => "15",
                "field_name" => "paidUpShareCapitalCurrency",
                "option_name" => "R",
                "option_value" => "R",
            ],
            [
                "category" => "15",
                "field_name" => "productOfInterest",
                "option_name" => "Bonds/Sukuk ",
                "option_value" => "bonds",
            ],
            [
                "category" => "15",
                "field_name" => "productOfInterest",
                "option_name" => "Treasury Bills ",
                "option_value" => "treasuryBills",
            ],
            [
                "category" => "15",
                "field_name" => "productOfInterest",
                "option_name" => "Special Bills ",
                "option_value" => "specialBills",
            ],
            [
                "category" => "15",
                "field_name" => "productOfInterest",
                "option_name" => "Commercial Papers",
                "option_value" => "commercialPapers",
            ],
            [
                "category" => "15",
                "field_name" => "productOfInterest",
                "option_name" => "Repurchase Agreements",
                "option_value" => "repurchaseAgreements",
            ],
            [
                "category" => "15",
                "field_name" => "productOfInterest",
                "option_name" => "Derivatives",
                "option_value" => "Derivatives",
            ],
            [
                "category" => "15",
                "field_name" => "productOfInterest",
                "option_name" => "Equities",
                "option_value" => "Equities",
            ],
            [
                "category" => "15",
                "field_name" => "productOfInterest",
                "option_name" => "Others",
                "option_value" => "others",
            ],
            [
                "category" => "15",
                "field_name" => "companyDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "15",
                "field_name" => "companyDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "15",
                "field_name" => "companyDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "15",
                "field_name" => "companyDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "15",
                "field_name" => "companyDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "15",
                "field_name" => "companyDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "15",
                "field_name" => "companyDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "15",
                "field_name" => "companyDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "15",
                "field_name" => "companyDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "15",
                "field_name" => "companyDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "15",
                "field_name" => "mdceoDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "15",
                "field_name" => "mdceoDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "15",
                "field_name" => "mdceoDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "15",
                "field_name" => "mdceoDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "15",
                "field_name" => "mdceoDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "15",
                "field_name" => "mdceoDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "15",
                "field_name" => "mdceoDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "15",
                "field_name" => "mdceoDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "15",
                "field_name" => "mdceoDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "15",
                "field_name" => "mdceoDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "15",
                "field_name" => "mdceoDisciplinaryFive",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "15",
                "field_name" => "mdceoDisciplinaryFive",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "15",
                "field_name" => "mdceoDisciplinarySix",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "15",
                "field_name" => "mdceoDisciplinarySix",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "15",
                "field_name" => "mdceoDisciplinarySeven",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "15",
                "field_name" => "mdceoDisciplinarySeven",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "15",
                "field_name" => "mdceoDisciplinaryEight",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "15",
                "field_name" => "mdceoDisciplinaryEight",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "15",
                "field_name" => "chiefDealerDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "15",
                "field_name" => "chiefDealerDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "15",
                "field_name" => "chiefDealerDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "15",
                "field_name" => "chiefDealerDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "15",
                "field_name" => "chiefDealerDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "15",
                "field_name" => "chiefDealerDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "15",
                "field_name" => "chiefDealerDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "15",
                "field_name" => "chiefDealerDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "15",
                "field_name" => "chiefDealerDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "15",
                "field_name" => "chiefDealerDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "15",
                "field_name" => "chiefDealerDisciplinaryFive",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "15",
                "field_name" => "chiefDealerDisciplinaryFive",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "15",
                "field_name" => "chiefComplianceOfficerDisciplinary",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "15",
                "field_name" => "chiefComplianceOfficerDisciplinary",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "15",
                "field_name" => "chiefComplianceOfficerDisciplinaryOne",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "15",
                "field_name" => "chiefComplianceOfficerDisciplinaryOne",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "15",
                "field_name" => "chiefComplianceOfficerDisciplinaryTwo",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "15",
                "field_name" => "chiefComplianceOfficerDisciplinaryTwo",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "15",
                "field_name" => "chiefComplianceOfficerDisciplinaryThree",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "15",
                "field_name" => "chiefComplianceOfficerDisciplinaryThree",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "15",
                "field_name" => "chiefComplianceOfficerDisciplinaryFour",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "15",
                "field_name" => "chiefComplianceOfficerDisciplinaryFour",
                "option_name" => "No",
                "option_value" => "no",
            ],
            [
                "category" => "15",
                "field_name" => "chiefComplianceOfficerDisciplinaryFive",
                "option_name" => "Yes",
                "option_value" => "yes",
            ],
            [
                "category" => "15",
                "field_name" => "chiefComplianceOfficerDisciplinaryFive",
                "option_name" => "No",
                "option_value" => "no",
            ],

            // [
            //     "category" => "15",
            //     "field_name" => "bankingLicense",
            //     "option_name" => "dede",
            //     "option_value" => "dede",
            // ],
            // [
            //     "category" => "15",
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
