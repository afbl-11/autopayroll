<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\AttendanceLogs;
use App\Models\Company;
use App\Models\Contracts;
use App\Models\CreditAdjustment;
use App\Models\DailyPayrollLog;
use App\Models\Employee;
use App\Models\EmployeeSchedule;
use App\Models\LeaveRequest;
use App\Models\Payroll;
use App\Models\PayrollPeriod;
use App\Models\Shift;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default admin with known credentials
        Admin::create([
            'admin_id' => '20260001',
            'first_name' => 'Admin',
            'middle_name' => 'System',
            'last_name' => 'User',
            'email' => 'admin@autopayroll.org',
            'password' => bcrypt('Str0ng_P@ass'),
            'company_name' => 'AutoPayroll System',
            'country' => 'Philippines',
            'region_name' => 'NCR',
            'province_name' => 'Metro Manila',
            'city_name' => 'Makati',
            'zip' => '1200',
            'barangay_name' => 'Poblacion',
            'street' => 'Main Street',
            'house_number' => '123',
            'email_verified_at' => now(),
        ]);

        Admin::factory()->count(1)->create();
        Company::factory()->count(3)->create();
        Employee::factory()->count(10)->create();
        AttendanceLogs::factory()->count(10)->create();
        Contracts::factory()->count(10)->create();

        EmployeeSchedule::factory()->count(10)->create();
        CreditAdjustment::factory()->count(10)->create();
        // Create more payroll periods to avoid duplicate constraint issues
        PayrollPeriod::factory()->count(3)->create();
        DailyPayrollLog::factory()->count(40)->create();
//        LeaveRequest::factory()->count(10)->create();
        // Each employee can have 1 payroll per period, so with 10 employees and 3 periods, max 30 payrolls
        Payroll::factory()->count(10)->create();
    }
}
