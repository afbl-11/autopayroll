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
        Schema::create('payroll_adjustments', function (Blueprint $table) {
            $table->uuid('payroll_adjustment_id')->primary();

            $table->string('daily_payroll_id');
            $table->foreign('daily_payroll_id')
                ->references('daily_payroll_id')
                ->on('daily_payroll_logs')
                ->onDelete('cascade');

            $table->string('admin_id');
            $table->foreign('admin_id')
                ->references('admin_id')
                ->on('admins')
                ->onDelete('cascade');

            $table->string('employee_id');
            $table->foreign('employee_id')
                ->references('employee_id')
                ->on('employees')
                ->onDelete('cascade');

            $table->foreignUuid('payroll_period_id')
                ->references('payroll_period_id')
                ->on('payroll_periods')
                ->onDelete('cascade');

            $table->decimal('gross_salary',10,2)->nullable();
            $table->decimal('net_salary',10,2)->nullable();
            $table->decimal('deduction',10,2)->nullable();  //late

            $table->decimal('overtime',10,2)->nullable();
            $table->decimal('night_differential',10,2)->nullable();
            $table->decimal('holiday_pay',10,2)->nullable();

            $table->date('adjusted_date');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_adjustments');
    }
};
