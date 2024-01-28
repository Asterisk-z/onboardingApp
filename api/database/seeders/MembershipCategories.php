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
            [
                "code" => "dmb", 
                "name" => "Dealing Member (Banks)",
                "application_fee" => 100000,
                "membership_dues" => 2000000
            ],
            [
                "code" => "dms", 
                "name" => "Dealing Member (Specialist)",
                "application_fee" => 150000,
                "membership_dues" => 2500000
            ],
            [
                "code" => "amb", 
                "name" => "Associate Members (Brokers)",
                "application_fee" => 200000,
                "membership_dues" => 3000000
            ],
            [
                "code" => "ami", 
                "name" => "Associate Members (Inter-Dealer Broker)",
                "application_fee" => 250000,
                "membership_dues" => 3500000
            ],
            [
                "code" => "amc", 
                "name" => "Associate Members (Clients)",
                "application_fee" => 300000,
                "membership_dues" => 4000000
            ],
            [
                "code" => "rml", 
                "name" => "Registration Member (Listings)",
                "application_fee" => 350000,
                "membership_dues" => 4500000
            ],
            [
                "code" => "rmq", 
                "name" => "Registration Member (Quotations)",
                "application_fee" => 400000,
                "membership_dues" => 5000000
            ],

            [
                "code" => "lnq", 
                "name" => "Registration Member",
                "application_fee" => 450000,
                "membership_dues" => 5500000
            ],
            [
                "code" => "afs", 
                "name" => "Affiliate Member (Standard) - Individual",
                "application_fee" => 500000,
                "membership_dues" => 6000000
            ],
            [
                "code" => "afc", 
                "name" => "Affiliate Member (Standard) - Corporates",
                "application_fee" => 550000,
                "membership_dues" => 6500000
            ],
            [
                "code" => "aft", 
                "name" => "Affiliate Member (Foreign Exchange Trading)",
                "application_fee" => 600000,
                "membership_dues" => 7000000
            ],
            [
                "code" => "afi", 
                "name" => "Affiliate Member (Fixed Income)",
                "application_fee" => 650000,
                "membership_dues" =>7500000
            ],
        ];

        foreach ($categories as $category) {
            MembershipCategory::updateOrCreate(['code' => $category['code']], [
                "name" => $category['name'],
                "application_fee" => $category['application_fee'],
                "membership_dues" => $category['membership_dues']
            ]);
        }
    }
}
