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
        schema::table('leave_credits', function (Blueprint $table) {
            $table->uuid('leave_credit_type_id')->after('employee_id');

            $table->foreign('leave_credit_type_id')
                ->references('leave_credit_type_id')
                ->on('leave_credit_types')
                ->onDelete('cascade');
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
