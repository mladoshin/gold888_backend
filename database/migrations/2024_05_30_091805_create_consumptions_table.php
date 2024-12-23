<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('consumptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained()->cascadeOnDelete();
            $table->string('sum');
            $table->text('description')->nullable();
            $table->string('type');
            $table->string('report_type');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consumptions');
    }
};
