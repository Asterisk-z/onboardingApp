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

        $membershipCategories = [
            [
                "code" => "dmb",
                "name" => "Dealing Member (Banks)",
                "application_fee" => 100000,
                "membership_dues" => 2000000,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/dmb.docx',
            ],
            [
                "code" => "dms",
                "name" => "Dealing Member (Specialist)",
                "application_fee" => 150000,
                "membership_dues" => 2500000,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/dms.docx',
            ],
            [
                "code" => "amb",
                "name" => "Associate Members (Brokers)",
                "application_fee" => 200000,
                "membership_dues" => 3000000,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/amb.docx',
            ],
            [
                "code" => "ami",
                "name" => "Associate Members (Inter-Dealer Broker)",
                "application_fee" => 250000,
                "membership_dues" => 3500000,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/ami.docx',
            ],
            [
                "code" => "amc",
                "name" => "Associate Members (Clients)",
                "application_fee" => 300000,
                "membership_dues" => 4000000,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/amc.docx',
            ],
            [
                "code" => "rml",
                "name" => "Registration Member (Listings)",
                "application_fee" => 350000,
                "membership_dues" => 4500000,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/rml.docx',
            ],
            [
                "code" => "rmq",
                "name" => "Registration Member (Quotations)",
                "application_fee" => 400000,
                "membership_dues" => 5000000,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/rmq.docx',
            ],
            [
                "code" => "lnq",
                "name" => "Registration Member (Listings & Quotations)",
                "application_fee" => 450000,
                "membership_dues" => 5500000,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/lnq.docx',
            ],
            [
                "code" => "afs",
                "name" => "Affiliate Member (Standard) - (Individual)",
                "application_fee" => 500000,
                "membership_dues" => 6000000,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/afs.docx',
            ],
            [
                "code" => "afc",
                "name" => "Affiliate Member (Standard) - (Corporate)",
                "application_fee" => 550000,
                "membership_dues" => 6500000,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/afc.docx',
            ],
            [
                "code" => "aft",
                "name" => "Affiliate Member (Foreign Exchange Trading)",
                "application_fee" => 600000,
                "membership_dues" => 7000000,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/aft.docx',
            ],
            [
                "code" => "afi",
                "name" => "Affiliate Member (Fixed Income)",
                "application_fee" => 650000,
                "membership_dues" => 7500000,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/afi.docx',
            ],
            [
                "code" => "afr",
                "name" => "Affiliate Member (Regulator)",
                "application_fee" => 700000,
                "membership_dues" => 8000000,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/afr.docx',
            ],
            [
                "code" => "aec",
                "name" => "Affiliate Exchange (Corporates)",
                "application_fee" => 750000,
                "membership_dues" => 8500000,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/aec.docx',
            ],
            [
                "code" => "dmf",
                "name" => "Dealing Member (Non-Bank Financial Institutions)",
                "application_fee" => 150000,
                "membership_dues" => 2500000,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/dms.docx',
            ],
        ];

        foreach ($membershipCategories as $category) {
            MembershipCategory::updateOrCreate(['code' => $category['code']], [
                "name" => $category['name'],
                "application_fee" => $category['application_fee'],
                "membership_dues" => $category['membership_dues'],
                "membership_agreement" => $category["membership_agreement"],
            ]);
        }
    }
}
