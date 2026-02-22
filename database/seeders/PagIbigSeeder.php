<?php

namespace Database\Seeders;

use App\Models\PagIbigVersion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PagIbigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PagIbigVersion::create([
            'name' => 'Pag-IBIG HDMF Circular No. 460 (2026)',
            'effective_date' => '2024-02-01', // Effective since 2024, valid for 2026
            'salary_cap' => 10000.00,
            'employee_rate_below_threshold' => 0.01, // 1% for ₱1,500 and below
            'employee_rate_above_threshold' => 0.02, // 2% for above ₱1,500
            'employer_rate' => 0.02,                 // 2% matching
            'threshold_amount' => 1500.00,
            'status' => 'active',
        ]);
    }
}
