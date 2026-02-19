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
        Schema::create('pagibig_versions', function (Blueprint $row) {
            $row->id();
            $row->string('name'); // e.g., "HDMF Circular 460 (2024)"
            $row->date('effective_date');

            // The Logic Settings
            $row->decimal('salary_cap', 10, 2)->default(10000.00);
            $row->decimal('employee_rate_below_threshold', 5, 4)->default(0.0100); // 1%
            $row->decimal('employee_rate_above_threshold', 5, 4)->default(0.0200); // 2%
            $row->decimal('employer_rate', 5, 4)->default(0.0200); // 2%
            $row->decimal('threshold_amount', 10, 2)->default(1500.00); // The ₱1,500 dividing line

            $row->enum('status', ['active', 'inactive'])->default('inactive');
            $row->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagibig_versions');
    }
};
