<?php

namespace App\Services\Payroll;

use App\Models\DailyPayrollLog;
use App\Models\Employee;
use Carbon\Carbon;

class MonthlyPayslipService
{
    protected $contributionService;

    public function __construct()
    {
        $this->contributionService = new ContributionService();
    }

    /**
     * Generate monthly payslip data for an employee
     * @param string $period - 'monthly', '1-15', or '16-30'
     */
    public function generateMonthlyPayslip($employeeId, $year, $month, $period = 'monthly')
    {
        $employee = Employee::with(['currentRate', 'company'])->find($employeeId);
        
        if (!$employee) {
            throw new \Exception("Employee not found");
        }

        // Determine date range based on period
        $startDate = Carbon::create($year, $month, 1);
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();
        
        if ($period === '1-15') {
            $startDate = Carbon::create($year, $month, 1);
            $endDate = Carbon::create($year, $month, 15);
        } elseif ($period === '16-30') {
            $startDate = Carbon::create($year, $month, 16);
            $endDate = Carbon::create($year, $month, 1)->endOfMonth();
        }

        $dailyLogs = DailyPayrollLog::withoutGlobalScope(\App\Models\Scopes\AdminScope::class)
            ->where('employee_id', $employeeId)
            ->whereBetween('payroll_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->get();

        if ($dailyLogs->isEmpty()) {
            return null;
        }

        // Calculate totals
        $totalWorkDays = $dailyLogs->count();
        $totalWorkHours = $dailyLogs->sum('work_hours');
        $totalGrossSalary = $dailyLogs->sum('gross_salary');
        $totalOvertimePay = $dailyLogs->sum('overtime');
        $totalLateDeductions = $dailyLogs->sum('deduction');
        $totalHolidayPay = $dailyLogs->sum('holiday_pay');
        $totalNightDifferential = $dailyLogs->sum('night_differential');
        $totalLateMinutes = $dailyLogs->sum('late_time');

        // Get employee rate
        $dailyRate = $employee->currentRate?->rate ?? 0;
        $monthlyRate = $dailyRate * 22; // Standard 22 working days per month
        $hourlyRate = $dailyRate / 8;

        // Calculate government contributions based on monthly rate
        // Only apply deductions on 16-30 period or full monthly
        $applyDeductions = ($period === '16-30' || $period === 'monthly');
        
        $contributions = $applyDeductions 
            ? $this->contributionService->computeAll($monthlyRate)
            : ['sss' => ['employee' => 0], 'philhealth' => ['employee' => 0], 'pagibig' => ['employee' => 0], 'total_employee' => 0];

        // Calculate taxable income
        $grossTaxableSalary = $totalGrossSalary + $totalOvertimePay + $totalNightDifferential;
        $totalStatutoryDeductions = $contributions['total_employee'];
        $netTaxableIncome = $grossTaxableSalary - $totalStatutoryDeductions;

        // Simple tax computation (15% for amounts over 20,833) - only apply on 16-30 or monthly
        $withholdingTax = 0;
        if ($applyDeductions && $netTaxableIncome > 20833) {
            $withholdingTax = round(($netTaxableIncome - 20833) * 0.15, 2);
        }

        // Calculate total deductions
        $totalDeductions = $totalStatutoryDeductions + $withholdingTax + $totalLateDeductions;

        // Calculate net pay
        // Net Pay = Gross Taxable Salary + Holiday Pay - Total Deductions
        // Note: Holiday pay is non-taxable, so it's added after tax calculations
        $netPay = $grossTaxableSalary - $totalDeductions + $totalHolidayPay;

        return [
            'employee' => $employee,
            'period' => [
                'year' => $year,
                'month' => $month,
                'month_name' => Carbon::create($year, $month, 1)->format('F'),
                'start_date' => $startDate->format('F d, Y'),
                'end_date' => $endDate->format('F d, Y'),
                'period_type' => $period,
                'period_label' => $this->getPeriodLabel($period, $year, $month),
            ],
            'work_summary' => [
                'total_days' => $totalWorkDays,
                'total_hours' => $totalWorkHours,
                'late_minutes' => $totalLateMinutes,
            ],
            'rates' => [
                'daily' => $dailyRate,
                'monthly' => $monthlyRate,
                'hourly' => $hourlyRate,
            ],
            'earnings' => [
                'basic_salary' => $totalGrossSalary,
                'overtime_pay' => $totalOvertimePay,
                'holiday_pay' => $totalHolidayPay,
                'night_differential' => $totalNightDifferential,
                'gross_taxable_salary' => $grossTaxableSalary,
            ],
            'deductions' => [
                'sss' => $contributions['sss']['employee'],
                'philhealth' => $contributions['philhealth']['employee'],
                'pagibig' => $contributions['pagibig']['employee'],
                'withholding_tax' => $withholdingTax,
                'late_deductions' => $totalLateDeductions,
                'total_statutory' => $totalStatutoryDeductions,
                'total_deductions' => $totalDeductions,
            ],
            'net_pay' => round($netPay, 2),
            'net_taxable_income' => round($netTaxableIncome, 2),
            'daily_logs' => $dailyLogs,
        ];
    }

    /**
     * Get period label for display
     */
    private function getPeriodLabel($period, $year, $month)
    {
        $monthName = Carbon::create($year, $month, 1)->format('F Y');
        
        switch ($period) {
            case '1-15':
                return "$monthName (1st-15th)";
            case '16-30':
                $lastDay = Carbon::create($year, $month, 1)->endOfMonth()->day;
                return "$monthName (16th-{$lastDay}th)";
            default:
                return $monthName;
        }
    }
}
