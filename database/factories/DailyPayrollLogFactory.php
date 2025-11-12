<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\AttendanceLogs;
use App\Models\DailyPayrollLog;
use App\Models\Employee;
use App\Models\PayrollPeriod;
use App\Traits\PayrollPeriodTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DailyPayrollLog>
 */
class DailyPayrollLogFactory extends Factory
{
    protected $model = DailyPayrollLog::class;

        use PayrollPeriodTrait;
    public function definition(): array
    {
        // -----------------------------
        // 1️⃣ Create or retrieve parent records
        // -----------------------------

        // Employee: pick random or create
        $employee = Employee::inRandomOrder()->first();

        // Payroll Period: pick random or create
        $period = PayrollPeriod::inRandomOrder()->first();
        // Attendance Log: pick random or create, must belong to the selected employee
        $attendance = AttendanceLogs::inRandomOrder()->first();


        // -----------------------------
        // 2️⃣ Generate payroll data
        // -----------------------------
        $grossSalary = $this->faker->randomFloat(2, 400, 1000);
        $deduction = $this->faker->randomFloat(2, 0, 50);
        $overtime = $this->faker->randomFloat(2, 0, 200);
        $nightDifferential = $this->faker->randomFloat(2, 0, 100);
        $holidayPay = $this->faker->randomFloat(2, 0, 150);
        $cashBond = $this->faker->randomFloat(2, 0, 200);

        // Simulate clock-in/out times
        [$payroll_start, $payroll_end] = $this->hasPeriod();
        $payroll_start = Carbon::parse($payroll_start);
        $payroll_end = Carbon::parse($payroll_end);
//        dd($payroll_start, $payroll_end);
        $clockIn = Carbon::createFromTimestamp(rand($payroll_start->timestamp, $payroll_end->timestamp));
//        dd($clockIn);
        $clockOut = (clone $clockIn)->addHours(rand(8, 10));

        $workHours = $clockIn->diffInHours($clockOut);
        $lateTime = rand(0, 60);

        $netSalary = ($grossSalary + $overtime + $nightDifferential + $holidayPay) - $deduction - $cashBond;

        $admin = Admin::inRandomOrder()->first();

        return [
            'daily_payroll_id' => Str::uuid(),
            'admin_id' => $admin->admin_id,
            'employee_id' => $employee->employee_id,
            'payroll_period_id' => $period->payroll_period_id,
            'gross_salary' => $grossSalary,
            'net_salary' => $netSalary,
            'deduction' => $deduction,
            'overtime' => $overtime,
            'night_differential' => $nightDifferential,
            'holiday_pay' => $holidayPay,
            'late_time' => $lateTime,
            'work_hours' => $workHours,
            'clock_in_time' => $clockIn,
            'payroll_date' => $clockIn->format('Y-m-d'),
            'clock_out_time' => $clockOut,
            'is_adjusted' => false,
        ];
    }
}
