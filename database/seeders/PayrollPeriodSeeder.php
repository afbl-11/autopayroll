<?php

namespace Database\Seeders;

use App\Models\PayrollPeriod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PayrollPeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PayrollPeriod::factory()->count(1)->create();
    }
}
