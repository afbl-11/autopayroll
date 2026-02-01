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
        Schema::table('leave_credits', function (Blueprint $table) {
            $table->uuid('leave_credit_type_id')->after('admin_id');
            $table->foreign('leave_credit_type_id')
                ->references('leave_credit_type_id') // the column in the referenced table
                ->on('leave_credit_types') // referenced table
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leave_credits', function (Blueprint $table) {
            $table->dropColumn('leave_credit_type_id');
        });
    }
};
