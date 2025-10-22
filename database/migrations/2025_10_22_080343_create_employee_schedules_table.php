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
        Schema::create('employee_schedules', function (Blueprint $table) {
            $table->string('employee_schedules_id')->primary();

            $table->string('employee_id');
            $table->foreign('employee_id')
                ->references('employee_id')
                ->on('employees')
                ->onDelete('cascade');

            $table->foreignId('shift_id')->nullable()
                ->constrained('shifts', 'shift_id')
                ->onDelete('set null');

            $table->string('company_id');
            $table->foreign('company_id')
                ->references('company_id')
                ->on('companies')
                ->onDelete('cascade');

            $table->json('working_days'); // example: ["Mon","Tue","Wed","Thu","Fri"]

            // custom overrides (optional, if no shift template is used)
            $table->time('custom_start')->nullable();
            $table->time('custom_end')->nullable();
            $table->time('custom_break_start')->nullable();
            $table->time('custom_break_end')->nullable();
            $table->time('custom_lunch_start')->nullable();
            $table->time('custom_lunch_end')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_schedules');
    }
};
