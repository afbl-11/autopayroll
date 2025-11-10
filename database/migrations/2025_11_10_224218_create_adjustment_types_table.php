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
        Schema::create('adjustment_types', function (Blueprint $table) {
            $table->uuid('adjustment_type_id')->primary();

            $table->string('main_type');
            $table->string('code');
            $table->string('label');
            $table->string('description');
            $table->boolean('is_active')->default(true);;

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adjustment_types');
    }
};
