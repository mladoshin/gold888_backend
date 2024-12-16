<?php

namespace Database\Seeders;


use Database\Factories\RegionFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            RegionSeeder::class,
            CitySeeder::class,
            BranchesSeeder::class,
            OverdueSeeder::class
        ]);
    }
}
