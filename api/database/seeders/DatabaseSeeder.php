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
        $this->call(LinkGroupMailSeeder::class);
        $this->call(CategoryPositions::class);
        $this->call(Roles::class);
        $this->call(ComplaintTypes::class);
        $this->call(UserSeeder::class);
        $this->call(SystemSettingSeeder::class);
        $this->call(ApplicationFieldSeed::class);
        $this->call(ApplicationFieldOptionSeeder::class);
    }
}
