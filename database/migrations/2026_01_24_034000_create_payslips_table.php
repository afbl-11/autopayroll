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
        Schema::create('payslips', function (Blueprint $table) {
            $table->uuid('payslips_id')->primary();

            $table->string('employee_id');
            $table->foreign('employee_id')
                ->references('employee_id')
                ->on('employees')
                ->onDelete('cascade');

            $table->year('year');
            $table->tinyInteger('month');
            $table->string('period'); // 1-15, 16-30, monthly
            $table->date('period_start');
            $table->date('period_end');
            $table->date('pay_date')->nullable();
            $table->decimal('net_pay', 12, 2);
            $table->enum('status', ['pending', 'released', 'held'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payslips');
    }
};
