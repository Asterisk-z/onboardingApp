<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User::truncate();
        $roles = ['msg', 'meg', 'fsd', 'mbg', 'blg', 'meg2', 'big', 'helpdesk'];
        $roleId = ['1', '2', '3', '4', '7', '8', '9', '10'];

        foreach ($roles as $index => $role) {

            $email = "test" . $role . "@fmdqgroup.com";
            $phone = '0816667778' . $index;

            if (User::where('email', $email)->orWhere('phone', $phone)->exists()) {
                continue;
            }

            $user = User::create([
                'first_name' => "Admin" . $role,
                'last_name' => "Admin" . $role,
                'nationality' => 'NG',
                'email' => $email,
                'phone' => $phone,
                'password' => Hash::make('password'),
                'approval_status' => 'approved',
                'role_id' => $roleId[$index],
                'institution_id' => null,
                'position_id' => null,
                'verified_at' => now(),
            ]);

            $user->passwords()->create([
                'password' => Hash::make('password'),
            ]);
        }

        // $roles = ['imisioluwa.bonnie@fmdqgroup.com', 'samuel.oladeinde@fmdqgroup.com', 'olamide.ige@fmdqgroup.com', 'momohemi.williams@fmdqgroup.com', ' kenneth.ichenwo@fmdqgroup.com', 'qag@fmdqgroup.com'];
        // $roleId = ['2', '3', '4', '7', '8', '10'];

        // foreach ($roles as $index => $role) {

        //     $email = $role;
        //     $phone = '08166443' . $index;

        //     if (User::where('email', $email)->orWhere('phone', $phone)->exists()) {
        //         continue;
        //     }

        //     $user = User::create([
        //         'first_name' => "Admin",
        //         'last_name' => "Admin",
        //         'nationality' => 'NG',
        //         'email' => $email,
        //         'phone' => $phone,
        //         'password' => Hash::make('password'),
        //         'approval_status' => 'approved',
        //         'role_id' => $roleId[$index],
        //         'institution_id' => null,
        //         'position_id' => null,
        //         'verified_at' => now(),
        //     ]);

        //     $user->passwords()->create([
        //         'password' => Hash::make('password'),
        //     ]);
        // }

        // $roles = ['ped@fmdqgroup.com'];
        // $roleId = ['2'];

        // foreach ($roles as $index => $role) {

        //     $email = $role;
        //     $phone = '0813434343' . $index;

        //     if (User::where('email', $email)->orWhere('phone', $phone)->exists()) {
        //         continue;
        //     }

        //     $user = User::create([
        //         'first_name' => "Admin",
        //         'last_name' => "Admin",
        //         'nationality' => 'NG',
        //         'email' => $email,
        //         'phone' => $phone,
        //         'password' => Hash::make('password'),
        //         'approval_status' => 'approved',
        //         'role_id' => $roleId[$index],
        //         'institution_id' => null,
        //         'position_id' => null,
        //         'verified_at' => now(),
        //     ]);

        //     $user->passwords()->create([
        //         'password' => Hash::make('password'),
        //     ]);
        // }

        // $roles = ['olangdan12@gmail.com'];
        // $roleId = ['2'];

        // foreach ($roles as $index => $role) {

        //     $email = $role;
        //     $phone = '3453453434' . $index;

        //     if (User::where('email', $email)->orWhere('phone', $phone)->exists()) {
        //         continue;
        //     }

        //     $user = User::create([
        //         'first_name' => "Admin",
        //         'last_name' => "Admin",
        //         'nationality' => 'NG',
        //         'email' => $email,
        //         'phone' => $phone,
        //         'password' => Hash::make('password'),
        //         'approval_status' => 'approved',
        //         'role_id' => $roleId[$index],
        //         'institution_id' => null,
        //         'position_id' => null,
        //         'verified_at' => now(),
        //     ]);

        //     $user->passwords()->create([
        //         'password' => Hash::make('password'),
        //     ]);
        // }

    }
}
