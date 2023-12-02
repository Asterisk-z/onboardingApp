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
            ["name" => "Position D"]
        ];

        foreach($positions as $position){
            if(Position::where('name', $position['name'])->exists()){
                continue;
            }

            Position::create($position);
        }
    }
}
