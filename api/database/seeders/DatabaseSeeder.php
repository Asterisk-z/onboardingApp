<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(Countries::class);
        $this->call(MembershipCategories::class);
        $this->call(Positions::class);
        $this->call(Roles::class);
        $this->call(ComplaintTypes::class);
        $this->call(UserSeeder::class);
    }
}
