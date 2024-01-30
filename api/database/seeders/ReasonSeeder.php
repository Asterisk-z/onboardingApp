<?php

namespace Database\Seeders;

use App\Models\Reason;
use Illuminate\Database\Seeder;

class ReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $details = [
            ["content" => "Incomplete Payment"]
           
        ];

        foreach ($details as $detail) {
            Reason::updateOrCreate(['content' => $detail['content']], [
                "is_del" => 0
            ]);
        }
    }
}
