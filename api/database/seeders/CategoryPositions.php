<?php

namespace Database\Seeders;

use App\Models\MembershipCategory;
use App\Models\MembershipCategoryPostition;
use App\Models\Position;
use Illuminate\Database\Seeder;

class CategoryPositions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $categories = MembershipCategory::all();
        $positions = Position::count();

        foreach ($categories as $category) {
            $totalRelations = rand(0, $positions);
            if ($totalRelations > 0) {
                for ($i = 0; $i <= $totalRelations; $i++) {
                    MembershipCategoryPostition::updateOrCreate([
                        "category_id" => $category->id,
                        "position_id" => rand(1, $positions),
                    ]);

                }
            }
        }
    }
}
