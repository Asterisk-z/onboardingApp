<?php

namespace Database\Seeders;

use App\Models\MembershipCategory;
use Illuminate\Database\Seeder;

class MembershipCategories extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $categories = [
            ["code" => "dmb", "name" => "Dealing Member (Banks)"],
            ["code" => "dms", "name" => "Dealing Member (Specialist)"],
            ["code" => "amb", "name" => "Associate Members (Brokers)"],
            ["code" => "ami", "name" => "Associate Members (Inter-Dealer Broker)"],
            ["code" => "amc", "name" => "Associate Members (Clients)"],
            ["code" => "rml", "name" => "Registration Member (Listings)"],
            ["code" => "rmq", "name" => "Registration Member (Quotations)"],

            ["code" => "lnq", "name" => "Registration Member (Listings & Quotations)"],
            ["code" => "dmn", "name" => "Dealing Members (Non-bank Financial Institutions)"],
            ["code" => "afs", "name" => "Affiliate Member (Standard) - Individual"],
            ["code" => "afc", "name" => "Affiliate Member (Standard) - Corporates"],
            ["code" => "aft", "name" => "Affiliate Member (Foreign Exchange Trading)"],
            ["code" => "afi", "name" => "Affiliate Member (Fixed Income)"],
            ["code" => "afr", "name" => "Affiliate Member (Regulator)"],
            ["code" => "aec", "name" => "Affiliate Exchange (Corporates)"],
        ];

        foreach ($categories as $category) {
            MembershipCategory::updateOrCreate(['code' => $category['code']], [
                "name" => $category['name']
            ]);
        }
    }
}
