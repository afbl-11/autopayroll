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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->string('payroll_id')->primary();

            $table->string('employee_id');
            $table->foreign('employee_id')
                ->references('employee_id')
                ->on('employees')
                ->onDelete('cascade');

            // payroll period
            $table->date('period_start_date');
            $table->date('period_end_date');

            $table->integer('total_work_days'); //should be foreign key
            $table->decimal('rate', 10 ,2);

            // salary
            $table->decimal('gross_salary', 10, 2);
            $table->decimal('net_pay', 10, 2);

            // deductions
            $table->decimal('pag_ibig_deductions', 10, 2);
            $table->decimal('phil_health_deductions', 10, 2);
            $table->decimal('sss_deductions', 10, 2);
            $table->decimal('late_deductions', 10, 2)->nullable();
            $table->decimal('cash_bond', 10, 2)->nullable();


            // additional pay
            $table->decimal('holiday', 10, 2)->nullable();
            $table->decimal('night_differential', 10, 2)->nullable();
            $table->decimal('overtime', 10, 2)->nullable();

            // paydate and status

            $table->date('pay_date');
            $table->enum('status', ['released','processing']);
//TODO: make a get function that will get the status, and count the employees
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
