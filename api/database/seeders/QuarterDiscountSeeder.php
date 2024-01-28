<?php

namespace Database\Seeders;

use App\Models\MonthlyDiscount;
use Illuminate\Database\Seeder;

class QuarterDiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $details = [
            ["month" => "01", "discounted_percent" => 0],
            ["month" => "02", "discounted_percent" => 0],
            ["month" => "03", "discounted_percent" => 0],
            ["month" => "04", "discounted_percent" => 25],
            ["month" => "05", "discounted_percent" => 25],
            ["month" => "06", "discounted_percent" => 25],
            ["month" => "07", "discounted_percent" => 50],
            ["month" => "08", "discounted_percent" => 50],
            ["month" => "09", "discounted_percent" => 50],
            ["month" => "10", "discounted_percent" => 75],
            ["month" => "11", "discounted_percent" => 75],
            ["month" => "12", "discounted_percent" => 75],
           
        ];

        foreach ($details as $detail) {
            MonthlyDiscount::updateOrCreate(['month' => $detail['month']], [
                "discounted_percent" => $detail['discounted_percent']
            ]);
        }
    }
}
