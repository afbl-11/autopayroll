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
        Schema::create('leave_adjustments', function (Blueprint $table) {
            $table->uuid('leave_adjustment_id')->primary();

            $table->foreignuuid('leave_request_id')
                ->references('leave_request_id')
                ->on('leave_request')
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


            $table->enum('leave_type', ['sick', 'vacation', 'maternity', 'bereavement', 'emergency'])->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status', ['pending','approved','rejected','need revision'])->default('pending')->nullable();
            $table->string('supporting_doc')->nullable(); //images, word, pdf file
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_adjustments');
    }
};
