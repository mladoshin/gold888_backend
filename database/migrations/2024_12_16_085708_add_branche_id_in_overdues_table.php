<?php

use Database\Seeders\BranchesSeeder;
use Database\Seeders\CitySeeder;
use Database\Seeders\OverdueSeeder;
use Database\Seeders\RegionSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Artisan::call('db:seed', ['--class' => RegionSeeder::class]);
        Artisan::call('db:seed', ['--class' => CitySeeder::class]);
        Artisan::call('db:seed', ['--class' => BranchesSeeder::class]);

        Schema::table('overdues', function (Blueprint $table) {
            $table->foreignId('branch_id')->default(1)->constrained('branches')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('overdues', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
        });
    }
};
