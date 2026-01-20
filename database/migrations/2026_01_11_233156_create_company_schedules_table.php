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
        Schema::create('company_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('company_id');
            $table->json('working_days'); // e.g., ["Mon", "Tues", "Wed", "Thurs", "Fri"]
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamp('last_updated_at')->nullable();
            $table->timestamps();

            $table->foreign('company_id')
                ->references('company_id')
                ->on('companies')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_schedules');
    }
};
