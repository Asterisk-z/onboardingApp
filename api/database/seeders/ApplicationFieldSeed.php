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
                "description" => 'RC Number',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => 'dmb',
                "name" => 'companyName',
                "description" => 'Registered Office Address',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => 'dmb',
                "name" => 'companyName',
                "description" => 'Company Email Address',
                "type" => 'email',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => 'dmb',
                "name" => 'companyName',
                "description" => 'Secondary Company Email Address',
                "type" => 'email',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => 'dmb',
                "name" => 'companyName',
                "description" => 'Company Telephone/Mobile Number',
                "type" => 'number',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => 'dmb',
                "name" => 'companyName',
                "description" => 'Secondary Telephone/Mobile Number',
                "type" => 'number',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => 'dmb',
                "name" => 'companyName',
                "description" => 'Date of Incorporation',
                "type" => 'date',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => 'dmb',
                "name" => 'companyName',
                "description" => 'Place of Incorporation',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => 'dmb',
                "name" => 'companyName',
                "description" => 'Corporate Website Address',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => 'dmb',
                "name" => 'companyName',
                "description" => 'Nature of Business',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => 'dmb',
                "name" => 'companyName',
                "description" => 'Currency',
                "type" => 'select',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => 'dmb',
                "name" => 'companyName',
                "description" => 'Authorised Share Capital',
                "type" => 'number',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => 'dmb',
                "name" => 'companyName',
                "description" => 'Paid-up Share Capital',
                "type" => 'number',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => 'dmb',
                "name" => 'companyName',
                "description" => 'Application Primary Contact Name',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => 'dmb',
                "name" => 'companyName',
                "description" => 'Application Primary Contact Telephone',
                "type" => 'text',
                "required" => 1,
                "page" => '1',
            ],
            [
                "category" => 'dmb',
                "name" => 'contactEmailAddress',
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
