<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhilHealthRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rates = [
            // UHC Law Year 1
            ['date' => '2019-12-01', 'rate' => 2.75, 'floor' => 10000, 'ceiling' => 50000, 'status' => 'Historical'],

            // UHC Law Year 2
            ['date' => '2020-01-01', 'rate' => 3.00, 'floor' => 10000, 'ceiling' => 60000, 'status' => 'Historical'],

            // 2021 & 2022 had suspensions due to the pandemic
            ['date' => '2021-01-01', 'rate' => 3.00, 'floor' => 10000, 'ceiling' => 60000, 'status' => 'Historical'],
            ['date' => '2022-01-01', 'rate' => 4.00, 'floor' => 10000, 'ceiling' => 80000, 'status' => 'Historical'],

            // 2023 hike was also initially suspended
            ['date' => '2023-01-01', 'rate' => 4.00, 'floor' => 10000, 'ceiling' => 80000, 'status' => 'Historical'],

            // 2024: The jump to 5% officially implemented
            ['date' => '2024-01-01', 'rate' => 5.00, 'floor' => 10000, 'ceiling' => 100000, 'status' => 'Active'],

        ];

        foreach ($rates as $data) {
            DB::table('philhealth_rates')->updateOrInsert(
                ['effectivity_year' => $data['date']],
                [
                    'premium_rate' => $data['rate'],
                    'salary_floor' => $data['floor'],
                    'salary_ceiling' => $data['ceiling'],
                    'status' => $data['status'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
