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
                "file" => config('app.url') . "/applications/dmbDeclaration.pdf",
            ],
            [
                "category" => '1',
                "name" => 'invoice',
                "description" => '',
                "file" => config('app.url') . "/dmb/invoice",
            ],
            [
                "category" => '2',
                "name" => 'applicantDeclaration',
                "description" => '',
                "file" => config('app.url') . "/applications/dmbDeclaration.pdf",
            ],
            [
                "category" => '2',
                "name" => 'invoice',
                "description" => '',
                "file" => config('app.url') . "/dms/invoice",
            ],
            [
                "category" => '3',
                "name" => 'applicantDeclaration',
                "description" => '',
                "file" => config('app.url') . "/applications/dmbDeclaration.pdf",
            ],
            [
                "category" => '3',
                "name" => 'invoice',
                "description" => '',
                "file" => config('app.url') . "/dms/invoice",
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
