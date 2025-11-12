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
        Schema::create('attendance_adjustments', function (Blueprint $table) {
            $table->uuid('attendance_adjustment_id')->primary();

            $table->foreignUuid('log_id')
               ->references('log_id')
                ->on('attendance_logs')
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

            $table->string('company_id');
            $table->foreign('company_id')
                ->references('company_id')
                ->on('companies')
                ->onDelete('cascade');

            $table->dateTime('clock_in_time')->nullable();
            $table->dateTime('clock_out_time')->nullable();

            $table->enum('status', ['present', 'absent', 'on_leave', 'official_business'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_adjustments');
    }
};
