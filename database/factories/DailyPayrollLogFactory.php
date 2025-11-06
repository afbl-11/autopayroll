<?php

namespace Database\Factories;

use App\Models\AttendanceLogs;
use App\Models\Employee;
use App\Models\PayrollPeriod;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DailyPayrollLog>
 */
class DailyPayrollLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $grossSalary = $this->faker->randomFloat(2, 400, 1000);
        $deduction = $this->faker->randomFloat(2, 0, 50);
        $overtime = $this->faker->randomFloat(2, 0, 200);
        $nightDifferential = $this->faker->randomFloat(2, 0, 100);
        $holidayPay = $this->faker->randomFloat(2, 0, 150);
        $cashBond = $this->faker->randomFloat(2, 0, 200);

        $employee = Employee::inRandomOrder()->first() ?? Employee::factory()->create();
        $period = PayrollPeriod::inRandomOrder()->first() ?? PayrollPeriod::factory()->create();
        $log = AttendanceLogs::inRandomOrder()->first() ?? AttendanceLogs::factory()->create();

        $clockIn = Carbon::now()->subHours(rand(9, 10));
        $clockOut = (clone $clockIn)->addHours(rand(8, 10));

        $workHours = $clockIn->diffInHours($clockOut);
        $lateTime = rand(0, 60);

        $netSalary = ($grossSalary + $overtime + $nightDifferential + $holidayPay) - $deduction - $cashBond;

        return [
            'daily_payroll_id' => Carbon::now()->year . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
            'employee_id' => $employee->employee_id,
            'payroll_period_id' => $period->payroll_period_id,
            'log_id' => $log->log_id,
            'gross_salary' => $grossSalary,
            'net_salary' => $netSalary,
            'deduction' => $deduction,
            'overtime' => $overtime,
            'night_differential' => $nightDifferential,
            'holiday_pay' => $holidayPay,
            'cash_bond' => $cashBond,
            'late_time' => $lateTime,
            'work_hours' => $workHours,
            'payroll_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['open', 'closed']),
            'clock_in_time' => $clockIn,
            'clock_out_time' => $clockOut,
        ];
    }
}
