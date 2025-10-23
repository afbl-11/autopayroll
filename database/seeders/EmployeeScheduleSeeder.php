<?php

namespace Database\Seeders;

use App\Models\EmployeeSchedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmployeeSchedule::factory()->count(10)->create();
    }
}
