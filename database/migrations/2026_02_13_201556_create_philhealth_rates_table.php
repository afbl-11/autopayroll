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
        Schema::create('philhealth_rates', function (Blueprint $table) {
            $table->id();
            $table->date('effectivity_year')->unique();
            $table->decimal('premium_rate', 5, 2);
            $table->decimal('salary_floor', 10, 2);
            $table->decimal('salary_ceiling', 10, 2);
            $table->enum('status', ['Active', 'Historical'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('philhealth_rates');
    }
};
