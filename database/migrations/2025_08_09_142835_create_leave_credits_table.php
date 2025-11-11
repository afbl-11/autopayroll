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
        Schema::create('leave_credits', function (Blueprint $table) {
            $table->uuid('leave_credit_id')->primary();

            $table->string('admin_id');
            $table->foreign('admin_id')
                ->references('admin_id')
                ->on('admins')
                ->onDelete('cascade');

            $table->decimal('credit_days', 5, 2);
            $table->decimal('used_days', 5, 2)->default(0);
            $table->timestamps();

            $table->string('employee_id');
            $table->foreign('employee_id')
                ->references('employee_id')
                ->on('employees')
                ->onDelete('cascade');

            $table->boolean('is_used')->default(false);
            $table->date('approved_date')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_credits');
    }
};
