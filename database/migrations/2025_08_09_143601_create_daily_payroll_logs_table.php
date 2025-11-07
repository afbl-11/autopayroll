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
        Schema::create('daily_payroll_logs', function (Blueprint $table) {
            $table->string('daily_payroll_id')->primary();

            $table->string('employee_id');
            $table->foreign('employee_id')
                ->references('employee_id')
                ->on('employees')
                ->onDelete('cascade');

            $table->string('payroll_period_id');
            $table->foreign('payroll_period_id')
                ->references('payroll_period_id')
                ->on('payroll_periods')
                ->onDelete('cascade');

            $table->string('log_id');
            $table->foreign('log_id')
                ->references('log_id')
                ->on('attendance_logs')
                ->onDelete('cascade');

            $table->decimal('gross_salary',10,2);
            $table->decimal('net_salary',10,2);
            $table->decimal('deduction',10,2);  //late

            $table->decimal('overtime',10,2);
            $table->decimal('night_differential',10,2);
            $table->decimal('holiday_pay',10,2);
            $table->decimal('cash_bond',10,2);

            $table->integer('late_time');
            $table->integer('work_hours');
            $table->dateTime('clock_in_time');
            $table->dateTime('clock_out_time');

            $table->date('payroll_date');
            $table->enum('status', ['open', 'closed']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_payroll_logs');
    }
};
