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
        Schema::create('part_time_assignments', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id');
            $table->string('company_id');
            $table->json('assigned_days'); // e.g., ["Monday", "Tuesday"]
            $table->date('week_start'); // Start of the week for this assignment
            $table->date('week_end'); // End of the week for this assignment
            $table->timestamps();

            $table->foreign('employee_id')
                ->references('employee_id')
                ->on('employees')
                ->onDelete('cascade');

            $table->foreign('company_id')
                ->references('company_id')
                ->on('companies')
                ->onDelete('cascade');

            // Ensure unique assignment per employee per week
            $table->unique(['employee_id', 'week_start']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('part_time_assignments');
    }
};
