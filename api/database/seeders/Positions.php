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
            ["name" => "Group Managing Director", "position_group_id" => 20],
            ["name" => "Managing Director/CEO", "can_be_authorizer" => true, "position_group_id" => 20],
            ["name" => "Supervising Director", "position_group_id" => 20],
            ["name" => "Treasurer", "position_group_id" => 1],
            ["name" => "Chief Dealer", "can_be_authorizer" => true, "position_group_id" => 2],
            ["name" => "Senior Dealer ", "position_group_id" => 3],
            ["name" => "T.bills Dealer 1", "position_group_id" => 3],
            ["name" => "T.bills Dealer 2", "position_group_id" => 3],
            ["name" => "T.bills Dealer 3", "position_group_id" => 3],
            ["name" => "Bonds Dealer 1", "position_group_id" => 3],
            ["name" => "Bonds Dealer 2", "position_group_id" => 3],
            ["name" => "Bonds Dealer 3", "position_group_id" => 3],
            ["name" => "FX Dealer 1", "position_group_id" => 18],
            ["name" => "FX Dealer 2", "position_group_id" => 18],
            ["name" => "FX Dealer 3", "position_group_id" => 18],
            ["name" => "Money Market Dealer 1", "position_group_id" => 3],
            ["name" => "Money Market Dealer 2", "position_group_id" => 3],
            ["name" => "Money Market Dealer 3", "position_group_id" => 3],
            ["name" => "Derivatives Dealer 1", "position_group_id" => 3],
            ["name" => "Derivatives Dealer 2", "position_group_id" => 3],
            ["name" => "Derivatives Dealer 3", "position_group_id" => 3],
            ["name" => "ALM Officer 1", "position_group_id" => 4],
            ["name" => "ALM Officer 2", "position_group_id" => 4],
            ["name" => "ALM Officer 3", "position_group_id" => 4],
            ["name" => "Treasury Sales Officer 1", "position_group_id" => 5],
            ["name" => "Treasury Sales Officer 2", "position_group_id" => 5],
            ["name" => "Treasury Sales Officer 3", "position_group_id" => 5],
            ["name" => "Head, Treasury Operations ", "position_group_id" => 6],
            ["name" => "Treasury Operations Officer 1 ", "position_group_id" => 7],
            ["name" => "Treasury Operations Officer 2", "position_group_id" => 7],
            ["name" => "Treasury Operations Officer 3", "position_group_id" => 7],
            ["name" => "Chief Compliance Officer", "can_be_authorizer" => true, "position_group_id" => 8],
            ["name" => "Compliance Officer 1", "position_group_id" => 9],
            ["name" => "Compliance Officer 2", "position_group_id" => 9],
            ["name" => "Compliance Officer 3", "position_group_id" => 9],
            ["name" => "Group Head, Internal Control", "position_group_id" => 19],
            ["name" => "Internal Control Officer 1", "position_group_id" => 19],
            ["name" => "Internal Control Officer 2", "position_group_id" => 19],
            ["name" => "Internal Control Officer 3", "position_group_id" => 19],
            ["name" => "Chief Audit Executive", "position_group_id" => 20],
            ["name" => "Internal Audit Officer 1", "position_group_id" => 20],
            ["name" => "Internal Audit Officer 2", "position_group_id" => 20],
            ["name" => "Internal Audit Officer 3", "position_group_id" => 20],
            ["name" => "Chief Risk Officer", "position_group_id" => 10],
            ["name" => "Risk Management Officer", "position_group_id" => 10],
            ["name" => "Risk Management Officer 1", "position_group_id" => 10],
            ["name" => "Risk Management Officer 2", "position_group_id" => 10],
            ["name" => "Risk Management Officer 3", "position_group_id" => 10],
            ["name" => "Head, Market Risk", "position_group_id" => 11],
            ["name" => "Market Risk Officer 1", "position_group_id" => 11],
            ["name" => "Market Risk Officer 2", "position_group_id" => 11],
            ["name" => "Market Risk Officer 3", "position_group_id" => 11],
            ["name" => "Head, IT", "position_group_id" => 12],
            ["name" => "IT Officer 1", "position_group_id" => 13],
            ["name" => "IT Officer 2", "position_group_id" => 13],
            ["name" => "IT Officer 3", "position_group_id" => 13],
            ["name" => "Head of Investments", "position_group_id" => 14],
            ["name" => "Dealer(s)", "position_group_id" => 3],
            ["name" => "Primary Contact(s)", "position_group_id" => 21],
            ["name" => "Treasurer/Chief Financial Officer", "can_be_authorizer" => true, "position_group_id" => 15],
            // Added By developer
            ["name" => "Head ALM Officer", "position_group_id" => 16],
            ["name" => "Head, Brokerage Operations", "position_group_id" => 17],
        ];

        foreach ($positions as $position) {
            if (Position::where('name', $position['name'])->exists()) {
                continue;
            }

            Position::create($position);
        }
    }
}
