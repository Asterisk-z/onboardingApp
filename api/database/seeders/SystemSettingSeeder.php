<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $configs = [
            [
                "name" => "mandate_form",
                "value" => config('app.url')."/mandate_form.pdf"
            ],
            [
                "name" => "tax",
                "value" => 7.5
            ],
            [
                "name" => "email",
                "value" => "info@fmdqgroup.com"
            ],
            [
                "name" => "website",
                "value" => "www.fmdqgroup.com"
            ],
            [
                "name" => "address",
                "value" => "Exchange Place, 35, Idowu Taylor Street, Victoria Island, Lagos"
            ],
            [
                "name" => "contact_name",
                "value" => "Uju Iwuamadi"
            ],
            [
                "name" => "contact_phone",
                "value" => "+234 -1-2778771"
            ],
            [
                "name" => "tin",
                "value" => "11426626 - 0001"
            ]
        ];

        foreach($configs as $config){
            SystemSetting::updateOrCreate(['name' => $config['name']], [
                "value" => $config['value']
            ]);
        }
    }
}
