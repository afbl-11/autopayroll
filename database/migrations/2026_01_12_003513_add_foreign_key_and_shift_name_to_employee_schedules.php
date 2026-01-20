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
        // Update existing records with company_id from their employee (if any are NULL)
        DB::statement('
            UPDATE employee_schedules es
            INNER JOIN employees e ON es.employee_id = e.employee_id
            SET es.company_id = e.company_id
            WHERE es.company_id IS NULL OR es.company_id = ""
        ');
        
        Schema::table('employee_schedules', function (Blueprint $table) {
            // Add foreign key for company_id if it doesn't exist
            $foreignKeys = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.TABLE_CONSTRAINTS 
                WHERE TABLE_SCHEMA = DATABASE() 
                AND TABLE_NAME = 'employee_schedules' 
                AND CONSTRAINT_TYPE = 'FOREIGN KEY'
                AND CONSTRAINT_NAME = 'employee_schedules_company_id_foreign'
            ");
            
            if (empty($foreignKeys)) {
                $table->foreign('company_id')
                    ->references('company_id')
                    ->on('companies')
                    ->onDelete('cascade');
            }
        });
        
        // Add shift_name column if it doesn't exist
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
            $table->dropColumn('shift_name');
        });
    }
};
