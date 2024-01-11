<?php

namespace Database\Seeders;

use App\Models\GroupMail;
use Illuminate\Database\Seeder;

class LinkGroupMailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $group_mails = [
            ["email" => "dmbceos@fmdqgroup.com"],
            ["email" => "dmsds@fmdqgroup.com"],
            ["email" => "DMBTreasurers@fmdqgroup.com"],
            ["email" => "chiefdealers@fmdqgroup.com"],
            ["email" => "T.billsDealers@fmdqgroup.com"],
            ["email" => "BondDealers@fmdqgroup.com"],
            ["email" => "FXDealers@fmdqgroup.com"],
            ["email" => "ddl@fmdqgroup.com"],
            ["email" => "DMBTROPS@fmdqgroup.com"],
            ["email" => "DMBCompliance@fmdqgroup.com"],
            ["email" => "DMSCEOsActivated@fmdqgroup.com"],
            ["email" => "DMSDealers@fmdqgroup.com"],
            ["email" => "DMSCompliance@fmdqgroup.com"],
            ["email" => "DMSPrimaryContacts@fmdqgroup.com"],
            ["email" => "AMBCEOS@fmdqgroup.com"],
            ["email" => "AMBCompliance@fmdqgroup.com"],
            ["email" => "AMBPrimaryContacts@fmdqgroup.com"],
            ["email" => "AMICEOS@fmdqgroup.com"],
            ["email" => "AMICompliance@fmdqgroup.com"],
            ["email" => "AMIPrimaryContacts@fmdqgroup.com"],
            ["email" => "AMCCEOS@fmdqgroup.com"],
            ["email" => "AMCCompliance@fmdqgroup.com"],
            ["email" => "AMCPrimaryContacts@fmdqgroup.com"],
            ["email" => "RMLCEOs@fmdqgroup.com"],
            ["email" => "RMLCompliance@fmdqgroup.com"],
            ["email" => "RMLPrimaryContacts@fmdqgroup.com"],
            ["email" => "RMQCEO@fmdqgroup.com"],
            ["email" => "RMQCompliance@fmdqgroup.com"],
            ["email" => "RMQPrimaryContacts@fmdqgroup.com"],
        ];

        foreach ($group_mails as $group_mail) {
            if (GroupMail::where('email', $group_mail['email'])->exists()) {
                continue;
            }

            GroupMail::create($group_mail);
        }

    }
}
