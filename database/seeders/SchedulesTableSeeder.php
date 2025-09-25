<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchedulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('schedules')->insert([
            'schedule_id' => 1,
            'company_id' => 'COMP001',
            'shift_name' => '9AM-5PM',
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
        ]);
    }
}
