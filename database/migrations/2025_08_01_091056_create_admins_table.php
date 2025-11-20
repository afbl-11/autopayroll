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
        Schema::create('admins', function (Blueprint $table) {
            $table->string('admin_id')->primary();
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->enum('suffix', ['Sr.','Jr.'])->nullable();
            $table->string('email')->unique();
            $table->string('password');

            $table->string('company_name');
            $table->string('country');
            $table->string('region_name');
            $table->string('province_name')->nullable();
            $table->string('zip');
            $table->string('city_name');
            $table->string('barangay_name');
            $table->string('street');
            $table->string('house_number')->nullable();
            $table->string('email_verified_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
