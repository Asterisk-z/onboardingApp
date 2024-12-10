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
                'grade' => 'Senior Vice President',
                'signature' => 'signature/uH0JVwew5FtnkSbocpYz1xgDqPVFsxESacfeSORl.jpg',
            ],
        ];

        foreach ($dataSet as $data) {

            if (DohSignature::where('name', $data['name'])->exist()) {
                return;
            }

            DohSignature::create($data);
        }

    }
}
