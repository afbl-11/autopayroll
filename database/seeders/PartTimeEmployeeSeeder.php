<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class PartTimeEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first admin ID
        $adminId = Admin::first()->admin_id ?? '20260001';

        $partTimeEmployees = [
            [
                'first_name' => 'Sarah',
                'middle_name' => 'Ann',
                'last_name' => 'Johnson',
                'days_available' => json_encode(['Monday', 'Wednesday', 'Friday']),
                'job_position' => 'Cashier',
                'username' => 'sjohnson',
            ],
            [
                'first_name' => 'Michael',
                'middle_name' => 'James',
                'last_name' => 'Williams',
                'days_available' => json_encode(['Tuesday', 'Thursday']),
                'job_position' => 'Sales Associate',
                'username' => 'mwilliams',
            ],
            [
                'first_name' => 'Emma',
                'middle_name' => 'Grace',
                'last_name' => 'Davis',
                'days_available' => json_encode(['Monday', 'Tuesday', 'Wednesday']),
                'job_position' => 'Stock Clerk',
                'username' => 'edavis',
            ],
            [
                'first_name' => 'David',
                'middle_name' => 'Lee',
                'last_name' => 'Martinez',
                'days_available' => json_encode(['Wednesday', 'Thursday', 'Friday']),
                'job_position' => 'Customer Service',
                'username' => 'dmartinez',
            ],
            [
                'first_name' => 'Olivia',
                'middle_name' => 'Marie',
                'last_name' => 'Garcia',
                'days_available' => json_encode(['Monday', 'Friday']),
                'job_position' => 'Assistant',
                'username' => 'ogarcia',
            ],
        ];

        foreach ($partTimeEmployees as $index => $employee) {
            $employeeId = '2026' . str_pad(9000 + $index, 4, '0', STR_PAD_LEFT);
            
            Employee::create([
                'employee_id' => $employeeId,
                'admin_id' => $adminId,
                'company_id' => null, // Part-time employees are not assigned to a company
                'first_name' => $employee['first_name'],
                'middle_name' => $employee['middle_name'],
                'last_name' => $employee['last_name'],
                'suffix' => null,
                'email' => strtolower($employee['username']) . '@parttime.com',
                'username' => $employee['username'],
                'phone_number' => '09' . rand(100000000, 999999999),
                'password' => Hash::make('password123'),
                'job_position' => $employee['job_position'],
                'contract_start' => now(),
                'contract_end' => now()->addYear(),
                'employment_type' => 'part-time',
                'days_available' => $employee['days_available'],
                'birthdate' => now()->subYears(rand(20, 40)),
                'gender' => ['male', 'female'][rand(0, 1)],
                'marital_status' => 'single',
                'blood_type' => 'O+',
                'country' => 'Philippines',
                'region_name' => 'NCR',
                'province_name' => null,
                'zip' => '1000',
                'city_name' => 'Manila',
                'barangay_name' => 'Ermita',
                'street' => 'Sample Street',
                'house_number' => (string)rand(1, 999),
                'id_country' => 'Philippines',
                'id_region_name' => 'NCR',
                'id_province_name' => null,
                'id_zip' => '1000',
                'id_city_name' => 'Manila',
                'id_barangay_name' => 'Ermita',
                'id_street' => 'Sample Street',
                'id_house_number' => (string)rand(1, 999),
                'bank_account_number' => rand(1000000000, 9999999999),
                'sss_number' => sprintf('%02d-%07d-%d', rand(10, 99), rand(1000000, 9999999), rand(0, 9)),
                'phil_health_number' => sprintf('%02d-%09d-%d', rand(10, 99), rand(100000000, 999999999), rand(0, 9)),
                'pag_ibig_number' => sprintf('%04d-%04d-%04d', rand(1000, 9999), rand(1000, 9999), rand(1000, 9999)),
                'tin_number' => sprintf('%03d-%03d-%03d-%03d', rand(100, 999), rand(100, 999), rand(100, 999), rand(100, 999)),
            ]);
        }
    }
}
