<?php

namespace Database\Seeders;

use App\Models\DohSignature;
use Illuminate\Database\Seeder;

class DohSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $dataSet = [
            [
                'user_id' => 2,
                'name' => 'Ebenezer Nwoji',
                'division' => 'Market Oversight',
                'grade' => 'Senior Vice President',
                'signature' => 'signature/signed.jpg',
            ],
        ];

        foreach ($dataSet as $data) {

            if (DohSignature::where('name', $data['name'])->exists()) {
                return;
            }

            DohSignature::create($data);
        }

    }
}
