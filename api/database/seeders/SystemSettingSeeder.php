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
            ]
        ];

        foreach($configs as $config){
            SystemSetting::updateOrCreate(['name' => $config['name']], [
                "value" => $config['value']
            ]);
        }
    }
}
