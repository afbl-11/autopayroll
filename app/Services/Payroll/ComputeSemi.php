<?php

namespace App\Services\Payroll;

use App\Models\DailyPayrollLog;
use App\Models\Payroll;
use App\Models\PayrollPeriod;
use App\Traits\PayrollPeriodTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ComputeSemi
{
    use PayrollPeriodTrait;

    public function __construct(
        private ContributionService  $contService,
    ){}

    public function getDailyLog() {
        [$payroll_start, $payroll_end] = $this->hasPeriod();

        return DailyPayrollLog::whereBetween('payroll_date', [$payroll_start, $payroll_end])
            ->whereNotNull('clock_out_time')
            ->get();
    }

    public function calculateSemiPayroll(){
        $logs = $this->getDailyLog();

        $employeeLogs = $logs->groupBy('employee_id');

        $payroll = [];
        $period = PayrollPeriod::where('is_closed', false)->first();

        foreach ($employeeLogs as $employeeId => $employeeLog) {
            $grossSalary = $employeeLog->sum('gross_salary');
            $netSalary = $employeeLog->sum('net_salary');
            $deductions = $employeeLog->sum('deduction');
            $overtime = $employeeLog->sum('overtime');
            $night_differential = $employeeLog->sum('night_differential');
            $holiday_pay = $employeeLog->sum('holiday_pay');
            $work_hours = $employeeLog->sum('work_hours');
            $late_time = $employeeLog->sum('late_time');

            $pagIbig =  $this->contService->computePagIbig($grossSalary);

            $philHealth = $this->contService->computePhilHealth($grossSalary);

            $sss = $this->contService->computeSSS($grossSalary);

            $payroll [] = [
                'payroll_id' => Str::uuid(),
                'admin_id' => Auth::guard('admin')->id(),
                'employee_id' => $employeeId,
                'payroll_period_id' => $period->payroll_period_id,
                'gross_salary' => $grossSalary,
                'net_pay' => $netSalary,
                'late_deductions' => $deductions,
                'overtime' => $overtime,
                'night_differential' => $night_differential,
                'rate' => 540,
                'pag_ibig_deductions' => $pagIbig['total'],
                'sss_deductions' => $sss['total'],
                'phil_health_deductions' => $philHealth['total'],
                'status' => 'released',
                'holiday' => 0,
                'pay_date' => Carbon::now()->format('Y-m-d'),
                ];
        }

        return Payroll::insert($payroll);
    }

}



//todo: get rates
