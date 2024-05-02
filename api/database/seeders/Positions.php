<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class Positions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions = [
            ["name" => "Group Managing Director"],
            ["name" => "Managing Director/CEO", "can_be_authorizer" => true],
            ["name" => "Supervising Director"],
            ["name" => "Treasurer"],
            ["name" => "Chief Dealer", "can_be_authorizer" => true],
            ["name" => "Senior Dealer "],
            ["name" => "T.bills Dealer 1"],
            ["name" => "T.bills Dealer 2"],
            ["name" => "T.bills Dealer 3"],
            ["name" => "Bonds Dealer 1"],
            ["name" => "Bonds Dealer 2"],
            ["name" => "Bonds Dealer 3"],
            ["name" => "FX Dealer 1"],
            ["name" => "FX Dealer 2"],
            ["name" => "FX Dealer 3"],
            ["name" => "Money Market Dealer 1"],
            ["name" => "Money Market Dealer 2"],
            ["name" => "Money Market Dealer 3"],
            ["name" => "Derivatives Dealer 1"],
            ["name" => "Derivatives Dealer 2"],
            ["name" => "Derivatives Dealer 3"],
            ["name" => "ALM Officer 1"],
            ["name" => "ALM Officer 2"],
            ["name" => "ALM Officer 3"],
            ["name" => "Treasury Sales Officer 1"],
            ["name" => "Treasury Sales Officer 2"],
            ["name" => "Treasury Sales Officer 3"],
            ["name" => "Head, Treasury Operations "],
            ["name" => "Treasury Operations Officer 1 "],
            ["name" => "Treasury Operations Officer 2"],
            ["name" => "Treasury Operations Officer 3"],
            ["name" => "Chief Compliance Officer", "can_be_authorizer" => true],
            ["name" => "Compliance Officer 1"],
            ["name" => "Compliance Officer 2"],
            ["name" => "Compliance Officer 3"],
            ["name" => "Group Head, Internal Control"],
            ["name" => "Internal Control Officer 1"],
            ["name" => "Internal Control Officer 2"],
            ["name" => "Internal Control Officer 3"],
            ["name" => "Chief Audit Executive"],
            ["name" => "Internal Audit Officer 1"],
            ["name" => "Internal Audit Officer 2"],
            ["name" => "Internal Audit Officer 3"],
            ["name" => "Chief Risk Officer"],
            ["name" => "Risk Management Officer"],
            ["name" => "Risk Management Officer 1"],
            ["name" => "Risk Management Officer 2"],
            ["name" => "Risk Management Officer 3"],
            ["name" => "Head, Market Risk"],
            ["name" => "Market Risk Officer 1"],
            ["name" => "Market Risk Officer 2"],
            ["name" => "Market Risk Officer 3"],
            ["name" => "Head, IT"],
            ["name" => "IT Officer 1"],
            ["name" => "IT Officer 2"],
            ["name" => "IT Officer 3"],
            ["name" => "Head of Investments"],
            ["name" => "Dealer(s)"],
            ["name" => "Primary Contact(s)"],
            ["name" => "Treasurer/Chief Financial Officer", "can_be_authorizer" => true],
        ];

        foreach ($positions as $position) {
            if (Position::where('name', $position['name'])->exists()) {
                continue;
            }

            Position::create($position);
        }
    }
}
