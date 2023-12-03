<?php

namespace Database\Seeders;

use App\Models\ComplaintType;
use Illuminate\Database\Seeder;

class ComplaintTypes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            ["name" => "Regstration Problems"],
            ["name" => "Fraudulent Activity"],
            ["name" => "Inacurrate Remittance"],
            ["name" => "Indiscipline"]
        ];

        foreach($types as $type){
            if(ComplaintType::where('name', $type['name'])->exists()){
                continue;
            }

            ComplaintType::create($type);
        }
    }
}
