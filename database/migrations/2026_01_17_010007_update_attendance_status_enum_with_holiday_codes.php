<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update ENUM to include new status codes: RH, SH, CD while keeping old ones for compatibility
        DB::statement("ALTER TABLE attendance_logs MODIFY COLUMN status ENUM('P', 'O', 'OT', 'LT', 'A', 'DO', 'R', 'RH', 'S', 'SH', 'L', 'CO', 'CD', 'CDO', 'present', 'absent', 'on_leave', 'official_business') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to previous enum values
        DB::statement("ALTER TABLE attendance_logs MODIFY COLUMN status ENUM('P', 'O', 'LT', 'A', 'DO', 'R', 'S', 'L', 'CO', 'CDO', 'present', 'absent', 'on_leave', 'official_business') NOT NULL");
    }
};
