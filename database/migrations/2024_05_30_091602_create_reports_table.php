<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->integer('city_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('start_shift')->nullable();
            $table->string('end_shift')->nullable();
            $table->string('refreshment')->nullable();
            $table->mediumText('refreshment_text')->nullable();
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
            $table->mediumText('collection_text')->nullable();
            $table->string('ransom')->nullable();
            $table->string('withdraw_pledges')->nullable();
            $table->string('selling_goods')->nullable();
            $table->string('income_goods')->nullable();
            $table->string('used_goods')->nullable();
            $table->string('pledge_tickets')->nullable();
            $table->string('borrowed_capital')->nullable();
            $table->string('own_capital')->nullable();
            $table->string('smart_start_shift')->nullable();
            $table->string('smart_refreshment')->nullable();
            $table->mediumText('smart_refreshment_text')->nullable();
            $table->string('smart_deposit')->nullable();
            $table->string('smart_renewal')->nullable();
            $table->string('smart_partial_redemption')->nullable();
            $table->string('smart_interest_income')->nullable();
            $table->string('smart_return_goods')->nullable();
            $table->string('smart_deposit_tickets')->nullable();
            $table->string('smart_investor_capital')->nullable();
            $table->string('smart_equity')->nullable();
            $table->string('smart_fixed_flow')->nullable();
            $table->string('smart_collection')->nullable();
            $table->mediumText('smart_collection_text')->nullable();
            $table->string('smart_ransom')->nullable();
            $table->string('smart_withdraw_pledges')->nullable();
            $table->string('smart_selling_goods')->nullable();
            $table->string('smart_income_goods')->nullable();
            $table->string('smart_used_goods')->nullable();
            $table->string('smart_pledge_tickets')->nullable();
            $table->string('smart_borrowed_capital')->nullable();
            $table->string('smart_own_capital')->nullable();
            $table->string('smart_end_shift')->nullable();
            $table->string('smart_buying_up')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
