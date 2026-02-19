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
        Schema::create('sss_brackets', function (Blueprint $table) {
            $table->id();
            // Use foreignId to properly link to the versions table
            $table->foreignId('version_id')->constrained('sss_versions_tables')->onDelete('cascade');
            $table->decimal('min_salary', 12, 2);
            $table->decimal('max_salary', 12, 2)->nullable();
            $table->decimal('msc_amount', 12, 2); // Fixed typo here
            $table->decimal('ec_er_share', 12, 2)->default(10.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sss_brackets');
    }
};
