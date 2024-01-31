<?php

namespace Database\Seeders;

use App\Models\FmdqBankAccount;
use App\Models\MembershipCategoryPostition;
use Illuminate\Database\Seeder;

class AccountDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $details = [
            [
                "bank_name" => "Access Bank",
                "account_name" => "FMDQ Holdings PLC",
                "account_number" => "0689977404",
                "sort_code" => "044151106",
                "bank_code" => "044"
            ],
            [
                "bank_name" => "Zenith Bank PLC",
                "account_name" => "FMDQ Holdings PLC",
                "account_number" => "1013859207",
                "sort_code" => "057150796",
                "bank_code" => "057"
            ]
        ];

        foreach($details as $detail){

            FmdqBankAccount::updateOrCreate(['account_number' => $detail['account_number']],$detail);
        }
    }
}
