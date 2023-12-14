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
            ]
        ];

        foreach($configs as $config){
            if(SystemSetting::where('name', $config['name'])->exists()){
                continue;
            }

            SystemSetting::create($config);
        }
    }
}
