<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class Roles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ["name" => "MSG"],
            ["name" => "MEG"],
            ["name" => "FSD"],
            ["name" => "MBG"],
            ["name" => "AR INPUTER"],
            ["name" => "AR AUTHORISER"]
        ];

        foreach($roles as $role){
            if(Role::where('name', $role['name'])->exists()){
                continue;
            }

            Role::create($role);
        }
    }
}
