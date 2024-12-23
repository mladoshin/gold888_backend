<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('overdues', function (Blueprint $table) {
            $table->id();
            $table->string('user');
            $table->string('status')->default(\App\Models\OverdueStatus::TRANSFERRED_TO_A_LAWYER);
            $table->bigInteger('amount');
            $table->unsignedBigInteger('returned');
            $table->text('result')->nullable();
            $table->date('return_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('overdues');
    }
};
