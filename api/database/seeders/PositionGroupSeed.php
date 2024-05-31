<?php

namespace Database\Seeders;

use App\Models\PositionGroup;
use Illuminate\Database\Seeder;

class PositionGroupSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $positions = [
            ["name" => "Treasurer"],
            ["name" => "Chief Dealer"],
            ["name" => "Dealer"],
            ["name" => "ALM Officer"],
            ["name" => "Treasury Sales Officer"],
            ["name" => "Head Treasury Operations"],
            ["name" => "Treasury Operations Officer"],
            ["name" => "Chief Compliance Officer"],
            ["name" => "Compliance Officer"],
            ["name" => "Risk Management Officer"],
            ["name" => "Market Risk Officer"],
            ["name" => "Head Information Technology"],
            ["name" => "Information Technology Officer"],
            ["name" => "Head Investment Banking/Capital Markets"],
            ["name" => "Chief Financial Officer"],
            ["name" => "Head ALM"],
            ["name" => "Head Brokerage Operations"],
            ["name" => "Broker/Dealer"],
            ["name" => "Investment Officer"],
            ["name" => "Chief Investment Officer"],
            ["name" => "Financial Advisor"],
        ];

        foreach ($positions as $position) {
            if (PositionGroup::where('name', $position['name'])->exists()) {
                continue;
            }

            PositionGroup::create($position);
        }

    }
}
