<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->integer('region_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name');
            $table->mediumText('address');
            $table->string('kpi_day_plan')->nullable();
            $table->string('kpi_month_plan')->nullable();
            $table->string('kpi_year_plan')->nullable();
            $table->string('kpi_day_fact')->nullable();
            $table->string('kpi_month_fact')->nullable();
            $table->string('kpi_year_fact')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('branches');
    }
};
