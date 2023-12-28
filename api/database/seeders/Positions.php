<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class Positions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions = [
            ["name" => "Position A"],
            ["name" => "Position B"],
            ["name" => "Position C"],
            ["name" => "Position D"],
            ["name" => "Position E"],
            ["name" => "Position F"],
            ["name" => "Position G"],
            ["name" => "Position H"],
            ["name" => "Position I"],
            ["name" => "Position J"],
            ["name" => "Position K"],
            ["name" => "Position L"],
            ["name" => "Position M"],
            ["name" => "Position N"],
            ["name" => "Position O"],
            ["name" => "Position P"],
            ["name" => "Position Q"],
            ["name" => "Position R"],
            ["name" => "Position S"],
            ["name" => "Position T"],
            ["name" => "Position U"],
            ["name" => "Position V"],
            ["name" => "Position W"],
            ["name" => "Position X"],
            ["name" => "Position Y"],
            ["name" => "Position Z"],
            ["name" => "CCO"],
        ];

        foreach ($positions as $position) {
            if (Position::where('name', $position['name'])->exists()) {
                continue;
            }

            Position::create($position);
        }
    }
}
