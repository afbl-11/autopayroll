<?php

namespace Database\Seeders;

use App\Models\CreditAdjustment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreditAdjustmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CreditAdjustment::factory()->count(3)->create();
    }
}
