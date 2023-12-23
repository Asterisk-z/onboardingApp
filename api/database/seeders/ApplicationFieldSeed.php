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
        ApplicationField::query()->truncate();
        $fields = [
            [
                "category" => 'dmb',
                "name" => 'companyName',
                "description" => 'company Name',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => 'dmb',
                "name" => 'rcNumber',
                "description" => 'RC Number',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => 'dmb',
                "name" => 'registeredOfficeAddress',
                "description" => 'Registered Office Address',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => 'dmb',
                "name" => 'dateOfIncorporation',
                "description" => 'Date of Incorporation',
                "type" => 'date',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => 'dmb',
                "name" => 'placeOfIncorporation',
                "description" => 'Place of Incorporation',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => 'dmb',
                "name" => 'companyTelephoneNumber',
                "description" => 'Company Telephone/Mobile Number',
                "type" => 'number',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => 'dmb',
                "name" => 'companyEmailAddress',
                "description" => 'Company Email Address',
                "type" => 'email',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => 'dmb',
                "name" => 'corporateWebsiteAddress',
                "description" => 'Corporate Website Address',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => 'dmb',
                "name" => 'natureOfBusiness',
                "description" => 'Nature of Business',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],

            // [
            //     "category" => 'dmb',
            //     "name" => 'companyName',
            //     "description" => 'Secondary Company Email Address',
            //     "type" => 'email',
            //     "required" => 1,
            //     "page" => '1',
            // ],
            // [
            //     "category" => 'dmb',
            //     "name" => 'companyName',
            //     "description" => 'Secondary Telephone/Mobile Number',
            //     "type" => 'number',
            //     "required" => 1,
            //     "page" => '1',
            // ],
            [
                "category" => 'dmb',
                "name" => 'authorisedShareCapitalCurrency',
                "description" => 'Authorised Share Capital Currency',
                "type" => 'select',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => 'dmb',
                "name" => 'authorisedShareCapital',
                "description" => 'Authorised Share Capital',
                "type" => 'number',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => 'dmb',
                "name" => 'paidUpShareCapitalCurrency',
                "description" => 'Paid-up Share Capital Currency',
                "type" => 'select',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => 'dmb',
                "name" => 'paidUpShareCapital',
                "description" => 'Paid-up Share Capital',
                "type" => 'number',
                "required" => 1,
                "page" => '1',
            ],

            [
                "category" => 'dmb',
                "name" => 'applicationPrimaryContactName',
                "description" => 'Application Primary Contact Name',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => 'dmb',
                "name" => 'applicationPrimaryContactTelephone',
                "description" => 'Application Primary Contact Telephone',
                "type" => 'number',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => 'dmb',
                "name" => 'applicationPrimaryContactEmailAddress',
                "description" => 'Application Primary Contact Email Address',
                "type" => 'email',
                "required" => 1,
                "page" => '1',
            ],

            [
                "category" => 'dmb',
                "name" => 'companyName',
                "description" => 'Company Name',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => 'dmb',
                "name" => 'companyName',
                "description" => 'Company Name',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => 'dmb',
                "name" => 'companyName',
                "description" => 'Company Name',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => 'dmb',
                "name" => 'companyName',
                "description" => 'Company Name',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
        ];
    }
}
