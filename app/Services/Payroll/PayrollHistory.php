<?php

namespace App\Services\Payroll;

use App\Models\DailyPayrollLog;
use App\Models\Employee;
use App\Models\Payslip;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PayrollHistory
{

    public function __construct(
        protected MonthlyPayslipService $monthlyPayslipService,
    ){}
    public function generateAllPayslipsForEmployee(Employee $employee)
    {

        /*
         * takes every payroll log of the employee
         * */
        $firstLog = DailyPayrollLog::where('employee_id', $employee->employee_id)
            ->orderBy('payroll_date')
            ->first();

        if (!$firstLog) return;

        $startMonth = Carbon::parse($firstLog->payroll_date)->startOfMonth();
        $endMonth   = Carbon::now()->startOfMonth();

        $periods = [];
        $cursor = $startMonth->copy();

        while ($cursor <= $endMonth) {
            $year  = $cursor->year;
            $month = $cursor->month;

            // Two periods per month: 1-15 and 16-end
            $periods[] = ['year' => $year, 'month' => $month, 'period' => '1-15'];
            $periods[] = ['year' => $year, 'month' => $month, 'period' => '16-30'];

            $cursor->addMonth();
        }


        /*
         * takes the calculated payroll
         * */
        foreach ($periods as $p) {
            $payrollData = $this->monthlyPayslipService->generateMonthlyPayslip($employee->employee_id, $p['year'], $p['month'], $p['period']);

            if (!$payrollData) continue; // skip if no logs


            Payslip::updateOrCreate(
                [
                    'employee_id' => $employee->employee_id,
                    'year'        => $p['year'],
                    'month'       => $p['month'],
                    'period'      => $p['period'],
                ],
                [
                    'payslips_id' => Str::uuid(),
                    'reference'   => $this->generatePayslipReference(),
                    'period_start'=> $payrollData['period']['start_date'],
                    'period_end'  => $payrollData['period']['end_date'],
                    'pay_date'    => now(),
                    'net_pay'     => $payrollData['net_pay'],
                    'status'      => 'pending',
                    'breakdown'   => json_encode($payrollData),
                ]
            );
        }
    }

    function generatePayslipReference(): string
    {
        $year = Carbon::now()->year;

        $lastReference = DB::table('payslips')
            ->whereYear('created_at', $year)
            ->where('reference', 'like', "PAY-$year-%")
            ->orderByDesc('reference')
            ->value('reference');

        if ($lastReference) {
            $lastNumber = (int) substr($lastReference, -3);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return sprintf('PAY-%d-%03d', $year, $nextNumber);
    }

    public function updatePayslip() {

    }
}
