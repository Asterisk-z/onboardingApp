<?php

namespace Database\Seeders;

use App\Models\FmdqSystems;
use Illuminate\Database\Seeder;

class FmdqSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $systems = [
            [
                'name' => 'e-Markets Portal'
            ],
            [
                'name' => 'Bloomberg E-Bond Trading System'
            ],
            [
                'name' => 'Refinitiv Trading System'
            ],
            [
                'name' => 'FMDQ OTC FX Futures Trading & Reporting System'
            ]
        ];

        foreach ($systems as $system) {

            FmdqSystems::updateOrCreate([
                'name' => $system['name']
            ]);
        }
    }
}
