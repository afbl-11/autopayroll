<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\AttendanceLogs;
use App\Models\Company;
use App\Models\Contracts;
use App\Models\CreditAdjustment;
use App\Models\DailyPayrollLog;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\Payroll;
use App\Models\PayrollPeriod;
use App\Models\Schedule;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        Company::factory()->count(3)->create();
        Schedule::factory()->count(3)->create();
        Employee::factory()->count(10)->create();
        Admin::factory()->count(2)->create();
        AttendanceLogs::factory()->count(10)->create();
        Contracts::factory()->count(10)->create();
        CreditAdjustment::factory()->count(10)->create();
        PayrollPeriod::factory()->count(1)->create();
        DailyPayrollLog::factory()->count(10)->create();
//        LeaveRequest::factory()->count(10)->create();
        Payroll::factory()->count(10)->create();
    }
}
