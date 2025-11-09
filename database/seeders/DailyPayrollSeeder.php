<?php

namespace Database\Seeders;

use App\Models\DailyPayrollLog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DailyPayrollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DailyPayrollLog::factory()->count(30)->create();
    }
}
