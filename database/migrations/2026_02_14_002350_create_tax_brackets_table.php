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
        Schema::create('tax_brackets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tax_version_id')->constrained()->onDelete('cascade');

            $table->decimal('min_income', 15, 2);
            $table->decimal('max_income', 15, 2)->nullable();

            $table->decimal('base_tax', 15, 2)->default(0);
            $table->decimal('excess_over', 15, 2)->default(0);
            $table->decimal('percentage', 5, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tax_brackets');
    }
};
