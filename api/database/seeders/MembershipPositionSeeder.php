<?php

namespace Database\Seeders;

use App\Models\MembershipCategoryPostition;
use Illuminate\Database\Seeder;

class MembershipPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions = [
            [
                "category_id" => 1,
                "position_id" => 1,
            ],
            [
                "category_id" => 1,
                "position_id" => 2,
            ],
            [
                "category_id" => 1,
                "position_id" => 4,
            ],
            [
                "category_id" => 2,
                "position_id" => 2,
            ],
            [
                "category_id" => 2,
                "position_id" => 3,
            ],
            [
                "category_id" => 3,
                "position_id" => 1,
            ],
        ];

        foreach($positions as $position){

            MembershipCategoryPostition::updateOrCreate([
                "category_id" => $position['category_id'],
                "position_id" => $position['position_id']
            ]);
        }
    }
}
