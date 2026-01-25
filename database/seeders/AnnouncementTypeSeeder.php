<?php

namespace Database\Seeders;

use App\Models\AnnouncementType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class AnnouncementTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['Admin', 'Payroll', 'Memo'];

        foreach ($types as $type) {
            AnnouncementType::create([
                'announcement_type_id' => Str::uuid(),
                'name' => $type
            ]);
        }
    }
}
