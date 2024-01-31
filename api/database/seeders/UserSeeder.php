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
        $roles = ['msg', 'meg', 'fsd', 'mbg', 'blg', 'meg2', 'big', 'FMDQ Help Desk'];

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
                'role_id' => $index + 1,
                'institution_id' => null,
                'position_id' => null,
                'verified_at' => now(),
            ]);

            $user->passwords()->create([
                'password' => Hash::make('password'),
            ]);

        }

    }
}
