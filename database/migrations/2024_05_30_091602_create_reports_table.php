<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('start_shift')->nullable();
            $table->string('refreshment')->nullable();
            $table->string('deposit')->nullable();
            $table->string('renewal')->nullable();
            $table->string('partial_redemption')->nullable();
            $table->string('interest_income')->nullable();
            $table->string('return_goods')->nullable();
            $table->string('deposit_tickets')->nullable();
            $table->string('investor_capital')->nullable();
            $table->string('equity')->nullable();
            $table->string('fixed_flow')->nullable();
            $table->string('collection')->nullable();
            $table->string('ransom')->nullable();
            $table->string('withdraw_pledges')->nullable();
            $table->string('selling_goods')->nullable();
            $table->string('income_goods')->nullable();
            $table->string('used_goods')->nullable();
            $table->string('pledge_tickets')->nullable();
            $table->string('borrowed_capital')->nullable();
            $table->string('own_capital')->nullable();
            $table->string('report_type')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
