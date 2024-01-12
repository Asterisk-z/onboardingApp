<?php

namespace Database\Seeders;

use App\Models\ApplicationField;
use Illuminate\Database\Seeder;

class ApplicationFieldSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $fields = [
            [
                "category" => '1',
                "name" => 'companyName',
                "description" => 'company Name',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '1',
                "name" => 'rcNumber',
                "description" => 'RC Number',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '1',
                "name" => 'registeredOfficeAddress',
                "description" => 'Registered Office Address',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '1',
                "name" => 'dateOfIncorporation',
                "description" => 'Date of Incorporation',
                "type" => 'date',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '1',
                "name" => 'placeOfIncorporation',
                "description" => 'Place of Incorporation',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '1',
                "name" => 'companyTelephoneNumber',
                "description" => 'Company Telephone/Mobile Number',
                "type" => 'number',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '1',
                "name" => 'companyEmailAddress',
                "description" => 'Company Email Address',
                "type" => 'email',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '1',
                "name" => 'corporateWebsiteAddress',
                "description" => 'Corporate Website Address',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '1',
                "name" => 'natureOfBusiness',
                "description" => 'Nature of Business',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],

            [
                "category" => '1',
                "name" => 'authorisedShareCapitalCurrency',
                "description" => 'Authorised Share Capital Currency',
                "type" => 'select',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '1',
                "name" => 'authorisedShareCapital',
                "description" => 'Authorised Share Capital',
                "type" => 'number',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '1',
                "name" => 'paidUpShareCapitalCurrency',
                "description" => 'Paid-up Share Capital Currency',
                "type" => 'select',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '1',
                "name" => 'paidUpShareCapital',
                "description" => 'Paid-up Share Capital',
                "type" => 'number',
                "required" => 1,
                "page" => '1',
            ],

            [
                "category" => '1',
                "name" => 'applicationPrimaryContactName',
                "description" => 'Application Primary Contact Name',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '1',
                "name" => 'applicationPrimaryContactTelephone',
                "description" => 'Application Primary Contact Telephone',
                "type" => 'number',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '1',
                "name" => 'applicationPrimaryContactEmailAddress',
                "description" => 'Application Primary Contact Email Address',
                "type" => 'email',
                "required" => 1,
                "page" => '1',
            ],

            [
                "category" => '1',
                "name" => 'bankingLicense',
                "description" => 'Banking License',
                "type" => 'select',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '1',
                "name" => 'productOfInterest',
                "description" => 'Product Of Interest',
                "type" => 'checkbox',
                "required" => 1,
                "page" => '2',
            ],
        ];

        foreach ($fields as $field) {
            if (ApplicationField::where('category', $field['category'])->where('name', $field['name'])->exists()) {
                continue;
            }

            ApplicationField::create([
                "category" => $field['category'],
                "name" => $field['name'],
                "description" => $field['description'],
                "type" => $field['type'],
                "required" => $field['required'],
                "page" => $field['page'],
            ]);
        }
        // $product = ApplicationField::where('category', '1')->where('name', 'productOfInterest')->first();

        // dd($product);
        $fields = [
            [
                "category" => '1',
                "name" => 'MonthlyAverageValueOfTradesPerProductBonds',
                "description" => 'Monthly Average Value Of Trades Per Product Bonds',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => ApplicationField::where('category', '1')->where('name', 'productOfInterest')->first()->id, //'18',
            ],
            [
                "category" => '1',
                "name" => 'MonthlyAverageValueOfTradesPerProductTreasuryBills',
                "description" => 'Monthly Average Value Of Trades Per Product Treasury Bills',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => ApplicationField::where('category', '1')->where('name', 'productOfInterest')->first()->id, //'18',
            ],
            [
                "category" => '1',
                "name" => 'MonthlyAverageValueOfTradesPerProductCommercialPaper',
                "description" => 'Monthly Average Value Of Trades Per Product Commercial Paper',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => ApplicationField::where('category', '1')->where('name', 'productOfInterest')->first()->id, //'18',
            ],
            [
                "category" => '1',
                "name" => 'MonthlyAverageValueOfTradesPerProductMoneyMarket',
                "description" => 'Monthly Average Value Of Trades Per Product Money Market',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => ApplicationField::where('category', '1')->where('name', 'productOfInterest')->first()->id, //'18',
            ],
            [
                "category" => '1',
                "name" => 'MonthlyAverageValueOfTradesPerProductForeignExchange',
                "description" => 'Monthly Average Value Of Trades Per Product Foreign Exchange',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => ApplicationField::where('category', '1')->where('name', 'productOfInterest')->first()->id, //'18',
            ],
            [
                "category" => '1',
                "name" => 'MonthlyAverageValueOfTradesPerProductDerivatives',
                "description" => 'Monthly Average Value Of Trades Per Product Derivatives',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => ApplicationField::where('category', '1')->where('name', 'productOfInterest')->first()->id, //'18',
            ],
            [
                "category" => '1',
                "name" => 'MonthlyAverageValueOfTradesPerProductOthers',
                "description" => 'Monthly Average Value Of Trades Per Product Others',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => ApplicationField::where('category', '1')->where('name', 'productOfInterest')->first()->id, //'18',
            ],
            [
                "category" => '1',
                "name" => 'AverageTradeSizePerTransactionBonds',
                "description" => 'Average Trade Size Per Transaction Bonds',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => ApplicationField::where('category', '1')->where('name', 'productOfInterest')->first()->id, //'18',
            ],
            [
                "category" => '1',
                "name" => 'AverageTradeSizePerTransactionTreasuryBills',
                "description" => 'Average Trade Size Per Transaction Treasury Bills',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => ApplicationField::where('category', '1')->where('name', 'productOfInterest')->first()->id, //'18',
            ],
            [
                "category" => '1',
                "name" => 'AverageTradeSizePerTransactionCommercialPaper',
                "description" => 'Average Trade Size Per Transaction Commercial Paper',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => ApplicationField::where('category', '1')->where('name', 'productOfInterest')->first()->id, //'18',
            ],
            [
                "category" => '1',
                "name" => 'AverageTradeSizePerTransactionMoneyMarket',
                "description" => 'Average Trade Size Per Transaction Money Market',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => ApplicationField::where('category', '1')->where('name', 'productOfInterest')->first()->id, //'18',
            ],
            [
                "category" => '1',
                "name" => 'AverageTradeSizePerTransactionForeignExchange',
                "description" => 'Average Trade Size Per Transaction Foreign Exchange',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => ApplicationField::where('category', '1')->where('name', 'productOfInterest')->first()->id, //'18',
            ],
            [
                "category" => '1',
                "name" => 'AverageTradeSizePerTransactionDerivatives',
                "description" => 'Average Trade Size Per Transaction Derivatives',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => ApplicationField::where('category', '1')->where('name', 'productOfInterest')->first()->id, //'18',
            ],
            [
                "category" => '1',
                "name" => 'AverageTradeSizePerTransactionOthers',
                "description" => 'Average Trade Size Per Transaction Others',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => ApplicationField::where('category', '1')->where('name', 'productOfInterest')->first()->id, //'18',
            ],
            [
                "category" => '1',
                "name" => 'applicationPrimaryContactTelephone',
                "description" => 'Application Primary Contact Telephone',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
            ],
            [
                "category" => '1',
                "name" => 'directionOfTrades',
                "description" => 'Direction of Trades',
                "type" => 'select',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '1',
                "name" => 'bankDetailName',
                "description" => 'Bank Name',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '1',
                "name" => 'bankDetailAddress',
                "description" => 'Bank Address',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '1',
                "name" => 'bankDetailTelephone',
                "description" => 'Bank Telephone',
                "type" => 'number',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '1',
                "name" => 'bankDetailMobileNumberOfAccountManager',
                "description" => 'Bank Mobile No. of Account Manager',
                "type" => 'number',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '1',
                "name" => 'bankDetailEmailAddressOfAccountManager',
                "description" => 'Bank Email Address of Account Manager',
                "type" => 'email',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '1',
                "name" => 'bankDetailTypeOfAccount',
                "description" => 'Bank Type of Account',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '1',
                "name" => 'custodianInformationName',
                "description" => 'Custodian Information Name',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '1',
                "name" => 'custodianInformationAddress',
                "description" => 'Custodian Information Address',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '1',
                "name" => 'custodianInformationTelephone',
                "description" => 'Custodian Information Telephone',
                "type" => 'number',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '1',
                "name" => 'custodianInformationMobileNumberOfContact',
                "description" => 'Custodian Information Mobile Number Of Contact',
                "type" => 'number',
                "required" => 1,
                "page" => '2',
            ],

            [
                "category" => '1',
                "name" => 'companyDisciplinary',
                "description" => 'The Company',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
            ],
        ];

        foreach ($fields as $field) {
            if (ApplicationField::where('category', $field['category'])->where('name', $field['name'])->exists()) {
                continue;
            }

            ApplicationField::create([
                "category" => $field['category'],
                "name" => $field['name'],
                "description" => $field['description'],
                "type" => $field['type'],
                "required" => $field['required'],
                "page" => $field['page'],
            ]);
        }

        $fields = [
            [
                "category" => '1',
                "name" => 'companyDisciplinaryOne',
                "description" => 'Has the company (or any of its affiliates ), been denied registration or expelled from membership of any securities exchange, self-regulatory organisation (SRO) or associations?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '1')->where('name', 'companyDisciplinary')->first()->id,
            ],
            [
                "category" => '1',
                "name" => 'companyDisciplinaryTwo',
                "description" => 'Has your membership, or that of any affiliates, in any of the institutions/ associations mentioned above at any time been revoked, suspended or withdrawn?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '1')->where('name', 'companyDisciplinary')->first()->id,
            ],
            [
                "category" => '1',
                "name" => 'companyDisciplinaryThree',
                "description" => 'Has your company, or any of its affiliates, ever been refused a Fidelity Bond?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '1')->where('name', 'companyDisciplinary')->first()->id,
            ],
            [
                "category" => '1',
                "name" => 'companyDisciplinaryFour',
                "description" => 'Has your company, or any of its affiliates, been subject to any winding up order/receivership arrangement? ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '1')->where('name', 'companyDisciplinary')->first()->id,
            ],
            [
                "category" => '1',
                "name" => 'mdceoDisciplinary',
                "description" => 'The MD/CEO',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
            ],
        ];

        foreach ($fields as $field) {
            if (ApplicationField::where('category', $field['category'])->where('name', $field['name'])->exists()) {
                continue;
            }

            ApplicationField::create([
                "category" => $field['category'],
                "name" => $field['name'],
                "description" => $field['description'],
                "type" => $field['type'],
                "required" => $field['required'],
                "page" => $field['page'],
            ]);
        }

        $fields = [
            [
                "category" => '1',
                "name" => 'mdceoDisciplinaryOne',
                "description" => 'Ever been convicted of any criminal offence? ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '1')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '1',
                "name" => 'mdceoDisciplinaryTwo',
                "description" => 'Ever been the subject of an adverse finding by, or settlement with, any government agency, court, securities exchange, SRO, tribunal or other regulatory authority? ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '1')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '1',
                "name" => 'mdceoDisciplinaryThree',
                "description" => 'Ever been a Director, partner or otherwise concerned in the management of a business which has gone into insolvency, liquidation, administration or the equivalent proceedings within or outside of the Nigerian jurisdiction while connected with such organisation within one year of that connection? ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '1')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '1',
                "name" => 'mdceoDisciplinaryFour',
                "description" => 'Ever been declared bankrupt or entered into any compromise arrangement with creditors related to bankruptcy or insolvency?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '1')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '1',
                "name" => 'mdceoDisciplinaryFive',
                "description" => 'Ever been the subject of any disciplinary or criminal proceedings or been the subject of any investigation by any authority which may lead to such proceedings?	',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '1')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '1',
                "name" => 'mdceoDisciplinarySix',
                "description" => 'Ever been refused authorisation or licence to carry on a trade, business or profession or to be a member of a securities exchange?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '1')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '1',
                "name" => 'mdceoDisciplinarySeven',
                "description" => 'Ever had such authorisation, membership or licence (referred to above) revoked or terminated?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '1')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '1',
                "name" => 'mdceoDisciplinaryEight',
                "description" => 'Ever been disqualified from acting as a Director?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '1')->where('name', 'mdceoDisciplinary')->first()->id,
            ],

            [
                "category" => '1',
                "name" => 'treasureDisciplinary',
                "description" => 'The Treasure',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
            ],
        ];

        foreach ($fields as $field) {
            if (ApplicationField::where('category', $field['category'])->where('name', $field['name'])->exists()) {
                continue;
            }

            ApplicationField::create([
                "category" => $field['category'],
                "name" => $field['name'],
                "description" => $field['description'],
                "type" => $field['type'],
                "required" => $field['required'],
                "page" => $field['page'],
            ]);
        }

        $fields = [
            [
                "category" => '1',
                "name" => 'treasureDisciplinaryOne',
                "description" => 'Ever been convicted of any criminal offence?  ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '1')->where('name', 'treasureDisciplinary')->first()->id,
            ],
            [
                "category" => '1',
                "name" => 'treasureDisciplinaryTwo',
                "description" => 'Ever been the subject of an adverse finding by, or settlement with, any government agency, court, securities exchange, SRO, tribunal or other regulatory authority?  ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '1')->where('name', 'treasureDisciplinary')->first()->id,
            ],
            [
                "category" => '1',
                "name" => 'treasureDisciplinaryThree',
                "description" => 'Ever been concerned in the management of a business which has gone into insolvency, liquidation, administration or the equivalent proceedings within or outside of the Nigerian jurisdiction while connected with such organisation within one year of that connection?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '1')->where('name', 'treasureDisciplinary')->first()->id,
            ],
            [
                "category" => '1',
                "name" => 'treasureDisciplinaryFour',
                "description" => 'Ever been declared bankrupt or entered into any compromise arrangement with creditors related to bankruptcy or insolvency?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '1')->where('name', 'treasureDisciplinary')->first()->id,
            ],
            [
                "category" => '1',
                "name" => 'treasureDisciplinaryFive',
                "description" => 'Ever been the subject of any disciplinary or criminal proceedings or been the subject of any investigation by any authority which may lead to such proceedings?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '1')->where('name', 'treasureDisciplinary')->first()->id,
            ],

            [
                "category" => '1',
                "name" => 'chiefComplianceOfficerDisciplinary',
                "description" => 'The Chief Compliance Officer',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
            ],
        ];

        foreach ($fields as $field) {
            if (ApplicationField::where('category', $field['category'])->where('name', $field['name'])->exists()) {
                continue;
            }

            ApplicationField::create([
                "category" => $field['category'],
                "name" => $field['name'],
                "description" => $field['description'],
                "type" => $field['type'],
                "required" => $field['required'],
                "page" => $field['page'],
            ]);
        }

        $fields = [
            [
                "category" => '1',
                "name" => 'chiefComplianceOfficerDisciplinaryOne',
                "description" => 'Ever been convicted of any criminal offence? ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '1')->where('name', 'chiefComplianceOfficerDisciplinary')->first()->id,
            ],
            [
                "category" => '1',
                "name" => 'chiefComplianceOfficerDisciplinaryTwo',
                "description" => 'Ever been the subject of an adverse finding by, or settlement with, any government agency, court, securities exchange, SRO, tribunal or other regulatory authority?   ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '1')->where('name', 'chiefComplianceOfficerDisciplinary')->first()->id,
            ],
            [
                "category" => '1',
                "name" => 'chiefComplianceOfficerDisciplinaryThree',
                "description" => 'Ever been concerned in the management of a business which has gone into insolvency, liquidation, administration or the equivalent proceedings within or outside of the Nigerian jurisdiction while connected with such organisation within one year of that connection? ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '1')->where('name', 'chiefComplianceOfficerDisciplinary')->first()->id,
            ],
            [
                "category" => '1',
                "name" => 'chiefComplianceOfficerDisciplinaryFour',
                "description" => 'Ever been declared bankrupt or entered into any compromise arrangement with creditors related to bankruptcy or insolvency?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '1')->where('name', 'chiefComplianceOfficerDisciplinary')->first()->id,
            ],
            [
                "category" => '1',
                "name" => 'chiefComplianceOfficerDisciplinaryFive',
                "description" => 'Ever been the subject of any disciplinary or criminal proceedings or been the subject of any investigation by any Authority which may lead to such proceedings?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '1')->where('name', 'chiefComplianceOfficerDisciplinary')->first()->id,
            ],

            // [
            //     "category" => '1',
            //     "name" => 'mdceoDisciplinaryOne',
            //     "description" => 'mdceoDisciplinaryOne',
            //     "type" => 'select',
            //     "required" => 1,
            //     "page" => '3',
            // ],
            // [
            //     "category" => '1',
            //     "name" => 'companyDisciplinaryOne',
            //     "description" => 'companyDisciplinaryOne',
            //     "type" => 'select',
            //     "required" => 1,
            //     "page" => '3',
            // ],
            // [
            //     "category" => '1',
            //     "name" => 'companyDisciplinaryOne',
            //     "description" => 'companyDisciplinaryOne',
            //     "type" => 'select',
            //     "required" => 1,
            //     "page" => '3',
            // ],
            // [
            //     "category" => '1',
            //     "name" => 'companyDisciplinaryOne',
            //     "description" => 'companyDisciplinaryOne',
            //     "type" => 'select',
            //     "required" => 1,
            //     "page" => '3',
            // ],
            // [
            //     "category" => '1',
            //     "name" => 'companyDisciplinaryOne',
            //     "description" => 'companyDisciplinaryOne',
            //     "type" => 'select',
            //     "required" => 1,
            //     "page" => '3',
            // ],
            // [
            //     "category" => '1',
            //     "name" => 'companyDisciplinaryOne',
            //     "description" => 'companyDisciplinaryOne',
            //     "type" => 'select',
            //     "required" => 1,
            //     "page" => '3',
            // ],
            // [
            //     "category" => '1',
            //     "name" => 'companyDisciplinaryOne',
            //     "description" => 'companyDisciplinaryOne',
            //     "type" => 'select',
            //     "required" => 1,
            //     "page" => '3',
            // ],
            // [
            //     "category" => '1',
            //     "name" => 'companyDisciplinaryOne',
            //     "description" => 'companyDisciplinaryOne',
            //     "type" => 'select',
            //     "required" => 1,
            //     "page" => '3',
            // ],
            // [
            //     "category" => '1',
            //     "name" => 'companyDisciplinaryOne',
            //     "description" => 'companyDisciplinaryOne',
            //     "type" => 'select',
            //     "required" => 1,
            //     "page" => '3',
            // ],
            // [
            //     "category" => '1',
            //     "name" => 'companyDisciplinaryOne',
            //     "description" => 'companyDisciplinaryOne',
            //     "type" => 'select',
            //     "required" => 1,
            //     "page" => '3',
            // ],

        ];

        foreach ($fields as $field) {
            if (ApplicationField::where('category', $field['category'])->where('name', $field['name'])->exists()) {
                continue;
            }

            ApplicationField::create([
                "category" => $field['category'],
                "name" => $field['name'],
                "description" => $field['description'],
                "type" => $field['type'],
                "required" => $field['required'],
                "page" => $field['page'],
            ]);
        }

    }
}
