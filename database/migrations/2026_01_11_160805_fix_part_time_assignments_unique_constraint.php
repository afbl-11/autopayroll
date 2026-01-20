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
        Schema::table('part_time_assignments', function (Blueprint $table) {
            // First, drop foreign keys
            $table->dropForeign(['employee_id']);
            $table->dropForeign(['company_id']);
        });
        
        Schema::table('part_time_assignments', function (Blueprint $table) {
            // Drop the old unique constraint
            $table->dropUnique(['employee_id', 'week_start']);
            
            // Add new unique constraint (employee_id + company_id + week_start)
            $table->unique(['employee_id', 'company_id', 'week_start'], 'pt_assignments_emp_company_week_unique');
            
            // Re-add foreign keys
            $table->foreign('employee_id')
                ->references('employee_id')
                ->on('employees')
                ->onDelete('cascade');

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
        Schema::table('part_time_assignments', function (Blueprint $table) {
            // Drop foreign keys
            $table->dropForeign(['employee_id']);
            $table->dropForeign(['company_id']);
        });
        
        Schema::table('part_time_assignments', function (Blueprint $table) {
            // Drop the new unique constraint
            $table->dropUnique('pt_assignments_emp_company_week_unique');
            
            // Restore the old unique constraint
            $table->unique(['employee_id', 'week_start']);
            
            // Re-add foreign keys
            $table->foreign('employee_id')
                ->references('employee_id')
                ->on('employees')
                ->onDelete('cascade');

            $table->foreign('company_id')
                ->references('company_id')
                ->on('companies')
                ->onDelete('cascade');
        });
    }
};
