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
        Schema::create('announcements', function (Blueprint $table) {
            $table->uuid('announcement_id')->primary();

            $table->string('admin_id');
            $table->foreign('admin_id')
                ->references('admin_id')
                ->on('admins')
                ->onDelete('cascade');

            $table->uuid('announcement_type_id');
            $table->foreign('announcement_type_id')
                ->references('announcement_type_id')
                ->on('announcement_types')
                ->onDelete('cascade');

            $table->string('title')->nullable();
            $table->string('subject')->nullable();
            $table->enum('type', ['Admin','Payroll', 'Memo']);
            $table->text('message');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->string('created_by');
            $table->json('attachments')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
