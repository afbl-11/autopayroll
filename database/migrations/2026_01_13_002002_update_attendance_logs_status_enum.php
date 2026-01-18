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
        // For MySQL, we need to use raw SQL to alter enum
        DB::statement("ALTER TABLE attendance_logs MODIFY COLUMN status ENUM('P', 'O', 'LT', 'A', 'DO', 'R', 'S', 'L', 'CO', 'CDO', 'present', 'absent', 'on_leave', 'official_business') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original enum values
        DB::statement("ALTER TABLE attendance_logs MODIFY COLUMN status ENUM('present', 'absent', 'on_leave', 'official_business') NOT NULL");
    }
};
