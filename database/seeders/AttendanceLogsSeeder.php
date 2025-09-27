<?php

namespace Database\Seeders;

use App\Models\AttendanceLogs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendanceLogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AttendanceLogs::factory()->count(10)->create();
    }
}
