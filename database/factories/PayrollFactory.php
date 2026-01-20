<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Payroll;
use App\Models\Employee;
use App\Models\PayrollPeriod;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PayrollFactory extends Factory
{
    protected $model = Payroll::class;

    public function definition()
    {
        static $employeeIds = null;
        static $usedCombinations = [];

        if ($employeeIds === null) {
            $employeeIds = Employee::pluck('employee_id')->toArray();
        }

        // Get a random employee and payroll period ensuring uniqueness
        $period = PayrollPeriod::inRandomOrder()->first();
        
        // Find an unused employee for this period
        $availableEmployees = array_diff($employeeIds, $usedCombinations[$period->payroll_period_id] ?? []);
        
        if (empty($availableEmployees)) {
            // If all employees are used for this period, get a new period or reset
            $period = PayrollPeriod::whereNotIn('payroll_period_id', array_keys($usedCombinations))->inRandomOrder()->first();
            if (!$period) {
                // All periods exhausted, reset combinations
                $usedCombinations = [];
                $period = PayrollPeriod::inRandomOrder()->first();
            }
            $availableEmployees = $employeeIds;
        }
        
        $employeeId = $this->faker->randomElement($availableEmployees);
        
        // Mark this combination as used
        if (!isset($usedCombinations[$period->payroll_period_id])) {
            $usedCombinations[$period->payroll_period_id] = [];
        }
        $usedCombinations[$period->payroll_period_id][] = $employeeId;

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
        $admin = Admin::inRandomOrder()->first();
        
        return [
            'payroll_id' => Str::uuid(),
            'admin_id' => $admin->admin_id,
            'employee_id' => $employeeId,
            'payroll_period_id' => $period->payroll_period_id,
            'rate' => $rate,
            'gross_salary' => $grossSalary,
            'net_pay' => $netPay,
            'pag_ibig_deductions' => $pagIbig,
            'sss_deductions' => $sss,
            'phil_health_deductions' => $philHealth,
            'late_deductions' => $late,
            'holiday' => $holiday,
            'night_differential' => $nightDiff,
            'overtime' => $overtime,
            'pay_date' => $this->faker->dateTimeBetween($payDateStart, $payDateEnd)->format('Y-m-d'),
            'status' => $this->faker->randomElement($statuses),
        ];
    }
}
