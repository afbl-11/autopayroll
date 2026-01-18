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
        // Check if company_id column exists
        if (!Schema::hasColumn('employee_schedules', 'company_id')) {
            Schema::table('employee_schedules', function (Blueprint $table) {
                $table->string('company_id')->nullable()->after('employee_id');
            });
            
            // Update existing records with company_id from their employee
            DB::statement('
                UPDATE employee_schedules es
                INNER JOIN employees e ON es.employee_id = e.employee_id
                SET es.company_id = e.company_id
                WHERE es.company_id IS NULL
            ');
        }
        
        // Add shift_name if it doesn't exist
        if (!Schema::hasColumn('employee_schedules', 'shift_name')) {
            Schema::table('employee_schedules', function (Blueprint $table) {
                $table->string('shift_name')->nullable()->after('end_time');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_schedules', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
            $table->dropColumn('shift_name');
        });
    }
};
