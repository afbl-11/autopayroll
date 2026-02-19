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
        Schema::create('sss_versions_tables', function (Blueprint $table) {
            $table->id();
            $table->string('version_name');
            $table->date('effective_date');
            $table->decimal('ee_rate', 5, 4)->default(0.0500);
            $table->decimal('er_rate', 5, 4)->default(0.1000);
            $table->enum('status', ['draft', 'active'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sss_versions_tables');
    }
};
