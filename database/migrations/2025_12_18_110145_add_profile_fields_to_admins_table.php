<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {

            if (!Schema::hasColumn('admins', 'middle_name')) {
                $table->string('middle_name')->nullable()->after('first_name');
            }

            if (!Schema::hasColumn('admins', 'last_name')) {
                $table->string('last_name')->after('middle_name');
            }

            if (!Schema::hasColumn('admins', 'suffix')) {
                $table->string('suffix')->nullable()->after('last_name');
            }

            if (!Schema::hasColumn('admins', 'profile_photo')) {
                $table->string('profile_photo')->nullable()->after('suffix');
            }

            if (!Schema::hasColumn('admins', 'company_name')) {
                $table->string('company_name')->nullable()->after('suffix');
            }

        });
    }

    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {

            if (Schema::hasColumn('admins', 'profile_photo')) {
                $table->dropColumn('profile_photo');
            }

            if (Schema::hasColumn('admins', 'suffix')) {
                $table->dropColumn('suffix');
            }

            if (Schema::hasColumn('admins', 'last_name')) {
                $table->dropColumn('last_name');
            }

            if (Schema::hasColumn('admins', 'middle_name')) {
                $table->dropColumn('middle_name');
            }

            if (Schema::hasColumn('admins', 'company_name')) {
                $table->dropColumn('company_name');
            }

        });
    }
};
