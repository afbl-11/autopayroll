<?php

namespace App\Services\Payroll;

use App\Models\DailyPayrollLog;
use App\Models\Employee;
use Carbon\Carbon;

class MonthlyPayslipService
{
    protected $contributionService;

    public function __construct(
        protected TaxService $taxService,
    )
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


        $previousNet = 0;

        if($startDate->format('Y-m-d') > 15 ){
            $tempStart = $startDate->format('Y-m-d');
            $tempEnd = $endDate->format('Y-m-d');

            $previousStartDate = Carbon::parse($tempStart)->startOfMonth()->format('Y-m-d');
            $previousEndDate = Carbon::parse($tempEnd)->startOfMonth()->addDay(14)->format('Y-m-d');

            $previousPayroll = DailyPayrollLog::withoutGlobalScope(\App\Models\Scopes\AdminScope::class)
                ->where('employee_id', $employeeId)
                ->whereBetween('payroll_date', [$previousStartDate, $previousEndDate])
                ->get();

            if ($previousPayroll->isEmpty()) {
                return null;
            }

            $previousWorkDays = $previousPayroll->count();
            $previousWorkHours = $previousPayroll->sum('work_hours');
            $previousGrossSalary = $previousPayroll->sum('gross_salary');
            $previousOvertimePay = $previousPayroll->sum('overtime');
            $previousLateDeductions = $previousPayroll->sum('deduction');
            $previousHolidayPay = $previousPayroll->sum('holiday_pay');
            $previousNightDifferential = $previousPayroll->sum('night_differential');
            $previousLateMinutes = $previousPayroll->sum('late_time');

            $previousNet = ($previousGrossSalary + $previousHolidayPay + $previousNightDifferential + $previousOvertimePay) - $previousLateDeductions;

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
        $grossSalary = $totalGrossSalary + $totalOvertimePay + $totalNightDifferential;
        $applyDeductions = ($period === '16-30' || $period === 'monthly');
        if($applyDeductions){

            $wholeMonthGross = $grossSalary + $previousNet;
        }
        $contributions = $applyDeductions
            ? $this->contributionService->computeAll($wholeMonthGross)
            : [
                'sss'        => ['employee' => 0, 'employer' => 0, 'total' => 0],
                'philhealth' => ['employee' => 0, 'employer' => 0, 'total' => 0],
                'pagibig'    => ['employee' => 0, 'employer' => 0, 'total' => 0],
                'total_employee'     => 0,
                'total_employer'     => 0,
                'total_contribution' => 0,
            ];
        // Calculate taxable income
        $totalStatutoryDeductions = $contributions['total_employee'];
        $netTaxableIncome = $grossSalary - $totalStatutoryDeductions;

        if($applyDeductions){
            $totalTaxableIncome = $netTaxableIncome + $previousNet;
        }else {
            $totalTaxableIncome = $netTaxableIncome;
        }

        $withholdingTax = 0;
        if ($applyDeductions) {
            // We use the cumulative taxable income (1st half + 2nd half)
            // to find the correct Monthly Bracket in your TaxService.
            $withholdingTax = $this->taxService->compute($totalTaxableIncome);
        }

        // Calculate total deductions
        $totalDeductions = $totalStatutoryDeductions + $withholdingTax + $totalLateDeductions;

        // Calculate net pay
        // Net Pay = Gross Taxable Salary + Holiday Pay - Total Deductions
        // Note: Holiday pay is non-taxable, so it's added after tax calculations

        if($applyDeductions){
            $netPay = ($grossSalary + $totalHolidayPay + $previousNet) - $totalDeductions;
        }else {
            $netPay = ($grossSalary + $totalHolidayPay) - $totalDeductions;

        }

        return [
            'employee' => $employee,
            'period' => [
                'year' => $year,
                'month' => $month,
                'month_name' => Carbon::create($year, $month, 1)->format('F'),
                'start_date' => $startDate->format('Y-m-d'), // change here
                'end_date'   => $endDate->format('Y-m-d'),   // change here
                'period_type' => $period,
                'period_label' => $this->getPeriodLabel($period, $year, $month),
            ],
            'work_summary' => [
                'total_days' => $totalWorkDays,
                'total_hours' => $totalWorkHours,
                'late_minutes' => $totalLateMinutes,
                'total_overtime' => $totalOvertimePay
            ],
            'previous_payroll' => [
                'previous_WorkDays' => $previousWorkDays,
                'previous_WorkHours' => $previousWorkHours,
                'previousGrossSalary' => $previousGrossSalary,
                'previousOvertimePay' => $previousOvertimePay,
                'previousLateDeductions' => $previousLateDeductions,
                'previousHolidayPay' => $previousHolidayPay,
                'previousNightDifferential' => $previousNightDifferential,
                'previousLateMinutes' => $previousLateMinutes,
                'previousNet' => $previousNet,
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
                'gross_taxable_salary' => $grossSalary,
                'taxable_income' => $totalTaxableIncome,
            ],
            'deductions' => [
                'sss' => $contributions['sss']['employee'],
                'philhealth' => $contributions['philhealth']['employee'],
                'pagibig' => $contributions['pagibig']['employee'],
                'employer_sss' => $contributions['sss']['employer'],
                'employer_pagibig' => $contributions['pagibig']['employer'],
                'employer_philhealth' => $contributions['philhealth']['employer'],
                'withholding_tax' => $withholdingTax,
                'late_deductions' => $totalLateDeductions,
                'total_statutory' => $contributions['total_employee'],
                'total_employer' => $contributions['total_employer'],
                'total_deductions' => $contributions['total_employee'] + $withholdingTax,

            ],
            'net_pay' => round($netPay, 2),
            'net_taxable_income' => round($totalTaxableIncome, 2),
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
