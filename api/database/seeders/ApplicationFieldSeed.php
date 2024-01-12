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
        // ApplicationField::query()->truncate();
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

       $fields = [
            [
                "category" => '1',
                "name" => 'MonthlyAverageValueOfTradesPerProductBonds',
                "description" => 'Monthly Average Value Of Trades Per Product Bonds',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => ApplicationField::where('category', 'dmb')->where('name', 'productOfInterest')->first()->id,//'18',
            ],
            [
                "category" => '1',
                "name" => 'MonthlyAverageValueOfTradesPerProductTreasuryBills',
                "description" => 'Monthly Average Value Of Trades Per Product Treasury Bills',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => ApplicationField::where('category', 'dmb')->where('name', 'productOfInterest')->first()->id,//'18',
            ],
            [
                "category" => '1',
                "name" => 'MonthlyAverageValueOfTradesPerProductCommercialPaper',
                "description" => 'Monthly Average Value Of Trades Per Product Commercial Paper',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => ApplicationField::where('category', 'dmb')->where('name', 'productOfInterest')->first()->id,//'18',
            ],
            [
                "category" => '1',
                "name" => 'MonthlyAverageValueOfTradesPerProductMoneyMarket',
                "description" => 'Monthly Average Value Of Trades Per Product Money Market',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => ApplicationField::where('category', 'dmb')->where('name', 'productOfInterest')->first()->id,//'18',
            ],
            [
                "category" => '1',
                "name" => 'MonthlyAverageValueOfTradesPerProductForeignExchange',
                "description" => 'Monthly Average Value Of Trades Per Product Foreign Exchange',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => ApplicationField::where('category', 'dmb')->where('name', 'productOfInterest')->first()->id,//'18',
            ],
            [
                "category" => '1',
                "name" => 'MonthlyAverageValueOfTradesPerProductDerivatives',
                "description" => 'Monthly Average Value Of Trades Per Product Derivatives',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => ApplicationField::where('category', 'dmb')->where('name', 'productOfInterest')->first()->id,//'18',
            ],
            [
                "category" => '1',
                "name" => 'MonthlyAverageValueOfTradesPerProductOthers',
                "description" => 'Monthly Average Value Of Trades Per Product Others',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => ApplicationField::where('category', 'dmb')->where('name', 'productOfInterest')->first()->id,//'18',
            ],
            [
                "category" => '1',
                "name" => 'AverageTradeSizePerTransactionBonds',
                "description" => 'Average Trade Size Per Transaction Bonds',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => ApplicationField::where('category', 'dmb')->where('name', 'productOfInterest')->first()->id,//'18',
            ],
            [
                "category" => '1',
                "name" => 'AverageTradeSizePerTransactionTreasuryBills',
                "description" => 'Average Trade Size Per Transaction Treasury Bills',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => ApplicationField::where('category', 'dmb')->where('name', 'productOfInterest')->first()->id,//'18',
            ],
            [
                "category" => '1',
                "name" => 'AverageTradeSizePerTransactionCommercialPaper',
                "description" => 'Average Trade Size Per Transaction Commercial Paper',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => ApplicationField::where('category', 'dmb')->where('name', 'productOfInterest')->first()->id,//'18',
            ],
            [
                "category" => '1',
                "name" => 'AverageTradeSizePerTransactionMoneyMarket',
                "description" => 'Average Trade Size Per Transaction Money Market',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => ApplicationField::where('category', 'dmb')->where('name', 'productOfInterest')->first()->id,//'18',
            ],
            [
                "category" => '1',
                "name" => 'AverageTradeSizePerTransactionForeignExchange',
                "description" => 'Average Trade Size Per Transaction Foreign Exchange',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => ApplicationField::where('category', 'dmb')->where('name', 'productOfInterest')->first()->id,//'18',
            ],
            [
                "category" => '1',
                "name" => 'AverageTradeSizePerTransactionDerivatives',
                "description" => 'Average Trade Size Per Transaction Derivatives',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => ApplicationField::where('category', 'dmb')->where('name', 'productOfInterest')->first()->id,//'18',
            ],
            [
                "category" => '1',
                "name" => 'AverageTradeSizePerTransactionOthers',
                "description" => 'Average Trade Size Per Transaction Others',
                "type" => 'number',
                "required" => 0,
                "page" => '2',
                "parent_id" => ApplicationField::where('category', 'dmb')->where('name', 'productOfInterest')->first()->id,//'18',
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
            // [
            //     "category" => '1',
            //     "name" => 'companyName',
            //     "description" => 'Company Name',
            //     "type" => 'text',
            //     "required" => 1,
            //     "page" => '1',
            // ],
            // [
            //     "category" => '1',
            //     "name" => 'companyName',
            //     "description" => 'Company Name',
            //     "type" => 'text',
            //     "required" => 1,
            //     "page" => '1',
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
