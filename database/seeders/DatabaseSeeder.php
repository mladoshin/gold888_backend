<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Branch;
use App\Models\Region;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        Region::create(['name' => 'Актау']);
        Branch::create(['region_id' => 1, 'name' => 'Филиал №11']);
         \App\Models\User::factory()->create([
             'region_id' => 1,
             'branch_id' => 1,
             'name' => 'Admin User',
             'email' => 'admin@admin.com',
             'password' => bcrypt('123456'),
         ]);
    }
}
