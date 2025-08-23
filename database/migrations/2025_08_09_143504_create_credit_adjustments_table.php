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
        Schema::create('credit_adjustments', function (Blueprint $table) {
            $table->integer('adjustment_id')->primary();

            $table->string('employee_id');
            $table->foreign('employee_id')
                ->references('employee_id')
                ->on('employees')
                ->onDelete('cascade');

            $table->string('approver_id');
            $table->foreign('approver_id')
                ->references('admin_id')
                ->on('admins')
                ->onDelete('cascade');

            $table->enum('adjustment_type',['attendance','leave','official business']);
            $table->string('reason');
            $table->enum('status',['approved','rejected']);
            $table->date('affected_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_adjustments');
    }
};
