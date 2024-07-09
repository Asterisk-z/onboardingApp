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
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/dmb.pdf',
            ],
            [
                "code" => "dms",
                "name" => "Dealing Member (Specialists)",
                "application_fee" => 150000,
                "membership_dues" => 2500000,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/dms.pdf',
            ],
            [
                "code" => "amb",
                "name" => "Associate Member (Brokers)",
                "application_fee" => 200000,
                "membership_dues" => 3000000,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/amb.pdf',
            ],
            [
                "code" => "ami",
                "name" => "Associate Member (Inter-Dealer Brokers)",
                "application_fee" => 250000,
                "membership_dues" => 3500000,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/ami.pdf',
            ],
            [
                "code" => "amc",
                "name" => "Associate Member (Clients)",
                "application_fee" => 300000,
                "membership_dues" => 4000000,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/amc.pdf',
            ],
            [
                "code" => "rml",
                "name" => "Registration Member (Listings)",
                "application_fee" => 350000,
                "membership_dues" => 4500000,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/rml.pdf',
            ],
            [
                "code" => "rmq",
                "name" => "Registration Member (Quotations)",
                "application_fee" => 400000,
                "membership_dues" => 5000000,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/rmq.pdf',
            ],
            [
                "code" => "lnq",
                "name" => "Registration Member (Listings & Quotations)",
                "application_fee" => 450000,
                "membership_dues" => 5500000,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/lnq.pdf',
            ],
            [
                "code" => "afs",
                "name" => "Affiliate Member - Standard (Individual)",
                "application_fee" => 500000,
                "membership_dues" => 6000000,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/afs.pdf',
            ],
            [
                "code" => "afc",
                "name" => "Affiliate Member - Standard (Corporate)",
                "application_fee" => 550000,
                "membership_dues" => 6500000,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/afc.pdf',
            ],
            [
                "code" => "aft",
                "name" => "Affiliate Member (Foreign Exchange Trading)",
                "application_fee" => 600000,
                "membership_dues" => 7000000,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/aft.pdf',
            ],
            [
                "code" => "afi",
                "name" => "Affiliate Member (Fixed Income)",
                "application_fee" => 650000,
                "membership_dues" => 7500000,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/afi.pdf',
            ],
            [
                "code" => "afr",
                "name" => "Affiliate Member (Regulator)",
                "application_fee" => 700000,
                "membership_dues" => 8000000,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/afr.pdf',
            ],
            [
                "code" => "aec",
                "name" => "Foreign Exchange (Corporates)",
                "application_fee" => 750000,
                "membership_dues" => 8500000,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/aec.pdf',
            ],
            [
                "code" => "dmf",
                "name" => "Dealing Member (Non-Bank Financial Institutions)",
                "application_fee" => 150000,
                "membership_dues" => 2500000,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/dms.pdf',
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
