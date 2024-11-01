<?php

namespace Database\Seeders;

use App\Models\Overdue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OverdueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Overdue::factory(20)->create();
    }
}
