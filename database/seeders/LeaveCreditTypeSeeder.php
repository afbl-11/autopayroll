<?php

namespace Database\Seeders;

use App\Models\LeaveCreditType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class LeaveCreditTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'Vacation',
            'Sick',
            'Maternity',
            'Bereavement',
            'Paternity',
        ];

        foreach ($types as $type) {
            LeaveCreditType::create([
                'leave_credit_type_id' => Str::uuid(), // generate a UUID
                'name' => $type,
            ]);
        }
    }
}
