<?php

namespace Database\Seeders;

use App\Models\SanctionType;
use Illuminate\Database\Seeder;

class SanctionTypeSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            ["name" => "Regulatory Sanction"],
            ["name" => "Institution Sanction"],
        ];

        foreach ($types as $type) {
            if (SanctionType::where('name', $type['name'])->exists()) {
                continue;
            }

            SanctionType::create($type);
        }

    }
}
