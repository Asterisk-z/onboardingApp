<?php

namespace Database\Seeders;

use App\Models\ApplicationExtra;
use Illuminate\Database\Seeder;

class ApplicationExtraSeeder extends Seeder
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
                "name" => 'applicantDeclaration',
                "description" => '',
                "file" => "applications/dmbDeclaration.pdf",
            ],
            [
                "category" => '1',
                "name" => 'invoice',
                "description" => '',
                "file" => "dmb/invoice",
            ],
            [
                "category" => '2',
                "name" => 'applicantDeclaration',
                "description" => '',
                "file" => "applications/dmsDeclaration.pdf",
            ],
            [
                "category" => '2',
                "name" => 'invoice',
                "description" => '',
                "file" => "dms/invoice",
            ],
            [
                "category" => '3',
                "name" => 'applicantDeclaration',
                "description" => '',
                "file" => "applications/ambDeclaration.pdf",
            ],
            [
                "category" => '3',
                "name" => 'invoice',
                "description" => '',
                "file" => "dms/invoice",
            ],
            [
                "category" => '4',
                "name" => 'invoice',
                "description" => '',
                "file" => "dms/invoice",
            ],
            [
                "category" => '4',
                "name" => 'applicantDeclaration',
                "description" => '',
                "file" => "applications/amiDeclaration.pdf",
            ],
            [
                "category" => '5',
                "name" => 'invoice',
                "description" => '',
                "file" => "dms/invoice",
            ],
            [
                "category" => '5',
                "name" => 'applicantDeclaration',
                "description" => '',
                "file" => "applications/amcDeclaration.pdf",
            ],
            [
                "category" => '6',
                "name" => 'invoice',
                "description" => '',
                "file" => "dms/invoice",
            ],
            [
                "category" => '6',
                "name" => 'applicantDeclaration',
                "description" => '',
                "file" => "applications/rmlDeclaration.pdf",
            ],
            [
                "category" => '7',
                "name" => 'invoice',
                "description" => '',
                "file" => "dms/invoice",
            ],
            [
                "category" => '7',
                "name" => 'applicantDeclaration',
                "description" => '',
                "file" => "applications/rmqDeclaration.pdf",
            ],
            [
                "category" => '8',
                "name" => 'invoice',
                "description" => '',
                "file" => "dms/invoice",
            ],
            [
                "category" => '8',
                "name" => 'applicantDeclaration',
                "description" => '',
                "file" => "applications/lnqDeclaration.pdf",
            ],
            [
                "category" => '9',
                "name" => 'invoice',
                "description" => '',
                "file" => "dms/invoice",
            ],
            [
                "category" => '9',
                "name" => 'applicantDeclaration',
                "description" => '',
                "file" => "applications/afsDeclaration.pdf",
            ],
            [
                "category" => '10',
                "name" => 'invoice',
                "description" => '',
                "file" => "dms/invoice",
            ],
            [
                "category" => '10',
                "name" => 'applicantDeclaration',
                "description" => '',
                "file" => "applications/afcDeclaration.pdf",
            ],
            [
                "category" => '11',
                "name" => 'invoice',
                "description" => '',
                "file" => "dms/invoice",
            ],
            [
                "category" => '11',
                "name" => 'applicantDeclaration',
                "description" => '',
                "file" => "applications/aftDeclaration.pdf",
            ],
            [
                "category" => '12',
                "name" => 'invoice',
                "description" => '',
                "file" => "dms/invoice",
            ],
            [
                "category" => '12',
                "name" => 'applicantDeclaration',
                "description" => '',
                "file" => "applications/afiDeclaration.pdf",
            ],
            [
                "category" => '13',
                "name" => 'invoice',
                "description" => '',
                "file" => "dms/invoice",
            ],
            [
                "category" => '13',
                "name" => 'applicantDeclaration',
                "description" => '',
                "file" => "applications/afrDeclaration.pdf",
            ],
            [
                "category" => '14',
                "name" => 'invoice',
                "description" => '',
                "file" => "dms/invoice",
            ],
            [
                "category" => '14',
                "name" => 'applicantDeclaration',
                "description" => '',
                "file" => "applications/aecDeclaration.pdf",
            ],
            [
                "category" => '15',
                "name" => 'invoice',
                "description" => '',
                "file" => "dms/invoice",
            ],
            [
                "category" => '15',
                "name" => 'applicantDeclaration',
                "description" => '',
                "file" => "applications/dmfDeclaration.pdf",
            ],
        ];

        foreach ($fields as $field) {
            if (ApplicationExtra::where('category_id', $field['category'])->where('name', $field['name'])->exists()) {
                continue;
            }

            ApplicationExtra::create([
                "category_id" => $field['category'],
                "name" => $field['name'],
                "description" => $field['description'],
                "file" => $field['file'],
            ]);
        }

    }
}
