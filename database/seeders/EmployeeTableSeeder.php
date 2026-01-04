<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            Employee::create([
            'employee_id' => '20261234',
            'admin_id' => '20267149',
            'company_id' => '20262524',

            'first_name' => 'Maria',
            'middle_name' => 'Lourdes',
            'last_name' => 'Santos',
            'profile_photo' => 'default_profile.png',

            'email' => 'maria.santos@example.com',
            'username' => 'maria_santos',
            'password' => bcrypt('password'), // safer than raw hash

            'job_position' => 'Janitor',
            'employment_type' => 'contractual',

            'contract_start' => '2025-01-10',
            'contract_end' => '2026-01-10',

            'birthdate' => '1998-11-03',
            'gender' => 'female',
            'marital_status' => 'married',
            'blood_type' => 'A+',
            'phone_number' => '09984567231',

            'country' => 'Philippines',
            'region_name' => 'Region IV-A',
            'province_name' => 'Laguna',
            'zip' => '4027',
            'city_name' => 'Calamba',
            'barangay_name' => 'Barangay 1',
            'street' => 'Rizal Street',
            'house_number' => '23-A',

            'id_country' => 'Philippines',
            'id_region_name' => 'Region IV-A',
            'id_province_name' => 'Laguna',
            'id_zip' => '4000',
            'id_city_name' => 'Santa Rosa',
            'id_barangay_name' => 'Barangay 4',
            'id_street' => 'Malvar Road',
            'id_house_number' => '15',

            'bank_account_number' => '987654321000',
            'sss_number' => '4455667788',
            'phil_health_number' => '998877665544',
            'pag_ibig_number' => '112233445566',
            'tin_number' => '123789456',
        ]);
        Employee::factory()->count(10)->create();
    }
}
