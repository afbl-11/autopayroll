<?php

namespace Database\Seeders;

use App\Models\TaxBracket;
use App\Models\TaxVersion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaxVersionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {

            // 2. Create the Version entry
            $version = TaxVersion::firstOrCreate(
                ['name' => 'TRAIN Law Phase 2 (2026 Revision)'],
                [
                    'effective_date' => '2026-01-01',
                    'status' => 'active',
                ]
            );

            // 3. Define the 2026 Monthly Tax Brackets
            // Format: [min, max, base_tax, excess_over, percentage]
            $brackets = [
                [0, 20833, 0, 0, 0],                                // 0% Bracket
                [20834, 33333, 0, 20833, 0.15],                    // 15%
                [33334, 66667, 1875, 33333, 0.20],                 // 20%
                [66668, 166667, 8541.67, 66667, 0.25],             // 25%
                [166668, 666667, 33541.67, 166667, 0.30],          // 30%
                [666668, null, 183541.67, 666667, 0.35],           // 35%
            ];

            // 4. Wipe existing brackets for this version to avoid duplicates on re-run
            $version->brackets()->delete();

            // 5. Insert new brackets
            foreach ($brackets as $b) {
                TaxBracket::create([
                    'tax_version_id' => $version->id,
                    'min_income'     => $b[0],
                    'max_income'     => $b[1],
                    'base_tax'       => $b[2],
                    'excess_over'    => $b[3],
                    'percentage'     => $b[4],
                ]);
            }
        });

    }
}
