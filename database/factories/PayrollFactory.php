<?php

namespace Database\Factories;

use App\Models\Payroll;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class PayrollFactory extends Factory
{
    protected $model = Payroll::class;

    public function definition()
    {
        $employee = Employee::inRandomOrder()->first();

        $periodStart = $this->faker->dateTimeBetween('-2 months', 'now');
        $periodEnd = (clone $periodStart)->modify('+14 days');

        $now = new \DateTime();
        $payDateEnd = $periodEnd > $now ? $now : $periodEnd;

        $rate = $this->faker->randomFloat(2, 200, 1000); // daily rate
        $totalWorkDays = $this->faker->numberBetween(10, 15);
        $grossSalary = $rate * $totalWorkDays;

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
            'payroll_id' => $this->faker->uuid(),
            'employee_id' => $employee ? $employee->employee_id : $this->faker->uuid(),
            'period_start_date' => $periodStart->format('Y-m-d'),
            'period_end_date' => $periodEnd->format('Y-m-d'),
            'total_work_days' => $totalWorkDays,
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
