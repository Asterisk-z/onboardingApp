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
                "name" => "Dealing Member (Bank)",
                "application_fee" => 33750000,
                "membership_dues" => 2000000,
                "max_ar" => 5,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/dmb.pdf',
            ],
            [
                "code" => "dms",
                "name" => "Dealing Member (Specialist)",
                "application_fee" => 22500000,
                "membership_dues" => 250000,
                "max_ar" => 4,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/dms.pdf',
            ],
            [ //DONE

                "code" => "amb",
                "name" => "Associate Member (Brokers)",
                "application_fee" => 5000000,
                "membership_dues" => 1250000,
                "max_ar" => 2,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/amb.pdf',
            ],
            [ //DONE
                "code" => "ami",
                "name" => "Associate Member (Inter-Dealer Brokers)",
                "application_fee" => 20000000,
                "membership_dues" => 1500000,
                "max_ar" => 2,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/ami.pdf',
            ],
            [
                "code" => "amc",
                "name" => "Associate Member (Client)",
                "application_fee" => 5000000,
                "membership_dues" => 1250000,
                "max_ar" => 2,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/amc.pdf',
            ],
            [
                "code" => "rml",
                "name" => "Registration Member (Listings)",
                "application_fee" => 5000000,
                "membership_dues" => 1500000,
                "max_ar" => 2,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/rml.pdf',
            ],
            [
                "code" => "rmq",
                "name" => "Registration Member (Quotations)",
                "application_fee" => 5000000,
                "membership_dues" => 1500000,
                "max_ar" => 2,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/rmq.pdf',
            ],
            [
                "code" => "lnq",
                "name" => "Registration Member (Listings & Quotations)",
                "application_fee" => 7500000,
                "membership_dues" => 1500000,
                "max_ar" => 2,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/lnq.pdf',
            ],
            [
                "code" => "afs",
                "name" => "Affiliate Member - Standard (Individual)",
                "application_fee" => 134375,
                "membership_dues" => 0,
                "max_ar" => 4,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/afs.pdf',
            ],
            [
                "code" => "afc",
                "name" => "Affiliate Member - Standard (Corporate)",
                "application_fee" => 671875,
                "membership_dues" => 0,
                "max_ar" => 4,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/afc.pdf',
            ],
            [
                "code" => "aft",
                "name" => "Affiliate Member (Foreign Exchange Trading)",
                "application_fee" => 335937.5,
                "membership_dues" => 161250,
                "max_ar" => 4,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/aft.pdf',
            ],
            [
                "code" => "afi",
                "name" => "Affiliate Member (Fixed Income)",
                "application_fee" => 1612500,
                "membership_dues" => 0,
                "max_ar" => 4,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/afi.pdf',
            ],
            [
                "code" => "afr",
                "name" => "Affiliate Member (Regulator)",
                "application_fee" => 69875,
                "membership_dues" => 8000000,
                "max_ar" => 4,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/afr.pdf',
            ],
            [
                "code" => "aec",
                "name" => "Foreign Exchange (Corporates)",
                "application_fee" => 0,
                "membership_dues" => 161250,
                "max_ar" => 5,
                "membership_agreement" => config('app.url') . '/assets/membership_agreement/aec.pdf',
            ],
            [
                "code" => "dmf",
                "name" => "Dealing Member (Non-Bank Financial Institutions)",
                "application_fee" => 22500000,
                "membership_dues" => 1500000,
                "max_ar" => 5,
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
