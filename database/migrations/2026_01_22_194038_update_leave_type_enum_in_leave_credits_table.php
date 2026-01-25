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
        Schema::table('leave_request', function (Blueprint $table) {
            $table->enum('leave_type', ['Sick', 'Vacation', 'Maternity', 'Bereavement', 'Paternity'])
                ->default('Vacation')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leave_request', function (Blueprint $table) {
            $table->enum('leave_type', ['sick', 'vacation', 'maternity', 'bereavement', 'emergency'])
                ->default('vacation')
                ->change();
        });
    }
};
