<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('companies')->insert([
            'company_id' => 'COMP001',
            'company_name' => 'Demo Company',
            'country' => 'Philippines',
            'region' => 'Region VII',
            'province' => 'Cebu',
            'city' => 'Cebu City',
            'barangay' => 'Barangay 1',
            'street' => 'Main St',
            'house_number' => '123',
            'zip' => '6000',
            'industry' => 'IT Services',
            'tin_number' => '123456789000',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
