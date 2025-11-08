<?php

namespace Database\Factories;

use App\Models\AttendanceLogs;
use App\Models\DailyPayrollLog;
use App\Models\Employee;
use App\Models\PayrollPeriod;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DailyPayrollLog>
 */
class DailyPayrollLogFactory extends Factory
{
    protected $model = DailyPayrollLog::class;

    public function definition(): array
    {
        // -----------------------------
        // 1️⃣ Create or retrieve parent records
        // -----------------------------

        // Employee: pick random or create
        $employee = Employee::inRandomOrder()->first() ?? Employee::factory()->create();

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
        $clockIn = Carbon::now()->subHours(rand(9, 10));
        $clockOut = (clone $clockIn)->addHours(rand(8, 10));

        $workHours = $clockIn->diffInHours($clockOut);
        $lateTime = rand(0, 60);

        $netSalary = ($grossSalary + $overtime + $nightDifferential + $holidayPay) - $deduction - $cashBond;

        // -----------------------------
        // 3️⃣ Return factory array
        // -----------------------------
        return [
            'daily_payroll_id' => Str::uuid(), // UUID primary key
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
            'payroll_date' => $this->faker->date(),
            'clock_in_time' => $clockIn,
            'clock_out_time' => $clockOut,
        ];
    }
}
