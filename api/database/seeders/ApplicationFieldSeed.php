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
                "description" => 'Company Name',
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
                "type" => 'url',
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
                "parent_id" => isset($field['parent_id']) ? $field['parent_id'] : null,
            ]);
        }
        $product = ApplicationField::where('category', '1')->where('name', 'productOfInterest')->first();

        $fields = [
            [
                "category" => '1',
                "name" => 'MonthlyAverageValueOfTradesPerProductBonds',
                "description" => 'Monthly Average Value Of Trades Per Product Bonds (₦)',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '1',
                "name" => 'MonthlyAverageValueOfTradesPerProductTreasuryBills',
                "description" => 'Monthly Average Value Of Trades Per Product Treasury Bills (₦)',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '1',
                "name" => 'MonthlyAverageValueOfTradesPerProductCommercialPaper',
                "description" => 'Monthly Average Value Of Trades Per Product Commercial Paper (₦)',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '1',
                "name" => 'MonthlyAverageValueOfTradesPerProductMoneyMarket',
                "description" => 'Monthly Average Value Of Trades Per Product Money Market',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '1',
                "name" => 'MonthlyAverageValueOfTradesPerProductForeignExchange',
                "description" => 'Monthly Average Value Of Trades Per Product Foreign Exchange',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '1',
                "name" => 'MonthlyAverageValueOfTradesPerProductDerivatives',
                "description" => 'Monthly Average Value Of Trades Per Product Derivatives',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '1',
                "name" => 'MonthlyAverageValueOfTradesPerProductOthers',
                "description" => 'Monthly Average Value Of Trades Per Product Others',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '1',
                "name" => 'AverageTradeSizePerTransactionBonds',
                "description" => 'Average Trade Size Per Transaction Bonds',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '1',
                "name" => 'AverageTradeSizePerTransactionTreasuryBills',
                "description" => 'Average Trade Size Per Transaction Treasury Bills (₦)',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '1',
                "name" => 'AverageTradeSizePerTransactionCommercialPaper',
                "description" => 'Average Trade Size Per Transaction Commercial Paper (₦)',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '1',
                "name" => 'AverageTradeSizePerTransactionMoneyMarket',
                "description" => 'Average Trade Size Per Transaction Money Market',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '1',
                "name" => 'AverageTradeSizePerTransactionForeignExchange',
                "description" => 'Average Trade Size Per Transaction Foreign Exchange',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '1',
                "name" => 'AverageTradeSizePerTransactionDerivatives',
                "description" => 'Average Trade Size Per Transaction Derivatives',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '1',
                "name" => 'AverageTradeSizePerTransactionOthers',
                "description" => 'Average Trade Size Per Transaction Others',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
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
                "required" => 0,
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
                "parent_id" => isset($field['parent_id']) ? $field['parent_id'] : null,
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
                "required" => 0,
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
                "parent_id" => isset($field['parent_id']) ? $field['parent_id'] : null,
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
                "required" => 0,
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
                "parent_id" => isset($field['parent_id']) ? $field['parent_id'] : null,
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
                "required" => 0,
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
                "parent_id" => isset($field['parent_id']) ? $field['parent_id'] : null,
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

            [
                "category" => '1',
                "name" => 'CompanyOverview',
                "description" => 'Company Profile containing brief description of the following inter alias: History & Company Overview  & Details of Business Services & Profiles of Board of Directors & Profiles of Executive Management Staff',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '1',
                "name" => 'certificateOfIncorporation',
                "description" => 'Certificate of Incorporation',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '1',
                "name" => 'memorandumAndArticlesOfAssociation',
                "description" => 'Memorandum and Articles of Association',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '1',
                "name" => 'particularsOfDirectors',
                "description" => 'Particulars of Directors – CAC Form 7',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '1',
                "name" => 'particularsOfShareholders',
                "description" => 'Particulars of Shareholders – CAC Form 2 [for Private Companies (Ltd.) only]	',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '1',
                "name" => 'evidenceOfRegistration',
                "description" => 'Evidence of registration with the Securities and Exchange Commission (SEC) of Nigeria ',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '1',
                "name" => 'detailedResumesOfSEC',
                "description" => 'Detailed resumes of SEC registered sponsored individuals',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '1',
                "name" => 'evidenceOfCompliance',
                "description" => 'Evidence of compliance with the minimum paid-up capital as stipulated by SEC/Central Bank of Nigeria (CBN)	',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            // [
            //     "category" => '1',
            //     "name" => 'listOfAuthorisedRepresentatives',
            //     "description" => 'List of Authorised Representatives  (stating their designations)	',
            //     "type" => 'file',
            //     "required" => 1,
            //     "page" => '4',
            // ],
            [
                "category" => '1',
                "name" => 'latestFidelityBond ',
                "description" => 'Latest Fidelity Bond ',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '1',
                "name" => 'mostRecentYearAuditedFinancialStatements',
                "description" => 'Most recent one (1) year audited financial statements, not exceeding eighteen (18) months from end of the last financial year',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '1',
                "name" => 'evidenceFXAuthorisedDealershipLicence',
                "description" => 'Evidence of an FX Authorised Dealership Licence (if applicable)',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            // [
            //     "category" => '1',
            //     "name" => 'evidenceOfPaymentOfApplicationFee',
            //     "description" => 'Evidence of Payment of Application Fee ',
            //     "type" => 'file',
            //     "required" => 1,
            //     "page" => '4',
            // ],
            [
                "category" => '1',
                "name" => 'applicantDeclarationTextOne',
                "description" => 'We declare that the information provided is complete and accurate and we agree, if approved, to comply with and be bound by the Rules of FMDQ Exchange, which are or may be in force from time to time',
                "type" => 'text',
                "required" => 0,
                "page" => '5',
            ],
            [
                "category" => '1',
                "name" => 'applicantDeclarationTextOne',
                "description" => 'We further declare that we will update our trading practices in line with the Rules. We will notify FMDQ Exchange of any additional information which is relevant to the application and of any significant changes in the information provided in this application form which occur after the date of submission of the application ',
                "type" => 'text',
                "required" => 0,
                "page" => '5',
            ],
            [
                "category" => '1',
                "name" => 'applicantDeclarationTextOne',
                "description" => 'We understand that misleading or attempting to mislead FMDQ Exchange during the application process will be deemed an act of misconduct and may render the applicant liable to disciplinary proceedings',
                "type" => 'text',
                "required" => 0,
                "page" => '5',
            ],
            [
                "category" => '1',
                "name" => 'applicantDeclarationTextOne',
                "description" => 'We agree that any entity within FMDQ Group may have access to the information contained herein for marketing purposes',
                "type" => 'text',
                "required" => 0,
                "page" => '5',
            ],
            [
                "category" => '1',
                "name" => 'applicantDeclarationTextOne',
                "description" => 'We undertake to comply with FMDQ Exchange’s Rules, the Investment and Securities Act (ISA) 2007, Securities and Exchange Commission Rules and any other regulatory enactment relating to trading activities on the Exchange, as may be amended from time to time',
                "type" => 'text',
                "required" => 0,
                "page" => '5',
            ],
            [
                "category" => '1',
                "name" => 'applicantDeclaration',
                "description" => 'Applicant Declaration',
                "type" => 'file',
                "required" => 1,
                "page" => '5',
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
                "parent_id" => isset($field['parent_id']) ? $field['parent_id'] : null,
            ]);
        }

        // DEALING MEMMBER SPECIALIST CATEGORY
        $fields = [
            [
                "category" => '2',
                "name" => 'companyName',
                "description" => 'Company Name',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '2',
                "name" => 'rcNumber',
                "description" => 'RC Number',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '2',
                "name" => 'registeredOfficeAddress',
                "description" => 'Registered Office Address',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '2',
                "name" => 'dateOfIncorporation',
                "description" => 'Date of Incorporation',
                "type" => 'date',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '2',
                "name" => 'placeOfIncorporation',
                "description" => 'Place of Incorporation',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '2',
                "name" => 'companyTelephoneNumber',
                "description" => 'Company Telephone/Mobile Number',
                "type" => 'number',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '2',
                "name" => 'companyEmailAddress',
                "description" => 'Company Email Address',
                "type" => 'email',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '2',
                "name" => 'corporateWebsiteAddress',
                "description" => 'Corporate Website Address',
                "type" => 'url',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '2',
                "name" => 'natureOfBusiness',
                "description" => 'Nature of Business',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],

            [
                "category" => '2',
                "name" => 'authorisedShareCapitalCurrency',
                "description" => 'Authorised Share Capital Currency',
                "type" => 'select',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '2',
                "name" => 'authorisedShareCapital',
                "description" => 'Authorised Share Capital',
                "type" => 'number',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '2',
                "name" => 'paidUpShareCapitalCurrency',
                "description" => 'Paid-up Share Capital Currency',
                "type" => 'select',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '2',
                "name" => 'paidUpShareCapital',
                "description" => 'Paid-up Share Capital',
                "type" => 'number',
                "required" => 1,
                "page" => '1',
            ],

            [
                "category" => '2',
                "name" => 'applicationPrimaryContactName',
                "description" => 'Primary Contact Name',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '2',
                "name" => 'applicationPrimaryContactTelephone',
                "description" => 'Primary Contact Telephone',
                "type" => 'number',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '2',
                "name" => 'applicationPrimaryContactEmailAddress',
                "description" => 'Primary Contact Email Address',
                "type" => 'email',
                "required" => 1,
                "page" => '1',
            ],

            [
                "category" => '2',
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
                "parent_id" => isset($field['parent_id']) ? $field['parent_id'] : null,
            ]);
        }

        $product = ApplicationField::where('category', '2')->where('name', 'productOfInterest')->first();

        $fields = [
            [
                "category" => '2',
                "name" => 'MonthlyAverageValueOfTradesPerProductBonds',
                "description" => 'Monthly Average Value Of Trades Per Product Bonds (₦)',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '2',
                "name" => 'MonthlyAverageValueOfTradesPerProductTreasuryBills',
                "description" => 'Monthly Average Value Of Trades Per Product Treasury Bills (₦)',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '2',
                "name" => 'MonthlyAverageValueOfTradesPerProductOthers',
                "description" => 'Monthly Average Value Of Trades Per Product Others',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '2',
                "name" => 'AverageTradeSizePerTransactionBonds',
                "description" => 'Average Trade Size Per Transaction Bonds',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '2',
                "name" => 'AverageTradeSizePerTransactionTreasuryBills',
                "description" => 'Average Trade Size Per Transaction Treasury Bills (₦)',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '2',
                "name" => 'AverageTradeSizePerTransactionOthers',
                "description" => 'Average Trade Size Per Transaction Others',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '2',
                "name" => 'directionOfTrades',
                "description" => 'Direction of Trades',
                "type" => 'select',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '2',
                "name" => 'bankDetailNameOne',
                "description" => 'Bank Name 1',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '2',
                "name" => 'bankDetailAddressOne',
                "description" => 'Bank Address 1',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '2',
                "name" => 'bankDetailTelephoneOne',
                "description" => 'Bank Telephone 1',
                "type" => 'number',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '2',
                "name" => 'bankDetailMobileNumberOfAccountManagerOne',
                "description" => 'Bank Mobile No. of Account Manager 1',
                "type" => 'number',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '2',
                "name" => 'bankDetailEmailAddressOfAccountManagerOne',
                "description" => 'Bank Email Address of Account Manager 1',
                "type" => 'email',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '2',
                "name" => 'bankDetailTypeOfAccountOne',
                "description" => 'Bank Type of Account 1',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],

            [
                "category" => '2',
                "name" => 'bankDetailNameTwo',
                "description" => 'Bank Name 2',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '2',
                "name" => 'bankDetailAddressTwo',
                "description" => 'Bank Address 2',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '2',
                "name" => 'bankDetailTelephoneTwo',
                "description" => 'Bank Telephone 2',
                "type" => 'number',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '2',
                "name" => 'bankDetailMobileNumberOfAccountManagerTwo',
                "description" => 'Bank Mobile No. of Account Manager 2',
                "type" => 'number',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '2',
                "name" => 'bankDetailEmailAddressOfAccountManagerTwo',
                "description" => 'Bank Email Address of Account Manager 2',
                "type" => 'email',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '2',
                "name" => 'bankDetailTypeOfAccountTwo',
                "description" => 'Bank Type of Account 2',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '2',
                "name" => 'custodianInformationName',
                "description" => 'Custodian Information Name',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '2',
                "name" => 'custodianInformationAddress',
                "description" => 'Custodian Information Address',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '2',
                "name" => 'custodianInformationTelephone',
                "description" => 'Custodian Information Telephone',
                "type" => 'number',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '2',
                "name" => 'custodianInformationMobileNumberOfContact',
                "description" => 'Custodian Information Mobile Number Of Contact',
                "type" => 'number',
                "required" => 1,
                "page" => '2',
            ],

            [
                "category" => '2',
                "name" => 'companyDisciplinary',
                "description" => 'The Company',
                "type" => 'select',
                "required" => 0,
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
                "parent_id" => isset($field['parent_id']) ? $field['parent_id'] : null,
            ]);
        }

        $fields = [
            [
                "category" => '2',
                "name" => 'companyDisciplinaryOne',
                "description" => 'Has the company (or any of its affiliates ), been denied registration or expelled from membership of any securities exchange, self-regulatory organisation (SRO) or associations?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '2')->where('name', 'companyDisciplinary')->first()->id,
            ],
            [
                "category" => '2',
                "name" => 'companyDisciplinaryTwo',
                "description" => 'Has your membership, or that of any affiliates, in any of the institutions/ associations mentioned above at any time been revoked, suspended or withdrawn?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '2')->where('name', 'companyDisciplinary')->first()->id,
            ],
            [
                "category" => '2',
                "name" => 'companyDisciplinaryThree',
                "description" => 'Has your company, or any of its affiliates, ever been refused a Fidelity Bond?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '2')->where('name', 'companyDisciplinary')->first()->id,
            ],
            [
                "category" => '2',
                "name" => 'companyDisciplinaryFour',
                "description" => 'Has your company, or any of its affiliates, been subject to any winding up order/receivership arrangement?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '2')->where('name', 'companyDisciplinary')->first()->id,
            ],
            [
                "category" => '2',
                "name" => 'mdceoDisciplinary',
                "description" => 'The MD/CEO',
                "type" => 'select',
                "required" => 0,
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
                "parent_id" => isset($field['parent_id']) ? $field['parent_id'] : null,
            ]);
        }

        $fields = [
            [
                "category" => '2',
                "name" => 'mdceoDisciplinaryOne',
                "description" => 'Ever been convicted of any criminal offence? ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '2')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '2',
                "name" => 'mdceoDisciplinaryTwo',
                "description" => 'Ever been the subject of an adverse finding by, or settlement with, any government agency, court, securities exchange, SRO, tribunal or other regulatory authority? ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '2')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '2',
                "name" => 'mdceoDisciplinaryThree',
                "description" => 'Ever been a Director, partner or otherwise concerned in the management of a business which has gone into insolvency, liquidation, administration or the equivalent proceedings within or outside of the Nigerian jurisdiction while connected with such organisation within one year of that connection?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '2')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '2',
                "name" => 'mdceoDisciplinaryFour',
                "description" => 'Ever been declared bankrupt or entered into any compromise arrangement with creditors related to bankruptcy or insolvency?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '2')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '2',
                "name" => 'mdceoDisciplinaryFive',
                "description" => 'Ever been the subject of any disciplinary or criminal proceedings or been the subject of any investigation by any authority which may lead to such proceedings?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '2')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '2',
                "name" => 'mdceoDisciplinarySix',
                "description" => 'Ever been refused authorisation or licence to carry on a trade, business or profession or to be a member of a securities exchange?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '2')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '2',
                "name" => 'mdceoDisciplinarySeven',
                "description" => 'Ever had such authorisation, membership or licence (referred to above) revoked or terminated?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '2')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '2',
                "name" => 'mdceoDisciplinaryEight',
                "description" => 'Ever been disqualified from acting as a Director?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '2')->where('name', 'mdceoDisciplinary')->first()->id,
            ],

            [
                "category" => '2',
                "name" => 'dealerDisciplinary',
                "description" => 'The Dealer',
                "type" => 'select',
                "required" => 0,
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
                "parent_id" => isset($field['parent_id']) ? $field['parent_id'] : null,
            ]);
        }

        $fields = [
            [
                "category" => '2',
                "name" => 'dealerDisciplinaryOne',
                "description" => 'Ever been convicted of any criminal offence?  ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '2')->where('name', 'dealerDisciplinary')->first()->id,
            ],
            [
                "category" => '2',
                "name" => 'dealerDisciplinaryTwo',
                "description" => 'Ever been the subject of an adverse finding by, or settlement with, any government agency, court, securities exchange, SRO, tribunal or other regulatory authority?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '2')->where('name', 'dealerDisciplinary')->first()->id,
            ],
            [
                "category" => '2',
                "name" => 'dealerDisciplinaryThree',
                "description" => 'Ever been concerned in the management of a business which has gone into insolvency, liquidation, administration or the equivalent proceedings within or outside of the Nigerian jurisdiction while connected with such organisation within one year of that connection?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '2')->where('name', 'dealerDisciplinary')->first()->id,
            ],
            [
                "category" => '2',
                "name" => 'dealerDisciplinaryFour',
                "description" => 'Ever been declared bankrupt or entered into any compromise arrangement with creditors related to bankruptcy or insolvency?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '2')->where('name', 'dealerDisciplinary')->first()->id,
            ],
            [
                "category" => '2',
                "name" => 'dealerDisciplinaryFive',
                "description" => 'Ever been the subject of any disciplinary or criminal proceedings or been the subject of any investigation by any authority which may lead to such proceedings?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '2')->where('name', 'dealerDisciplinary')->first()->id,
            ],

            [
                "category" => '2',
                "name" => 'chiefComplianceOfficerDisciplinary',
                "description" => 'The Chief Compliance Officer',
                "type" => 'select',
                "required" => 0,
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
                "parent_id" => isset($field['parent_id']) ? $field['parent_id'] : null,
            ]);
        }

        $fields = [
            [
                "category" => '2',
                "name" => 'chiefComplianceOfficerDisciplinaryOne',
                "description" => 'Ever been convicted of any criminal offence? ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '2')->where('name', 'chiefComplianceOfficerDisciplinary')->first()->id,
            ],
            [
                "category" => '2',
                "name" => 'chiefComplianceOfficerDisciplinaryTwo',
                "description" => 'Ever been the subject of an adverse finding by, or settlement with, any government agency, court, securities exchange, SRO, tribunal or other regulatory authority?  ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '2')->where('name', 'chiefComplianceOfficerDisciplinary')->first()->id,
            ],
            [
                "category" => '2',
                "name" => 'chiefComplianceOfficerDisciplinaryThree',
                "description" => 'Ever been concerned in the management of a business which has gone into insolvency, liquidation, administration or the equivalent proceedings within or outside of the Nigerian jurisdiction while connected with such organisation within one year of that connection? ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '2')->where('name', 'chiefComplianceOfficerDisciplinary')->first()->id,
            ],
            [
                "category" => '2',
                "name" => 'chiefComplianceOfficerDisciplinaryFour',
                "description" => 'Ever been declared bankrupt or entered into any compromise arrangement with creditors related to bankruptcy or insolvency?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '2')->where('name', 'chiefComplianceOfficerDisciplinary')->first()->id,
            ],
            [
                "category" => '2',
                "name" => 'chiefComplianceOfficerDisciplinaryFive',
                "description" => 'Ever been the subject of any disciplinary or criminal proceedings or been the subject of any investigation by any Authority which may lead to such proceedings?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '2')->where('name', 'chiefComplianceOfficerDisciplinary')->first()->id,
            ],

            [
                "category" => '2',
                "name" => 'CompanyOverview',
                "description" => 'Company Profile containing brief description of the following inter alias: History & Company Overview  & Details of Business Services & Profiles of Board of Directors & Profiles of Executive Management Staff',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '2',
                "name" => 'dulyCompletedApplicationForm',
                "description" => 'Duly Completed Application Form',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '2',
                "name" => 'companyProfile',
                "description" => 'Company Profile, Company Overview, Details of Business Services',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '2',
                "name" => 'certificateOfIncorporation',
                "description" => 'Certificate of Incorporation',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '2',
                "name" => 'memorandumAndArticlesOfAssociation',
                "description" => 'Memorandum and Articles of Association',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '2',
                "name" => 'particularsOfDirectors',
                "description" => 'Particulars of Directors – CAC Form 7',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '2',
                "name" => 'particularsOfShareholders',
                "description" => 'Particulars of Shareholders – CAC Form 2 [for Private Companies (Ltd.) only]	',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '2',
                "name" => 'mostRecentYearAuditedFinancialStatements',
                "description" => 'Most recent one (1) year audited financial statements, not exceeding eighteen (18) months from the previous financial year end	',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '2',
                "name" => 'evidenceOfRegistration',
                "description" => 'Evidence of registration with the Securities and Exchange Commission (SEC) of Nigeria ',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '2',
                "name" => 'letterOfExpressionOfInterest',
                "description" => 'Letter of Expression of Interest to be a Dealing Member (Specialist) of FMDQ Exchange',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '2',
                "name" => 'resumeOfDealers',
                "description" => 'Resume(s) of Dealer(s) or Principal with Securities Trading Experience	',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            // [
            //     "category" => '2',
            //     "name" => 'evidenceOfPaymentOfApplicationFee',
            //     "description" => 'Evidence of Payment of Application Fee and Membership Dues  ',
            //     "type" => 'file',
            //     "required" => 1,
            //     "page" => '4',
            // ],
            [
                "category" => '2',
                "name" => 'applicantDeclaration',
                "description" => 'Applicant Declaration',
                "type" => 'file',
                "required" => 1,
                "page" => '5',
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
                "parent_id" => isset($field['parent_id']) ? $field['parent_id'] : null,
            ]);
        }

        // ASSOCIATE MEMBER BROKER CATEGORY

        $fields = [
            [
                "category" => '3',
                "name" => 'companyName',
                "description" => 'Company Name',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '3',
                "name" => 'rcNumber',
                "description" => 'RC Number',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '3',
                "name" => 'registeredOfficeAddress',
                "description" => 'Registered Office Address',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '3',
                "name" => 'dateOfIncorporation',
                "description" => 'Date of Incorporation',
                "type" => 'date',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '3',
                "name" => 'placeOfIncorporation',
                "description" => 'Place of Incorporation',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '3',
                "name" => 'companyTelephoneNumber',
                "description" => 'Company Telephone/Mobile Number',
                "type" => 'number',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '3',
                "name" => 'companyEmailAddress',
                "description" => 'Company Email Address',
                "type" => 'email',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '3',
                "name" => 'corporateWebsiteAddress',
                "description" => 'Corporate Website Address',
                "type" => 'url',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '3',
                "name" => 'natureOfBusiness',
                "description" => 'Nature of Business',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],

            [
                "category" => '3',
                "name" => 'authorisedShareCapitalCurrency',
                "description" => 'Authorised Share Capital Currency',
                "type" => 'select',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '3',
                "name" => 'authorisedShareCapital',
                "description" => 'Authorised Share Capital',
                "type" => 'number',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '3',
                "name" => 'paidUpShareCapitalCurrency',
                "description" => 'Paid-up Share Capital Currency',
                "type" => 'select',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '3',
                "name" => 'paidUpShareCapital',
                "description" => 'Paid-up Share Capital',
                "type" => 'number',
                "required" => 1,
                "page" => '1',
            ],

            [
                "category" => '3',
                "name" => 'applicationPrimaryContactName',
                "description" => 'Application Primary Contact Name',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '3',
                "name" => 'applicationPrimaryContactTelephone',
                "description" => 'Application Primary Contact Telephone',
                "type" => 'number',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '3',
                "name" => 'applicationPrimaryContactEmailAddress',
                "description" => 'Application Primary Contact Email Address',
                "type" => 'email',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '3',
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
                "parent_id" => isset($field['parent_id']) ? $field['parent_id'] : null,
            ]);
        }
        $product = ApplicationField::where('category', '3')->where('name', 'productOfInterest')->first();

        $fields = [
            [
                "category" => '3',
                "name" => 'MonthlyAverageValueOfTradesPerProductBonds',
                "description" => 'Monthly Average Value Of Trades Per Product Bonds (₦)',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '3',
                "name" => 'MonthlyAverageValueOfTradesPerProductTreasuryBills',
                "description" => 'Monthly Average Value Of Trades Per Product Treasury Bills (₦)',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '3',
                "name" => 'MonthlyAverageValueOfTradesPerProductCommercialPaper',
                "description" => 'Monthly Average Value Of Trades Per Product Commercial Paper (₦)',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '3',
                "name" => 'MonthlyAverageValueOfTradesPerProductForeignExchange',
                "description" => 'Monthly Average Value Of Trades Per Product Foreign Exchange',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '3',
                "name" => 'MonthlyAverageValueOfTradesPerProductDerivatives',
                "description" => 'Monthly Average Value Of Trades Per Product Derivatives',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '3',
                "name" => 'MonthlyAverageValueOfTradesPerProductOthers',
                "description" => 'Monthly Average Value Of Trades Per Product Others',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '3',
                "name" => 'AverageTradeSizePerTransactionBonds',
                "description" => 'Average Trade Size Per Transaction Bonds',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '3',
                "name" => 'AverageTradeSizePerTransactionTreasuryBills',
                "description" => 'Average Trade Size Per Transaction Treasury Bills (₦)',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '3',
                "name" => 'AverageTradeSizePerTransactionCommercialPaper',
                "description" => 'Average Trade Size Per Transaction Commercial Paper (₦)',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '3',
                "name" => 'AverageTradeSizePerTransactionForeignExchange',
                "description" => 'Average Trade Size Per Transaction Foreign Exchange',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '3',
                "name" => 'AverageTradeSizePerTransactionDerivatives',
                "description" => 'Average Trade Size Per Transaction Derivatives',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '3',
                "name" => 'AverageTradeSizePerTransactionOthers',
                "description" => 'Average Trade Size Per Transaction Others',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],

            [
                "category" => '3',
                "name" => 'directionOfTrades',
                "description" => 'Direction of Trades',
                "type" => 'select',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '3',
                "name" => 'bankDetailNameOne',
                "description" => 'Bank Name 1',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '3',
                "name" => 'bankDetailAddressOne',
                "description" => 'Bank Address 1',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '3',
                "name" => 'bankDetailTelephoneOne',
                "description" => 'Bank Telephone 1',
                "type" => 'number',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '3',
                "name" => 'bankDetailMobileNumberOfAccountManagerOne',
                "description" => 'Bank Mobile No. of Account Manager 1',
                "type" => 'number',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '3',
                "name" => 'bankDetailEmailAddressOfAccountManagerOne',
                "description" => 'Bank Email Address of Account Manager 1',
                "type" => 'email',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '3',
                "name" => 'bankDetailTypeOfAccountOne',
                "description" => 'Bank Type of Account 1',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],

            [
                "category" => '3',
                "name" => 'bankDetailNameTwo',
                "description" => 'Bank Name 2',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '3',
                "name" => 'bankDetailAddressTwo',
                "description" => 'Bank Address 2',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '3',
                "name" => 'bankDetailTelephoneTwo',
                "description" => 'Bank Telephone 2',
                "type" => 'number',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '3',
                "name" => 'bankDetailMobileNumberOfAccountManagerTwo',
                "description" => 'Bank Mobile No. of Account Manager 2',
                "type" => 'number',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '3',
                "name" => 'bankDetailEmailAddressOfAccountManagerTwo',
                "description" => 'Bank Email Address of Account Manager 2',
                "type" => 'email',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '3',
                "name" => 'bankDetailTypeOfAccountTwo',
                "description" => 'Bank Type of Account 2',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '3',
                "name" => 'custodianInformationName',
                "description" => 'Custodian Information Name',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '3',
                "name" => 'custodianInformationAddress',
                "description" => 'Custodian Information Address',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '3',
                "name" => 'custodianInformationTelephone',
                "description" => 'Custodian Information Telephone',
                "type" => 'number',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '3',
                "name" => 'custodianInformationMobileNumberOfContact',
                "description" => 'Custodian Information Mobile Number Of Contact',
                "type" => 'number',
                "required" => 1,
                "page" => '2',
            ],

            [
                "category" => '3',
                "name" => 'companyDisciplinary',
                "description" => 'The Company',
                "type" => 'select',
                "required" => 0,
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
                "parent_id" => isset($field['parent_id']) ? $field['parent_id'] : null,
            ]);
        }

        $fields = [
            [
                "category" => '3',
                "name" => 'companyDisciplinaryOne',
                "description" => 'Has the company or any of its affiliates , been denied registration or expelled from membership of any securities exchange, self-regulatory organisation (SRO) or associations?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '3')->where('name', 'companyDisciplinary')->first()->id,
            ],
            [
                "category" => '3',
                "name" => 'companyDisciplinaryTwo',
                "description" => 'Has your membership, or that of any affiliates, in any of the institutions/associations mentioned above at any time been revoked, suspended or withdrawn?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '3')->where('name', 'companyDisciplinary')->first()->id,
            ],
            [
                "category" => '3',
                "name" => 'companyDisciplinaryThree',
                "description" => 'Has your company, or any of its affiliates, ever been refused any Fidelity Bond?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '3')->where('name', 'companyDisciplinary')->first()->id,
            ],
            [
                "category" => '3',
                "name" => 'companyDisciplinaryFour',
                "description" => 'Has your company, or any of its affiliates, been subject to any winding up order/receivership arrangement? ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '3')->where('name', 'companyDisciplinary')->first()->id,
            ],
            [
                "category" => '3',
                "name" => 'companyDisciplinaryFive',
                "description" => 'Has your company, or any of its affiliates, been involved in litigation within ten (10) years preceding this application for the filing of any application for registration? ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '3')->where('name', 'companyDisciplinary')->first()->id,
            ],
            [
                "category" => '3',
                "name" => 'companyDisciplinarySix',
                "description" => 'Has your company, or any of its affiliates, been involved in litigation within ten (10) years preceding this application for the purchase or sale of securities? ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '3')->where('name', 'companyDisciplinary')->first()->id,
            ],
            [
                "category" => '3',
                "name" => 'companyDisciplinarySeven',
                "description" => 'Has your company, or any of its affiliates, been involved in litigation within ten (10) years preceding this application for any offence relating to the code of the business of Broker/Dealer, Issuing House, Investment Adviser, Bank or Insurance or such other related function?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '3')->where('name', 'companyDisciplinary')->first()->id,
            ],
            [
                "category" => '3',
                "name" => 'companyDisciplinaryEight',
                "description" => 'Has your company, or any of its affiliates, been involved in litigation within ten (10) years preceding this application for any criminal offence?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '3')->where('name', 'companyDisciplinary')->first()->id,
            ],
            [
                "category" => '3',
                "name" => 'companyDisciplinaryNine',
                "description" => 'Has your company, or any of its affiliates, been involved in litigation within ten (10) years preceding this application for any civil offence?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '3')->where('name', 'companyDisciplinary')->first()->id,
            ],

            [
                "category" => '3',
                "name" => 'mdceoDisciplinary',
                "description" => 'The MD/CEO',
                "type" => 'select',
                "required" => 0,
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
                "parent_id" => isset($field['parent_id']) ? $field['parent_id'] : null,
            ]);
        }

        $fields = [
            [
                "category" => '3',
                "name" => 'mdceoDisciplinaryOne',
                "description" => 'Ever been convicted of any criminal offence?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '3')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '3',
                "name" => 'mdceoDisciplinaryTwo',
                "description" => 'Ever been the subject of an adverse finding by, or settlement with, any government agency, court, securities exchange, SRO, tribunal or other regulatory authority?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '3')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '3',
                "name" => 'mdceoDisciplinaryThree',
                "description" => 'Ever been a Director, partner or otherwise concerned in the management of a business which has gone into insolvency, liquidation, administration or the similar proceedings within or outside of the Nigerian jurisdiction while connected with such organisation within one (1) year of that connection?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '3')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '3',
                "name" => 'mdceoDisciplinaryFour',
                "description" => 'Ever been declared bankrupt or entered into any compromise arrangement with creditors related to bankruptcy or insolvency?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '3')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '3',
                "name" => 'mdceoDisciplinaryFive',
                "description" => 'Ever been the subject of any disciplinary or criminal proceedings or been the subject of any investigation by any authority which may lead to such proceedings?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '3')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '3',
                "name" => 'mdceoDisciplinarySix',
                "description" => 'Ever been refused authorisation or licence to carry on a trade, business or profession or to be a member of a securities exchange?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '3')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '3',
                "name" => 'mdceoDisciplinarySeven',
                "description" => 'Ever had such authorisation, membership or licence (referred to above) revoked or terminated?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '3')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '3',
                "name" => 'mdceoDisciplinaryEight',
                "description" => 'Ever been disqualified from acting as a Director?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '3')->where('name', 'mdceoDisciplinary')->first()->id,
            ],

            [
                "category" => '3',
                "name" => 'treasureDisciplinary',
                "description" => 'The Treasure',
                "type" => 'select',
                "required" => 0,
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
                "parent_id" => isset($field['parent_id']) ? $field['parent_id'] : null,
            ]);
        }

        $fields = [
            [
                "category" => '3',
                "name" => 'treasureDisciplinaryOne',
                "description" => 'Ever been convicted of any criminal offence? ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '3')->where('name', 'treasureDisciplinary')->first()->id,
            ],
            [
                "category" => '3',
                "name" => 'treasureDisciplinaryTwo',
                "description" => 'Ever been the subject of an adverse finding by, or settlement with, any government agency, court, securities exchange, SRO, tribunal or other regulatory authority? ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '3')->where('name', 'treasureDisciplinary')->first()->id,
            ],
            [
                "category" => '3',
                "name" => 'treasureDisciplinaryThree',
                "description" => 'Ever been concerned in the management of a business which has gone into insolvency, liquidation, administration or the similar proceedings within or outside of the Nigerian jurisdiction while connected with such organisation within one (1) year of that connection?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '3')->where('name', 'treasureDisciplinary')->first()->id,
            ],
            [
                "category" => '3',
                "name" => 'treasureDisciplinaryFour',
                "description" => 'Ever been declared bankrupt or entered into any compromise arrangement with creditors related to bankruptcy or insolvency?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '3')->where('name', 'treasureDisciplinary')->first()->id,
            ],
            [
                "category" => '3',
                "name" => 'treasureDisciplinaryFive',
                "description" => 'Ever been the subject of any disciplinary or criminal proceedings or been the subject of any investigation by any authority which may lead to such proceedings?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '3')->where('name', 'treasureDisciplinary')->first()->id,
            ],

            [
                "category" => '3',
                "name" => 'chiefComplianceOfficerDisciplinary',
                "description" => 'The Chief Compliance Officer',
                "type" => 'select',
                "required" => 0,
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
                "parent_id" => isset($field['parent_id']) ? $field['parent_id'] : null,
            ]);
        }

        $fields = [
            [
                "category" => '3',
                "name" => 'chiefComplianceOfficerDisciplinaryOne',
                "description" => 'Ever been convicted of any criminal offence? ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '3')->where('name', 'chiefComplianceOfficerDisciplinary')->first()->id,
            ],
            [
                "category" => '3',
                "name" => 'chiefComplianceOfficerDisciplinaryTwo',
                "description" => 'Ever been the subject of an adverse finding by, or settlement with, any government agency, court, securities exchange, SRO, tribunal or other regulatory authority?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '3')->where('name', 'chiefComplianceOfficerDisciplinary')->first()->id,
            ],
            [
                "category" => '3',
                "name" => 'chiefComplianceOfficerDisciplinaryThree',
                "description" => 'Ever been concerned in the management of a business which has gone into insolvency, liquidation, administration or the equivalent proceedings within or outside of the Nigerian jurisdiction while connected with such organisation within one (1) year of that connection?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '3')->where('name', 'chiefComplianceOfficerDisciplinary')->first()->id,
            ],
            [
                "category" => '3',
                "name" => 'chiefComplianceOfficerDisciplinaryFour',
                "description" => 'Ever been declared bankrupt or entered into any compromise arrangement with creditors related to bankruptcy or insolvency?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '3')->where('name', 'chiefComplianceOfficerDisciplinary')->first()->id,
            ],
            [
                "category" => '3',
                "name" => 'chiefComplianceOfficerDisciplinaryFive',
                "description" => 'Ever been the subject of any disciplinary or criminal proceedings or been the subject of any investigation by any Authority which may lead to such proceedings?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '3')->where('name', 'chiefComplianceOfficerDisciplinary')->first()->id,
            ],

            [
                "category" => '3',
                "name" => 'CompanyOverview',
                "description" => 'Company Profile containing brief description of the following inter alias: History & Company Overview  & Details of Business Services & Profiles of Board of Directors & Profiles of Executive Management Staff',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '3',
                "name" => 'certificateOfIncorporation',
                "description" => 'Certificate of Incorporation',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '3',
                "name" => 'memorandumAndArticlesOfAssociation',
                "description" => 'Memorandum and Articles of Association',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '3',
                "name" => 'particularsOfDirectors',
                "description" => 'Particulars of Directors – CAC Form 7',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '3',
                "name" => 'particularsOfShareholders',
                "description" => 'Particulars of Shareholders – CAC Form 2 [for Private Companies (Ltd.) only]	',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '3',
                "name" => 'evidenceOfRegistration',
                "description" => 'Evidence of registration with the Securities and Exchange Commission (SEC) of Nigeria ',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '3',
                "name" => 'mostRecentYearAuditedFinancialStatements',
                "description" => 'Most recent one (1) year audited financial statements, not exceeding eighteen (18) months from end of the last financial year',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            // [
            //     "category" => '3',
            //     "name" => 'listOfAuthorisedRepresentatives',
            //     "description" => 'List of Authorised Representatives  (stating their designations)	',
            //     "type" => 'file',
            //     "required" => 1,
            //     "page" => '4',
            // ],

            [
                "category" => '3',
                "name" => 'detailedResumesOfSEC',
                "description" => 'Detailed resumes of SEC registered sponsored individuals',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '3',
                "name" => 'latestFidelityBond ',
                "description" => 'Latest Fidelity Bond ',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],

            [
                "category" => '3',
                "name" => 'evidenceOfCompliance',
                "description" => 'Evidence of compliance with the minimum paid-up capital as stipulated by SEC/Central Bank of Nigeria (CBN)	',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '3',
                "name" => 'evidenceOfMinimumShareholder',
                "description" => 'Evidence of minimum shareholders’ funds of N500,000,000.00 (Five Hundred Million Naira) only	',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '3',
                "name" => 'confirmationOfTechnicalKnowledge',
                "description" => 'Confirmation of technical knowledge of sponsored individuals in fixed income dealing operations',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            // [
            //     "category" => '3',
            //     "name" => 'evidenceOfPaymentOfApplicationFee',
            //     "description" => 'Evidence of Payment of Application Fee and Membership Dues ',
            //     "type" => 'file',
            //     "required" => 1,
            //     "page" => '4',
            // ],
            [
                "category" => '3',
                "name" => 'applicantDeclaration',
                "description" => 'Applicant Declaration',
                "type" => 'file',
                "required" => 1,
                "page" => '5',
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
                "parent_id" => isset($field['parent_id']) ? $field['parent_id'] : null,
            ]);
        }

        // ASSOCIATE MEMBER INTER BANK BROKER CATEGORY

        $fields = [
            [
                "category" => '4',
                "name" => 'companyName',
                "description" => 'Company Name',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '4',
                "name" => 'rcNumber',
                "description" => 'RC Number',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '4',
                "name" => 'registeredOfficeAddress',
                "description" => 'Registered Office Address',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '4',
                "name" => 'dateOfIncorporation',
                "description" => 'Date of Incorporation',
                "type" => 'date',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '4',
                "name" => 'placeOfIncorporation',
                "description" => 'Place of Incorporation',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '4',
                "name" => 'companyTelephoneNumber',
                "description" => 'Company Telephone/Mobile Number',
                "type" => 'number',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '4',
                "name" => 'companyEmailAddress',
                "description" => 'Company Email Address',
                "type" => 'email',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '4',
                "name" => 'corporateWebsiteAddress',
                "description" => 'Corporate Website Address',
                "type" => 'url',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '4',
                "name" => 'natureOfBusiness',
                "description" => 'Nature of Business',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],

            [
                "category" => '4',
                "name" => 'authorisedShareCapitalCurrency',
                "description" => 'Authorised Share Capital Currency',
                "type" => 'select',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '4',
                "name" => 'authorisedShareCapital',
                "description" => 'Authorised Share Capital',
                "type" => 'number',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '4',
                "name" => 'paidUpShareCapitalCurrency',
                "description" => 'Paid-up Share Capital Currency',
                "type" => 'select',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '4',
                "name" => 'paidUpShareCapital',
                "description" => 'Paid-up Share Capital',
                "type" => 'number',
                "required" => 1,
                "page" => '1',
            ],

            [
                "category" => '4',
                "name" => 'applicationPrimaryContactName',
                "description" => 'Application Primary Contact Name',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '4',
                "name" => 'applicationPrimaryContactTelephone',
                "description" => 'Application Primary Contact Telephone',
                "type" => 'number',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '4',
                "name" => 'applicationPrimaryContactEmailAddress',
                "description" => 'Application Primary Contact Email Address',
                "type" => 'email',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '4',
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
                "parent_id" => isset($field['parent_id']) ? $field['parent_id'] : null,
            ]);
        }
        $product = ApplicationField::where('category', '4')->where('name', 'productOfInterest')->first();

        $fields = [
            [
                "category" => '4',
                "name" => 'MonthlyAverageValueOfTradesPerProductBonds',
                "description" => 'Monthly Average Value Of Trades Per Product Bonds (₦)',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '4',
                "name" => 'MonthlyAverageValueOfTradesPerProductTreasuryBills',
                "description" => 'Monthly Average Value Of Trades Per Product Treasury Bills (₦)',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '4',
                "name" => 'MonthlyAverageValueOfTradesPerProductCommercialPaper',
                "description" => 'Monthly Average Value Of Trades Per Product Commercial Paper (₦)',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '4',
                "name" => 'MonthlyAverageValueOfTradesPerProductForeignExchange',
                "description" => 'Monthly Average Value Of Trades Per Product Foreign Exchange',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '4',
                "name" => 'MonthlyAverageValueOfTradesPerProductDerivatives',
                "description" => 'Monthly Average Value Of Trades Per Product Derivatives',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '4',
                "name" => 'MonthlyAverageValueOfTradesPerProductOthers',
                "description" => 'Monthly Average Value Of Trades Per Product Others',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '4',
                "name" => 'AverageTradeSizePerTransactionBonds',
                "description" => 'Average Trade Size Per Transaction Bonds',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '4',
                "name" => 'AverageTradeSizePerTransactionTreasuryBills',
                "description" => 'Average Trade Size Per Transaction Treasury Bills (₦)',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '4',
                "name" => 'AverageTradeSizePerTransactionCommercialPaper',
                "description" => 'Average Trade Size Per Transaction Commercial Paper (₦)',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '4',
                "name" => 'AverageTradeSizePerTransactionForeignExchange',
                "description" => 'Average Trade Size Per Transaction Foreign Exchange',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '4',
                "name" => 'AverageTradeSizePerTransactionDerivatives',
                "description" => 'Average Trade Size Per Transaction Derivatives',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '4',
                "name" => 'AverageTradeSizePerTransactionOthers',
                "description" => 'Average Trade Size Per Transaction Others',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],

            [
                "category" => '4',
                "name" => 'directionOfTrades',
                "description" => 'Direction of Trades',
                "type" => 'select',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '4',
                "name" => 'bankDetailNameOne',
                "description" => 'Bank Name 1',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '4',
                "name" => 'bankDetailAddressOne',
                "description" => 'Bank Address 1',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '4',
                "name" => 'bankDetailTelephoneOne',
                "description" => 'Bank Telephone 1',
                "type" => 'number',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '4',
                "name" => 'bankDetailMobileNumberOfAccountManagerOne',
                "description" => 'Bank Mobile No. of Account Manager 1',
                "type" => 'number',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '4',
                "name" => 'bankDetailEmailAddressOfAccountManagerOne',
                "description" => 'Bank Email Address of Account Manager 1',
                "type" => 'email',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '4',
                "name" => 'bankDetailTypeOfAccountOne',
                "description" => 'Bank Type of Account 1',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],

            [
                "category" => '4',
                "name" => 'bankDetailNameTwo',
                "description" => 'Bank Name 2',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '4',
                "name" => 'bankDetailAddressTwo',
                "description" => 'Bank Address 2',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '4',
                "name" => 'bankDetailTelephoneTwo',
                "description" => 'Bank Telephone 2',
                "type" => 'number',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '4',
                "name" => 'bankDetailMobileNumberOfAccountManagerTwo',
                "description" => 'Bank Mobile No. of Account Manager 2',
                "type" => 'number',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '4',
                "name" => 'bankDetailEmailAddressOfAccountManagerTwo',
                "description" => 'Bank Email Address of Account Manager 2',
                "type" => 'email',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '4',
                "name" => 'bankDetailTypeOfAccountTwo',
                "description" => 'Bank Type of Account 2',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '4',
                "name" => 'custodianInformationName',
                "description" => 'Custodian Information Name',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '4',
                "name" => 'custodianInformationAddress',
                "description" => 'Custodian Information Address',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '4',
                "name" => 'custodianInformationTelephone',
                "description" => 'Custodian Information Telephone',
                "type" => 'number',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '4',
                "name" => 'custodianInformationMobileNumberOfContact',
                "description" => 'Custodian Information Mobile Number Of Contact',
                "type" => 'number',
                "required" => 1,
                "page" => '2',
            ],

            [
                "category" => '4',
                "name" => 'companyDisciplinary',
                "description" => 'The Company',
                "type" => 'select',
                "required" => 0,
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
                "parent_id" => isset($field['parent_id']) ? $field['parent_id'] : null,
            ]);
        }

        $fields = [
            [
                "category" => '4',
                "name" => 'companyDisciplinaryOne',
                "description" => 'Has the company or any of its affiliates , been denied registration or expelled from membership of any securities exchange, self-regulatory organisation (SRO) or associations?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '4')->where('name', 'companyDisciplinary')->first()->id,
            ],
            [
                "category" => '4',
                "name" => 'companyDisciplinaryTwo',
                "description" => 'Has your membership, or that of any affiliates, in any of the institutions/associations mentioned above at any time been revoked, suspended or withdrawn?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '4')->where('name', 'companyDisciplinary')->first()->id,
            ],
            [
                "category" => '4',
                "name" => 'companyDisciplinaryThree',
                "description" => 'Has your company, or any of its affiliates, ever been refused any Fidelity Bond?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '4')->where('name', 'companyDisciplinary')->first()->id,
            ],
            [
                "category" => '4',
                "name" => 'companyDisciplinaryFour',
                "description" => 'Has your company, or any of its affiliates, been subject to any winding up order/receivership arrangement? ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '4')->where('name', 'companyDisciplinary')->first()->id,
            ],
            [
                "category" => '4',
                "name" => 'companyDisciplinaryFive',
                "description" => 'Has your company, or any of its affiliates, been involved in litigation within ten (10) years preceding this application for the filing of any application for registration? ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '4')->where('name', 'companyDisciplinary')->first()->id,
            ],
            [
                "category" => '4',
                "name" => 'companyDisciplinarySix',
                "description" => 'Has your company, or any of its affiliates, been involved in litigation within ten (10) years preceding this application for the purchase or sale of securities? ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '4')->where('name', 'companyDisciplinary')->first()->id,
            ],
            [
                "category" => '4',
                "name" => 'companyDisciplinarySeven',
                "description" => 'Has your company, or any of its affiliates, been involved in litigation within ten (10) years preceding this application for any offence relating to the code of the business of Broker/Dealer, Issuing House, Investment Adviser, Bank or Insurance or such other related function?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '4')->where('name', 'companyDisciplinary')->first()->id,
            ],
            [
                "category" => '4',
                "name" => 'companyDisciplinaryEight',
                "description" => 'Has your company, or any of its affiliates, been involved in litigation within ten (10) years preceding this application for any criminal offence?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '4')->where('name', 'companyDisciplinary')->first()->id,
            ],
            [
                "category" => '4',
                "name" => 'companyDisciplinaryNine',
                "description" => 'Has your company, or any of its affiliates, been involved in litigation within ten (10) years preceding this application for any civil offence?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '4')->where('name', 'companyDisciplinary')->first()->id,
            ],

            [
                "category" => '4',
                "name" => 'mdceoDisciplinary',
                "description" => 'The MD/CEO',
                "type" => 'select',
                "required" => 0,
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
                "parent_id" => isset($field['parent_id']) ? $field['parent_id'] : null,
            ]);
        }

        $fields = [
            [
                "category" => '4',
                "name" => 'mdceoDisciplinaryOne',
                "description" => 'Ever been convicted of any criminal offence?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '4')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '4',
                "name" => 'mdceoDisciplinaryTwo',
                "description" => 'Ever been the subject of an adverse finding by, or settlement with, any government agency, court, securities exchange, SRO, tribunal or other regulatory authority?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '4')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '4',
                "name" => 'mdceoDisciplinaryThree',
                "description" => 'Ever been a Director, partner or otherwise concerned in the management of a business which has gone into insolvency, liquidation, administration or the similar proceedings within or outside of the Nigerian jurisdiction while connected with such organisation within one (1) year of that connection?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '4')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '4',
                "name" => 'mdceoDisciplinaryFour',
                "description" => 'Ever been declared bankrupt or entered into any compromise arrangement with creditors related to bankruptcy or insolvency?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '4')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '4',
                "name" => 'mdceoDisciplinaryFive',
                "description" => 'Ever been the subject of any disciplinary or criminal proceedings or been the subject of any investigation by any authority which may lead to such proceedings?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '4')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '4',
                "name" => 'mdceoDisciplinarySix',
                "description" => 'Ever been refused authorisation or licence to carry on a trade, business or profession or to be a member of a securities exchange?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '4')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '4',
                "name" => 'mdceoDisciplinarySeven',
                "description" => 'Ever had such authorisation, membership or licence (referred to above) revoked or terminated?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '4')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '4',
                "name" => 'mdceoDisciplinaryEight',
                "description" => 'Ever been disqualified from acting as a Director?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '4')->where('name', 'mdceoDisciplinary')->first()->id,
            ],

            [
                "category" => '4',
                "name" => 'treasureDisciplinary',
                "description" => 'The Treasure',
                "type" => 'select',
                "required" => 0,
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
                "parent_id" => isset($field['parent_id']) ? $field['parent_id'] : null,
            ]);
        }

        $fields = [
            [
                "category" => '4',
                "name" => 'treasureDisciplinaryOne',
                "description" => 'Ever been convicted of any criminal offence? ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '4')->where('name', 'treasureDisciplinary')->first()->id,
            ],
            [
                "category" => '4',
                "name" => 'treasureDisciplinaryTwo',
                "description" => 'Ever been the subject of an adverse finding by, or settlement with, any government agency, court, securities exchange, SRO, tribunal or other regulatory authority? ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '4')->where('name', 'treasureDisciplinary')->first()->id,
            ],
            [
                "category" => '4',
                "name" => 'treasureDisciplinaryThree',
                "description" => 'Ever been concerned in the management of a business which has gone into insolvency, liquidation, administration or the similar proceedings within or outside of the Nigerian jurisdiction while connected with such organisation within one (1) year of that connection?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '4')->where('name', 'treasureDisciplinary')->first()->id,
            ],
            [
                "category" => '4',
                "name" => 'treasureDisciplinaryFour',
                "description" => 'Ever been declared bankrupt or entered into any compromise arrangement with creditors related to bankruptcy or insolvency?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '4')->where('name', 'treasureDisciplinary')->first()->id,
            ],
            [
                "category" => '4',
                "name" => 'treasureDisciplinaryFive',
                "description" => 'Ever been the subject of any disciplinary or criminal proceedings or been the subject of any investigation by any authority which may lead to such proceedings?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '4')->where('name', 'treasureDisciplinary')->first()->id,
            ],

            [
                "category" => '4',
                "name" => 'chiefComplianceOfficerDisciplinary',
                "description" => 'The Chief Compliance Officer',
                "type" => 'select',
                "required" => 0,
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
                "parent_id" => isset($field['parent_id']) ? $field['parent_id'] : null,
            ]);
        }

        $fields = [
            [
                "category" => '4',
                "name" => 'chiefComplianceOfficerDisciplinaryOne',
                "description" => 'Ever been convicted of any criminal offence? ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '4')->where('name', 'chiefComplianceOfficerDisciplinary')->first()->id,
            ],
            [
                "category" => '4',
                "name" => 'chiefComplianceOfficerDisciplinaryTwo',
                "description" => 'Ever been the subject of an adverse finding by, or settlement with, any government agency, court, securities exchange, SRO, tribunal or other regulatory authority?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '4')->where('name', 'chiefComplianceOfficerDisciplinary')->first()->id,
            ],
            [
                "category" => '4',
                "name" => 'chiefComplianceOfficerDisciplinaryThree',
                "description" => 'Ever been concerned in the management of a business which has gone into insolvency, liquidation, administration or the equivalent proceedings within or outside of the Nigerian jurisdiction while connected with such organisation within one (1) year of that connection?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '4')->where('name', 'chiefComplianceOfficerDisciplinary')->first()->id,
            ],
            [
                "category" => '4',
                "name" => 'chiefComplianceOfficerDisciplinaryFour',
                "description" => 'Ever been declared bankrupt or entered into any compromise arrangement with creditors related to bankruptcy or insolvency?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '4')->where('name', 'chiefComplianceOfficerDisciplinary')->first()->id,
            ],
            [
                "category" => '4',
                "name" => 'chiefComplianceOfficerDisciplinaryFive',
                "description" => 'Ever been the subject of any disciplinary or criminal proceedings or been the subject of any investigation by any Authority which may lead to such proceedings?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '4')->where('name', 'chiefComplianceOfficerDisciplinary')->first()->id,
            ],

            [
                "category" => '4',
                "name" => 'CompanyOverview',
                "description" => 'Company Profile containing brief description of the following inter alias: History & Company Overview  & Details of Business Services & Profiles of Board of Directors & Profiles of Executive Management Staff',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '4',
                "name" => 'certificateOfIncorporation',
                "description" => 'Certificate of Incorporation',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '4',
                "name" => 'memorandumAndArticlesOfAssociation',
                "description" => 'Memorandum and Articles of Association',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '4',
                "name" => 'particularsOfDirectors',
                "description" => 'Particulars of Directors – CAC Form 7',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '4',
                "name" => 'particularsOfShareholders',
                "description" => 'Particulars of Shareholders – CAC Form 2 [for Private Companies (Ltd.) only]	',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '4',
                "name" => 'evidenceOfRegistration',
                "description" => 'Evidence of registration with the Securities and Exchange Commission (SEC) of Nigeria ',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '4',
                "name" => 'mostRecentYearAuditedFinancialStatements',
                "description" => 'Most recent one (1) year audited financial statements, not exceeding eighteen (18) months from end of the last financial year',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            // [
            //     "category" => '4',
            //     "name" => 'listOfAuthorisedRepresentatives',
            //     "description" => 'List of Authorised Representatives  (stating their designations)	',
            //     "type" => 'file',
            //     "required" => 1,
            //     "page" => '4',
            // ],

            [
                "category" => '4',
                "name" => 'detailedResumesOfSEC',
                "description" => 'Detailed resumes of SEC registered sponsored individuals',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '4',
                "name" => 'latestFidelityBond ',
                "description" => 'Latest Fidelity Bond ',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],

            [
                "category" => '4',
                "name" => 'evidenceOfCompliance',
                "description" => 'Evidence of compliance with the minimum paid-up capital as stipulated by SEC/Central Bank of Nigeria (CBN)	',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '4',
                "name" => 'evidenceOfMinimumShareholder',
                "description" => 'Evidence of minimum shareholders’ funds of N500,000,000.00 (Five Hundred Million Naira) only	',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '4',
                "name" => 'confirmationOfTechnicalKnowledge',
                "description" => 'Confirmation of technical knowledge of sponsored individuals in fixed income dealing operations',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            // [
            //     "category" => '4',
            //     "name" => 'evidenceOfPaymentOfApplicationFee',
            //     "description" => 'Evidence of Payment of Application Fee and Membership Dues ',
            //     "type" => 'file',
            //     "required" => 1,
            //     "page" => '4',
            // ],

            [
                "category" => '4',
                "name" => 'thomsonReutersContractForm',
                "description" => 'Completed Thomson Reuters Contract/Form',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '4',
                "name" => 'thomsonReutersCertificateOfIncorporation',
                "description" => 'Certificate of Incorporation',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '4',
                "name" => 'thomsonReutersMemorandumAndArticles',
                "description" => 'Memorandum and Articles of Association',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '4',
                "name" => 'thomsonReutersParticularsOfDirectors',
                "description" => 'Particulars of Directors – CAC Form 7	',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '4',
                "name" => 'thomsonReutersEvidenceOfRegulatoryStatus',
                "description" => 'Evidence of Regulatory Status from a Financial Regulator',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '4',
                "name" => 'thomsonReutersCertifiedCompanyOwnership',
                "description" => 'Certified Company Ownership Structure',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '4',
                "name" => 'thomsonReutersAuthorisedUserNames',
                "description" => 'Authorised user names',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '4',
                "name" => 'thomsonReutersContractFormCompanyInternetServiceProvider',
                "description" => 'Company Internet Protocol (IP) Addresses',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '4',
                "name" => 'thomsonReutersInternetServiceProvider',
                "description" => 'Internet Service Provider (ISP)',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],

            [
                "category" => '4',
                "name" => 'applicantDeclaration',
                "description" => 'Applicant Declaration',
                "type" => 'file',
                "required" => 1,
                "page" => '5',
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
                "parent_id" => isset($field['parent_id']) ? $field['parent_id'] : null,
            ]);
        }

        //Associate Members (Clients) CATEGORY

        $fields = [
            [
                "category" => '5',
                "name" => 'companyName',
                "description" => 'Company Name',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '5',
                "name" => 'rcNumber',
                "description" => 'RC Number',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '5',
                "name" => 'registeredOfficeAddress',
                "description" => 'Registered Office Address',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '5',
                "name" => 'dateOfIncorporation',
                "description" => 'Date of Incorporation',
                "type" => 'date',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '5',
                "name" => 'placeOfIncorporation',
                "description" => 'Place of Incorporation',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '5',
                "name" => 'companyTelephoneNumber',
                "description" => 'Company Telephone/Mobile Number',
                "type" => 'number',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '5',
                "name" => 'companyEmailAddress',
                "description" => 'Company Email Address',
                "type" => 'email',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '5',
                "name" => 'corporateWebsiteAddress',
                "description" => 'Corporate Website Address',
                "type" => 'url',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '5',
                "name" => 'natureOfBusiness',
                "description" => 'Nature of Business',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],

            [
                "category" => '5',
                "name" => 'authorisedShareCapitalCurrency',
                "description" => 'Authorised Share Capital Currency',
                "type" => 'select',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '5',
                "name" => 'authorisedShareCapital',
                "description" => 'Authorised Share Capital',
                "type" => 'number',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '5',
                "name" => 'paidUpShareCapitalCurrency',
                "description" => 'Paid-up Share Capital Currency',
                "type" => 'select',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '5',
                "name" => 'paidUpShareCapital',
                "description" => 'Paid-up Share Capital',
                "type" => 'number',
                "required" => 1,
                "page" => '1',
            ],

            [
                "category" => '5',
                "name" => 'applicationPrimaryContactName',
                "description" => 'Application Primary Contact Name',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '5',
                "name" => 'applicationPrimaryContactTelephone',
                "description" => 'Application Primary Contact Telephone',
                "type" => 'number',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '5',
                "name" => 'applicationPrimaryContactEmailAddress',
                "description" => 'Application Primary Contact Email Address',
                "type" => 'email',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '5',
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
                "parent_id" => isset($field['parent_id']) ? $field['parent_id'] : null,
            ]);
        }
        $product = ApplicationField::where('category', '5')->where('name', 'productOfInterest')->first();

        $fields = [
            [
                "category" => '5',
                "name" => 'MonthlyAverageValueOfTradesPerProductBonds',
                "description" => 'Monthly Average Value Of Trades Per Product Bonds (₦)',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '5',
                "name" => 'MonthlyAverageValueOfTradesPerProductTreasuryBills',
                "description" => 'Monthly Average Value Of Trades Per Product Treasury Bills (₦)',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '5',
                "name" => 'MonthlyAverageValueOfTradesPerProductCommercialPaper',
                "description" => 'Monthly Average Value Of Trades Per Product Commercial Paper (₦)',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '5',
                "name" => 'MonthlyAverageValueOfTradesPerProductForeignExchange',
                "description" => 'Monthly Average Value Of Trades Per Product Foreign Exchange',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '5',
                "name" => 'MonthlyAverageValueOfTradesPerProductDerivatives',
                "description" => 'Monthly Average Value Of Trades Per Product Derivatives',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '5',
                "name" => 'MonthlyAverageValueOfTradesPerProductOthers',
                "description" => 'Monthly Average Value Of Trades Per Product Others',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '5',
                "name" => 'AverageTradeSizePerTransactionBonds',
                "description" => 'Average Trade Size Per Transaction Bonds',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '5',
                "name" => 'AverageTradeSizePerTransactionTreasuryBills',
                "description" => 'Average Trade Size Per Transaction Treasury Bills (₦)',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '5',
                "name" => 'AverageTradeSizePerTransactionCommercialPaper',
                "description" => 'Average Trade Size Per Transaction Commercial Paper (₦)',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '5',
                "name" => 'AverageTradeSizePerTransactionForeignExchange',
                "description" => 'Average Trade Size Per Transaction Foreign Exchange',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '5',
                "name" => 'AverageTradeSizePerTransactionDerivatives',
                "description" => 'Average Trade Size Per Transaction Derivatives',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],
            [
                "category" => '5',
                "name" => 'AverageTradeSizePerTransactionOthers',
                "description" => 'Average Trade Size Per Transaction Others',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => $product->id, //'18',
            ],

            [
                "category" => '5',
                "name" => 'directionOfTrades',
                "description" => 'Direction of Trades',
                "type" => 'select',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '5',
                "name" => 'bankDetailNameOne',
                "description" => 'Bank Name 1',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '5',
                "name" => 'bankDetailAddressOne',
                "description" => 'Bank Address 1',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '5',
                "name" => 'bankDetailTelephoneOne',
                "description" => 'Bank Telephone 1',
                "type" => 'number',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '5',
                "name" => 'bankDetailMobileNumberOfAccountManagerOne',
                "description" => 'Bank Mobile No. of Account Manager 1',
                "type" => 'number',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '5',
                "name" => 'bankDetailEmailAddressOfAccountManagerOne',
                "description" => 'Bank Email Address of Account Manager 1',
                "type" => 'email',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '5',
                "name" => 'bankDetailTypeOfAccountOne',
                "description" => 'Bank Type of Account 1',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],

            [
                "category" => '5',
                "name" => 'bankDetailNameTwo',
                "description" => 'Bank Name 2',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '5',
                "name" => 'bankDetailAddressTwo',
                "description" => 'Bank Address 2',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '5',
                "name" => 'bankDetailTelephoneTwo',
                "description" => 'Bank Telephone 2',
                "type" => 'number',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '5',
                "name" => 'bankDetailMobileNumberOfAccountManagerTwo',
                "description" => 'Bank Mobile No. of Account Manager 2',
                "type" => 'number',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '5',
                "name" => 'bankDetailEmailAddressOfAccountManagerTwo',
                "description" => 'Bank Email Address of Account Manager 2',
                "type" => 'email',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '5',
                "name" => 'bankDetailTypeOfAccountTwo',
                "description" => 'Bank Type of Account 2',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '5',
                "name" => 'custodianInformationName',
                "description" => 'Custodian Information Name',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '5',
                "name" => 'custodianInformationAddress',
                "description" => 'Custodian Information Address',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '5',
                "name" => 'custodianInformationTelephone',
                "description" => 'Custodian Information Telephone',
                "type" => 'number',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '5',
                "name" => 'custodianInformationMobileNumberOfContact',
                "description" => 'Custodian Information Mobile Number Of Contact',
                "type" => 'number',
                "required" => 1,
                "page" => '2',
            ],

            [
                "category" => '5',
                "name" => 'companyDisciplinary',
                "description" => 'The Company',
                "type" => 'select',
                "required" => 0,
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
                "parent_id" => isset($field['parent_id']) ? $field['parent_id'] : null,
            ]);
        }

        $fields = [
            [
                "category" => '5',
                "name" => 'companyDisciplinaryOne',
                "description" => 'Has the company or any of its affiliates , been denied registration or expelled from membership of any securities exchange, self-regulatory organisation (SRO) or associations?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '5')->where('name', 'companyDisciplinary')->first()->id,
            ],
            [
                "category" => '5',
                "name" => 'companyDisciplinaryTwo',
                "description" => 'Has your membership, or that of any affiliates, in any of the institutions/associations mentioned above at any time been revoked, suspended or withdrawn?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '5')->where('name', 'companyDisciplinary')->first()->id,
            ],
            [
                "category" => '5',
                "name" => 'companyDisciplinaryThree',
                "description" => 'Has your company, or any of its affiliates, ever been refused any Fidelity Bond?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '5')->where('name', 'companyDisciplinary')->first()->id,
            ],
            [
                "category" => '5',
                "name" => 'companyDisciplinaryFour',
                "description" => 'Has your company, or any of its affiliates, been subject to any winding up order/receivership arrangement? ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '5')->where('name', 'companyDisciplinary')->first()->id,
            ],
            [
                "category" => '5',
                "name" => 'companyDisciplinaryFive',
                "description" => 'Has your company, or any of its affiliates, been involved in litigation within ten (10) years preceding this application for the filing of any application for registration? ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '5')->where('name', 'companyDisciplinary')->first()->id,
            ],
            [
                "category" => '5',
                "name" => 'companyDisciplinarySix',
                "description" => 'Has your company, or any of its affiliates, been involved in litigation within ten (10) years preceding this application for the purchase or sale of securities? ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '5')->where('name', 'companyDisciplinary')->first()->id,
            ],
            [
                "category" => '5',
                "name" => 'companyDisciplinarySeven',
                "description" => 'Has your company, or any of its affiliates, been involved in litigation within ten (10) years preceding this application for any offence relating to the code of the business of Broker/Dealer, Issuing House, Investment Adviser, Bank or Insurance or such other related function?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '5')->where('name', 'companyDisciplinary')->first()->id,
            ],
            [
                "category" => '5',
                "name" => 'companyDisciplinaryEight',
                "description" => 'Has your company, or any of its affiliates, been involved in litigation within ten (10) years preceding this application for any criminal offence?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '5')->where('name', 'companyDisciplinary')->first()->id,
            ],
            [
                "category" => '5',
                "name" => 'companyDisciplinaryNine',
                "description" => 'Has your company, or any of its affiliates, been involved in litigation within ten (10) years preceding this application for any civil offence?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '5')->where('name', 'companyDisciplinary')->first()->id,
            ],

            [
                "category" => '5',
                "name" => 'mdceoDisciplinary',
                "description" => 'The MD/CEO',
                "type" => 'select',
                "required" => 0,
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
                "parent_id" => isset($field['parent_id']) ? $field['parent_id'] : null,
            ]);
        }

        $fields = [
            [
                "category" => '5',
                "name" => 'mdceoDisciplinaryOne',
                "description" => 'Ever been convicted of any criminal offence?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '5')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '5',
                "name" => 'mdceoDisciplinaryTwo',
                "description" => 'Ever been the subject of an adverse finding by, or settlement with, any government agency, court, securities exchange, SRO, tribunal or other regulatory authority?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '5')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '5',
                "name" => 'mdceoDisciplinaryThree',
                "description" => 'Ever been a Director, partner or otherwise concerned in the management of a business which has gone into insolvency, liquidation, administration or the similar proceedings within or outside of the Nigerian jurisdiction while connected with such organisation within one (1) year of that connection?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '5')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '5',
                "name" => 'mdceoDisciplinaryFour',
                "description" => 'Ever been declared bankrupt or entered into any compromise arrangement with creditors related to bankruptcy or insolvency?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '5')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '5',
                "name" => 'mdceoDisciplinaryFive',
                "description" => 'Ever been the subject of any disciplinary or criminal proceedings or been the subject of any investigation by any authority which may lead to such proceedings?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '5')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '5',
                "name" => 'mdceoDisciplinarySix',
                "description" => 'Ever been refused authorisation or licence to carry on a trade, business or profession or to be a member of a securities exchange?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '5')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '5',
                "name" => 'mdceoDisciplinarySeven',
                "description" => 'Ever had such authorisation, membership or licence (referred to above) revoked or terminated?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '5')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '5',
                "name" => 'mdceoDisciplinaryEight',
                "description" => 'Ever been disqualified from acting as a Director?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '5')->where('name', 'mdceoDisciplinary')->first()->id,
            ],

            [
                "category" => '5',
                "name" => 'treasureDisciplinary',
                "description" => 'The Treasure',
                "type" => 'select',
                "required" => 0,
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
                "parent_id" => isset($field['parent_id']) ? $field['parent_id'] : null,
            ]);
        }

        $fields = [
            [
                "category" => '5',
                "name" => 'treasureDisciplinaryOne',
                "description" => 'Ever been convicted of any criminal offence? ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '5')->where('name', 'treasureDisciplinary')->first()->id,
            ],
            [
                "category" => '5',
                "name" => 'treasureDisciplinaryTwo',
                "description" => 'Ever been the subject of an adverse finding by, or settlement with, any government agency, court, securities exchange, SRO, tribunal or other regulatory authority? ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '5')->where('name', 'treasureDisciplinary')->first()->id,
            ],
            [
                "category" => '5',
                "name" => 'treasureDisciplinaryThree',
                "description" => 'Ever been concerned in the management of a business which has gone into insolvency, liquidation, administration or the similar proceedings within or outside of the Nigerian jurisdiction while connected with such organisation within one (1) year of that connection?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '5')->where('name', 'treasureDisciplinary')->first()->id,
            ],
            [
                "category" => '5',
                "name" => 'treasureDisciplinaryFour',
                "description" => 'Ever been declared bankrupt or entered into any compromise arrangement with creditors related to bankruptcy or insolvency?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '5')->where('name', 'treasureDisciplinary')->first()->id,
            ],
            [
                "category" => '5',
                "name" => 'treasureDisciplinaryFive',
                "description" => 'Ever been the subject of any disciplinary or criminal proceedings or been the subject of any investigation by any authority which may lead to such proceedings?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '5')->where('name', 'treasureDisciplinary')->first()->id,
            ],

            [
                "category" => '5',
                "name" => 'chiefComplianceOfficerDisciplinary',
                "description" => 'The Chief Compliance Officer',
                "type" => 'select',
                "required" => 0,
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
                "parent_id" => isset($field['parent_id']) ? $field['parent_id'] : null,
            ]);
        }

        $fields = [
            [
                "category" => '5',
                "name" => 'chiefComplianceOfficerDisciplinaryOne',
                "description" => 'Ever been convicted of any criminal offence? ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '5')->where('name', 'chiefComplianceOfficerDisciplinary')->first()->id,
            ],
            [
                "category" => '5',
                "name" => 'chiefComplianceOfficerDisciplinaryTwo',
                "description" => 'Ever been the subject of an adverse finding by, or settlement with, any government agency, court, securities exchange, SRO, tribunal or other regulatory authority?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '5')->where('name', 'chiefComplianceOfficerDisciplinary')->first()->id,
            ],
            [
                "category" => '5',
                "name" => 'chiefComplianceOfficerDisciplinaryThree',
                "description" => 'Ever been concerned in the management of a business which has gone into insolvency, liquidation, administration or the equivalent proceedings within or outside of the Nigerian jurisdiction while connected with such organisation within one (1) year of that connection?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '5')->where('name', 'chiefComplianceOfficerDisciplinary')->first()->id,
            ],
            [
                "category" => '5',
                "name" => 'chiefComplianceOfficerDisciplinaryFour',
                "description" => 'Ever been declared bankrupt or entered into any compromise arrangement with creditors related to bankruptcy or insolvency?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '5')->where('name', 'chiefComplianceOfficerDisciplinary')->first()->id,
            ],
            [
                "category" => '5',
                "name" => 'chiefComplianceOfficerDisciplinaryFive',
                "description" => 'Ever been the subject of any disciplinary or criminal proceedings or been the subject of any investigation by any Authority which may lead to such proceedings?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '5')->where('name', 'chiefComplianceOfficerDisciplinary')->first()->id,
            ],

            [
                "category" => '5',
                "name" => 'CompanyOverview',
                "description" => 'Company Profile containing brief description of the following inter alias: History & Company Overview  & Details of Business Services & Profiles of Board of Directors & Profiles of Executive Management Staff',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '5',
                "name" => 'certificateOfIncorporation',
                "description" => 'Certificate of Incorporation',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '5',
                "name" => 'memorandumAndArticlesOfAssociation',
                "description" => 'Memorandum and Articles of Association',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '5',
                "name" => 'particularsOfDirectors',
                "description" => 'Particulars of Directors – CAC Form 7',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '5',
                "name" => 'particularsOfShareholders',
                "description" => 'Particulars of Shareholders – CAC Form 2 [for Private Companies (Ltd.) only]	',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '5',
                "name" => 'mostRecentYearAuditedFinancialStatements',
                "description" => 'Most recent one (1) year audited financial statements, not exceeding eighteen (18) months from end of the last financial year',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            // [
            //     "category" => '5',
            //     "name" => 'listOfAuthorisedRepresentatives',
            //     "description" => 'List of Authorised Representatives  (stating their designations)	',
            //     "type" => 'file',
            //     "required" => 1,
            //     "page" => '4',
            // ],
            [
                "category" => '5',
                "name" => 'latestFidelityBond ',
                "description" => 'Latest Fidelity Bond ',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            // [
            //     "category" => '5',
            //     "name" => 'evidenceOfPaymentOfApplicationFee',
            //     "description" => 'Evidence of Payment of Application Fee and Membership Dues ',
            //     "type" => 'file',
            //     "required" => 1,
            //     "page" => '4',
            // ],

            [
                "category" => '5',
                "name" => 'stockbrokingLicense',
                "description" => 'Nigerian Exchange Group (NGX) Stockbroking Licence (for NGX-licenced stockbrokers only)',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '5',
                "name" => 'thomsonReutersContractForm',
                "description" => 'Completed Thomson Reuters Contract/Form',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '5',
                "name" => 'thomsonReutersCertificateOfIncorporation',
                "description" => 'Certificate of Incorporation',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '5',
                "name" => 'thomsonReutersMemorandumAndArticles',
                "description" => 'Memorandum and Articles of Association',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '5',
                "name" => 'thomsonReutersParticularsOfDirectors',
                "description" => 'Particulars of Directors – CAC Form 7	',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '5',
                "name" => 'thomsonReutersEvidenceOfRegulatoryStatus',
                "description" => 'Evidence of Regulatory Status from a Financial Regulator',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '5',
                "name" => 'thomsonReutersCertifiedCompanyOwnership',
                "description" => 'Certified Company Ownership Structure',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '5',
                "name" => 'thomsonReutersAuthorisedUserNames',
                "description" => 'Authorised user names',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '5',
                "name" => 'thomsonReutersContractFormCompanyInternetServiceProvider',
                "description" => 'Company Internet Protocol (IP) Addresses',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '5',
                "name" => 'thomsonReutersInternetServiceProvider',
                "description" => 'Internet Service Provider (ISP)',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],

            [
                "category" => '5',
                "name" => 'applicantDeclaration',
                "description" => 'Applicant Declaration',
                "type" => 'file',
                "required" => 1,
                "page" => '5',
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
                "parent_id" => isset($field['parent_id']) ? $field['parent_id'] : null,
            ]);
        }

        //Registration Member (Listings) CATEGORY

        $fields = [
            [
                "category" => '6',
                "name" => 'companyName',
                "description" => 'Company Name',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '6',
                "name" => 'rcNumber',
                "description" => 'RC Number',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '6',
                "name" => 'registeredOfficeAddress',
                "description" => 'Registered Office Address',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '6',
                "name" => 'dateOfIncorporation',
                "description" => 'Date of Incorporation',
                "type" => 'date',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '6',
                "name" => 'placeOfIncorporation',
                "description" => 'Place of Incorporation',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '6',
                "name" => 'companyTelephoneNumber',
                "description" => 'Company Telephone/Mobile Number',
                "type" => 'number',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '6',
                "name" => 'companyEmailAddress',
                "description" => 'Company Email Address',
                "type" => 'email',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '6',
                "name" => 'corporateWebsiteAddress',
                "description" => 'Corporate Website Address',
                "type" => 'url',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '6',
                "name" => 'natureOfBusiness',
                "description" => 'Nature of Business',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],

            [
                "category" => '6',
                "name" => 'authorisedShareCapitalCurrency',
                "description" => 'Authorised Share Capital Currency',
                "type" => 'select',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '6',
                "name" => 'authorisedShareCapital',
                "description" => 'Authorised Share Capital',
                "type" => 'number',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '6',
                "name" => 'paidUpShareCapitalCurrency',
                "description" => 'Paid-up Share Capital Currency',
                "type" => 'select',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '6',
                "name" => 'paidUpShareCapital',
                "description" => 'Paid-up Share Capital',
                "type" => 'number',
                "required" => 1,
                "page" => '1',
            ],

            [
                "category" => '6',
                "name" => 'applicationPrimaryContactName',
                "description" => 'Application Primary Contact Name',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '6',
                "name" => 'applicationPrimaryContactTelephone',
                "description" => 'Application Primary Contact Telephone',
                "type" => 'number',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => '6',
                "name" => 'applicationPrimaryContactEmailAddress',
                "description" => 'Application Primary Contact Email Address',
                "type" => 'email',
                "required" => 1,
                "page" => '1',
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
                "parent_id" => isset($field['parent_id']) ? $field['parent_id'] : null,
            ]);
        }

        $fields = [

            [
                "category" => '6',
                "name" => 'bankDetailNameOne',
                "description" => 'Bank Name 1',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '6',
                "name" => 'bankDetailAddressOne',
                "description" => 'Bank Address 1',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '6',
                "name" => 'bankDetailTelephoneOne',
                "description" => 'Bank Telephone 1',
                "type" => 'number',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '6',
                "name" => 'bankDetailMobileNumberOfAccountManagerOne',
                "description" => 'Bank Mobile No. of Account Manager 1',
                "type" => 'number',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '6',
                "name" => 'bankDetailEmailAddressOfAccountManagerOne',
                "description" => 'Bank Email Address of Account Manager 1',
                "type" => 'email',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '6',
                "name" => 'bankDetailTypeOfAccountOne',
                "description" => 'Bank Type of Account 1',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],

            [
                "category" => '6',
                "name" => 'bankDetailNameTwo',
                "description" => 'Bank Name 2',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '6',
                "name" => 'bankDetailAddressTwo',
                "description" => 'Bank Address 2',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '6',
                "name" => 'bankDetailTelephoneTwo',
                "description" => 'Bank Telephone 2',
                "type" => 'number',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '6',
                "name" => 'bankDetailMobileNumberOfAccountManagerTwo',
                "description" => 'Bank Mobile No. of Account Manager 2',
                "type" => 'number',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '6',
                "name" => 'bankDetailEmailAddressOfAccountManagerTwo',
                "description" => 'Bank Email Address of Account Manager 2',
                "type" => 'email',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '6',
                "name" => 'bankDetailTypeOfAccountTwo',
                "description" => 'Bank Type of Account 2',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '6',
                "name" => 'custodianInformationName',
                "description" => 'Custodian Information Name',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '6',
                "name" => 'custodianInformationAddress',
                "description" => 'Custodian Information Address',
                "type" => 'text',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '6',
                "name" => 'custodianInformationTelephone',
                "description" => 'Custodian Information Telephone',
                "type" => 'number',
                "required" => 1,
                "page" => '2',
            ],
            [
                "category" => '6',
                "name" => 'custodianInformationMobileNumberOfContact',
                "description" => 'Custodian Information Mobile Number Of Contact',
                "type" => 'number',
                "required" => 1,
                "page" => '2',
            ],

            [
                "category" => '6',
                "name" => 'companyDisciplinary',
                "description" => 'The Company',
                "type" => 'select',
                "required" => 0,
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
                "parent_id" => isset($field['parent_id']) ? $field['parent_id'] : null,
            ]);
        }

        $fields = [
            [
                "category" => '6',
                "name" => 'companyDisciplinaryOne',
                "description" => 'Has the company or any of its affiliates , been denied registration or expelled from membership of any securities exchange, self-regulatory organisation (SRO) or associations?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '6')->where('name', 'companyDisciplinary')->first()->id,
            ],
            [
                "category" => '6',
                "name" => 'companyDisciplinaryTwo',
                "description" => 'Has your membership, or that of any affiliates, in any of the institutions/associations mentioned above at any time been revoked, suspended or withdrawn?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '6')->where('name', 'companyDisciplinary')->first()->id,
            ],
            [
                "category" => '6',
                "name" => 'companyDisciplinaryThree',
                "description" => 'Has your company, or any of its affiliates, ever been refused any Fidelity Bond?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '6')->where('name', 'companyDisciplinary')->first()->id,
            ],
            [
                "category" => '6',
                "name" => 'companyDisciplinaryFour',
                "description" => 'Has your company, or any of its affiliates, been subject to any winding up order/receivership arrangement? ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '6')->where('name', 'companyDisciplinary')->first()->id,
            ],
            [
                "category" => '6',
                "name" => 'mdceoDisciplinary',
                "description" => 'The MD/CEO',
                "type" => 'select',
                "required" => 0,
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
                "parent_id" => isset($field['parent_id']) ? $field['parent_id'] : null,
            ]);
        }

        $fields = [
            [
                "category" => '6',
                "name" => 'mdceoDisciplinaryOne',
                "description" => 'Ever been convicted of any criminal offence?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '6')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '6',
                "name" => 'mdceoDisciplinaryTwo',
                "description" => 'Ever been the subject of an adverse finding by, or settlement with, any government agency, court, securities exchange, SRO, tribunal or other regulatory authority?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '6')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '6',
                "name" => 'mdceoDisciplinaryThree',
                "description" => 'Ever been a Director, partner or otherwise concerned in the management of a business which has gone into insolvency, liquidation, administration or the similar proceedings within or outside of the Nigerian jurisdiction while connected with such organisation within one (1) year of that connection?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '6')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '6',
                "name" => 'mdceoDisciplinaryFour',
                "description" => 'Ever been declared bankrupt or entered into any compromise arrangement with creditors related to bankruptcy or insolvency?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '6')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '6',
                "name" => 'mdceoDisciplinaryFive',
                "description" => 'Ever been the subject of any disciplinary or criminal proceedings or been the subject of any investigation by any authority which may lead to such proceedings?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '6')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '6',
                "name" => 'mdceoDisciplinarySix',
                "description" => 'Ever been refused authorisation or licence to carry on a trade, business or profession or to be a member of a securities exchange?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '6')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '6',
                "name" => 'mdceoDisciplinarySeven',
                "description" => 'Ever had such authorisation, membership or licence (referred to above) revoked or terminated?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '6')->where('name', 'mdceoDisciplinary')->first()->id,
            ],
            [
                "category" => '6',
                "name" => 'mdceoDisciplinaryEight',
                "description" => 'Ever been disqualified from acting as a Director?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '6')->where('name', 'mdceoDisciplinary')->first()->id,
            ],

            [
                "category" => '6',
                "name" => 'treasureDisciplinary',
                "description" => 'The TREASURER/CHIEF FINANCIAL OFFICER',
                "type" => 'select',
                "required" => 0,
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
                "parent_id" => isset($field['parent_id']) ? $field['parent_id'] : null,
            ]);
        }

        $fields = [
            [
                "category" => '6',
                "name" => 'treasureDisciplinaryOne',
                "description" => 'Ever been convicted of any criminal offence? ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '6')->where('name', 'treasureDisciplinary')->first()->id,
            ],
            [
                "category" => '6',
                "name" => 'treasureDisciplinaryTwo',
                "description" => 'Ever been the subject of an adverse finding by, or settlement with, any government agency, court, securities exchange, SRO, tribunal or other regulatory authority? ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '6')->where('name', 'treasureDisciplinary')->first()->id,
            ],
            [
                "category" => '6',
                "name" => 'treasureDisciplinaryThree',
                "description" => 'Ever been concerned in the management of a business which has gone into insolvency, liquidation, administration or the similar proceedings within or outside of the Nigerian jurisdiction while connected with such organisation within one (1) year of that connection?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '6')->where('name', 'treasureDisciplinary')->first()->id,
            ],
            [
                "category" => '6',
                "name" => 'treasureDisciplinaryFour',
                "description" => 'Ever been declared bankrupt or entered into any compromise arrangement with creditors related to bankruptcy or insolvency?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '6')->where('name', 'treasureDisciplinary')->first()->id,
            ],
            [
                "category" => '6',
                "name" => 'treasureDisciplinaryFive',
                "description" => 'Ever been the subject of any disciplinary or criminal proceedings or been the subject of any investigation by any authority which may lead to such proceedings?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '6')->where('name', 'treasureDisciplinary')->first()->id,
            ],

            [
                "category" => '6',
                "name" => 'chiefComplianceOfficerDisciplinary',
                "description" => 'The Chief Compliance Officer',
                "type" => 'select',
                "required" => 0,
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
                "parent_id" => isset($field['parent_id']) ? $field['parent_id'] : null,
            ]);
        }

        $fields = [
            [
                "category" => '6',
                "name" => 'chiefComplianceOfficerDisciplinaryOne',
                "description" => 'Ever been convicted of any criminal offence? ',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '6')->where('name', 'chiefComplianceOfficerDisciplinary')->first()->id,
            ],
            [
                "category" => '6',
                "name" => 'chiefComplianceOfficerDisciplinaryTwo',
                "description" => 'Ever been the subject of an adverse finding by, or settlement with, any government agency, court, securities exchange, SRO, tribunal or other regulatory authority?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '6')->where('name', 'chiefComplianceOfficerDisciplinary')->first()->id,
            ],
            [
                "category" => '6',
                "name" => 'chiefComplianceOfficerDisciplinaryThree',
                "description" => 'Ever been concerned in the management of a business which has gone into insolvency, liquidation, administration or the equivalent proceedings within or outside of the Nigerian jurisdiction while connected with such organisation within one (1) year of that connection?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '6')->where('name', 'chiefComplianceOfficerDisciplinary')->first()->id,
            ],
            [
                "category" => '6',
                "name" => 'chiefComplianceOfficerDisciplinaryFour',
                "description" => 'Ever been declared bankrupt or entered into any compromise arrangement with creditors related to bankruptcy or insolvency?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '6')->where('name', 'chiefComplianceOfficerDisciplinary')->first()->id,
            ],
            [
                "category" => '6',
                "name" => 'chiefComplianceOfficerDisciplinaryFive',
                "description" => 'Ever been the subject of any disciplinary or criminal proceedings or been the subject of any investigation by any Authority which may lead to such proceedings?',
                "type" => 'select',
                "required" => 1,
                "page" => '3',
                "parent_id" => ApplicationField::where('category', '6')->where('name', 'chiefComplianceOfficerDisciplinary')->first()->id,
            ],

            [
                "category" => '6',
                "name" => 'CompanyOverview',
                "description" => 'Company Profile containing brief description of the following inter alias: History & Company Overview  & Details of Business Services & Profiles of Board of Directors & Profiles of Executive Management Staff',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '6',
                "name" => 'certificateOfIncorporation',
                "description" => 'Certificate of Incorporation',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '6',
                "name" => 'memorandumAndArticlesOfAssociation',
                "description" => 'Memorandum and Articles of Association',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '6',
                "name" => 'particularsOfDirectors',
                "description" => 'Particulars of Directors – CAC Form 7',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '6',
                "name" => 'particularsOfShareholders',
                "description" => 'Particulars of Shareholders – CAC Form 2 [for Private Companies (Ltd.) only]	',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '6',
                "name" => 'mostRecentYearAuditedFinancialStatements',
                "description" => 'Most recent one (1) year audited financial statements, not exceeding eighteen (18) months from end of the last financial year',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            // [
            //     "category" => '6',
            //     "name" => 'listOfAuthorisedRepresentatives',
            //     "description" => 'List of Authorised Representatives  (stating their designations)	',
            //     "type" => 'file',
            //     "required" => 1,
            //     "page" => '4',
            // ],
            [
                "category" => '6',
                "name" => 'latestFidelityBond ',
                "description" => 'Latest Fidelity Bond ',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            // [
            //     "category" => '6',
            //     "name" => 'evidenceOfPaymentOfApplicationFee',
            //     "description" => 'Evidence of Payment of Application Fee and Membership Dues ',
            //     "type" => 'file',
            //     "required" => 1,
            //     "page" => '4',
            // ],

            [
                "category" => '6',
                "name" => 'stockbrokingLicense',
                "description" => 'Nigerian Exchange Group (NGX) Stockbroking Licence (for NGX-licenced stockbrokers only)',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '6',
                "name" => 'thomsonReutersContractForm',
                "description" => 'Completed Thomson Reuters Contract/Form',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '6',
                "name" => 'thomsonReutersCertificateOfIncorporation',
                "description" => 'Certificate of Incorporation',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '6',
                "name" => 'thomsonReutersMemorandumAndArticles',
                "description" => 'Memorandum and Articles of Association',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '6',
                "name" => 'thomsonReutersParticularsOfDirectors',
                "description" => 'Particulars of Directors – CAC Form 7	',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '6',
                "name" => 'thomsonReutersEvidenceOfRegulatoryStatus',
                "description" => 'Evidence of Regulatory Status from a Financial Regulator',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '6',
                "name" => 'thomsonReutersCertifiedCompanyOwnership',
                "description" => 'Certified Company Ownership Structure',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '6',
                "name" => 'thomsonReutersAuthorisedUserNames',
                "description" => 'Authorised user names',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '6',
                "name" => 'thomsonReutersContractFormCompanyInternetServiceProvider',
                "description" => 'Company Internet Protocol (IP) Addresses',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],
            [
                "category" => '6',
                "name" => 'thomsonReutersInternetServiceProvider',
                "description" => 'Internet Service Provider (ISP)',
                "type" => 'file',
                "required" => 1,
                "page" => '4',
            ],

            [
                "category" => '6',
                "name" => 'applicantDeclaration',
                "description" => 'Applicant Declaration',
                "type" => 'file',
                "required" => 1,
                "page" => '5',
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
                "parent_id" => isset($field['parent_id']) ? $field['parent_id'] : null,
            ]);
        }

    }
}
