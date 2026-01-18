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
        Schema::table('attendance_logs', function (Blueprint $table) {
            // Check if columns don't exist before adding
            if (!Schema::hasColumn('attendance_logs', 'time_in')) {
                $table->time('time_in')->nullable()->after('log_date');
            }
            if (!Schema::hasColumn('attendance_logs', 'time_out')) {
                $table->time('time_out')->nullable()->after('time_in');
            }
            if (!Schema::hasColumn('attendance_logs', 'selfie_path')) {
                $table->string('selfie_path')->nullable()->after('clock_out_longitude');
            }
            if (!Schema::hasColumn('attendance_logs', 'is_manual')) {
                $table->boolean('is_manual')->default(false)->after('selfie_path');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendance_logs', function (Blueprint $table) {
            $table->dropColumn(['time_in', 'time_out', 'selfie_path', 'is_manual']);
        });
    }
};
