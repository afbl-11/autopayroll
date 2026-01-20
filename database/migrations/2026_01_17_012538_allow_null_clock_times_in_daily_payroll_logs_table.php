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
        Schema::table('daily_payroll_logs', function (Blueprint $table) {
            $table->time('clock_in_time')->nullable()->change();
            $table->time('clock_out_time')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daily_payroll_logs', function (Blueprint $table) {
            $table->time('clock_in_time')->nullable(false)->change();
            $table->time('clock_out_time')->nullable(false)->change();
        });
    }
};
