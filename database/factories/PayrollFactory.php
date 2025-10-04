<?php

namespace Database\Factories;

use App\Models\Payroll;
use App\Models\Employee;
use App\Models\PayrollPeriod;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PayrollFactory extends Factory
{
    protected $model = Payroll::class;

    public function definition()
    {
        static $employeeIds = null;

        if ($employeeIds === null) {
            $employeeIds = Employee::pluck('employee_id')->toArray();
        }

        $payroll_period = PayrollPeriod::inRandomOrder()->first();

        $periodStart = $this->faker->dateTimeBetween('-2 months', 'now');
        $periodEnd = (clone $periodStart)->modify('+14 days');

        $now = new \DateTime();
        $payDateEnd = $periodEnd > $now ? $now : $periodEnd;

        $rate = $this->faker->randomFloat(2, 200, 1000); // daily rate
        $grossSalary = $rate * 10;

        $pagIbig = $grossSalary * 0.02;
        $sss = $grossSalary * 0.045;
        $philHealth = $grossSalary * 0.035;
        $late = $this->faker->randomFloat(2, 0, 500);
        $cashBond = $this->faker->randomFloat(2, 0, 200);

        $holiday = $this->faker->randomFloat(2, 0, 1000);
        $nightDiff = $this->faker->randomFloat(2, 0, 500);
        $overtime = $this->faker->randomFloat(2, 0, 800);

        $netPay = $grossSalary - ($pagIbig + $sss + $philHealth + $late + $cashBond) + ($holiday + $nightDiff + $overtime);

        $statuses = ['released', 'processing'];

        $payDateStart = $periodStart > $payDateEnd ? $payDateEnd : $periodStart;

        return [
            'payroll_id' => Carbon::now()->year . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
            'employee_id' =>$this->faker->randomElement($employeeIds),
            'payroll_period_id' => $payroll_period ? $payroll_period->payroll_period_id : $this->faker->uuid(),
            'rate' => $rate,
            'gross_salary' => $grossSalary,
            'net_pay' => $netPay,
            'pag_ibig_deductions' => $pagIbig,
            'sss_deductions' => $sss,
            'phil_health_deductions' => $philHealth,
            'late_deductions' => $late,
            'cash_bond' => $cashBond,
            'holiday' => $holiday,
            'night_differential' => $nightDiff,
            'overtime' => $overtime,
            'pay_date' => $this->faker->dateTimeBetween($payDateStart, $payDateEnd)->format('Y-m-d'),
            'status' => $this->faker->randomElement($statuses),
        ];
    }
}
