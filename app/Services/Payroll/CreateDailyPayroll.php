<?php

namespace App\Services\Payroll;

use App\Models\DailyPayrollLog;
use App\Models\PayrollPeriod;
use App\Services\AttendanceService;
use App\Traits\ScheduleTrait;

class CreateDailyPayroll
{
    use ScheduleTrait;
    private $attendanceService;
    private $payroll;
    public function __construct( AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
        $this->payroll = new PayrollComputation($attendanceService);
    }
    public function createDailyPayroll($employee_id) : DailyPayrollLog {

        $period = PayrollPeriod::where('is_closed', false)->first();

        $today = now()->toDateString();

        $hasLogin = $this->attendanceService->hasLogIn($employee_id);

        if (!$hasLogin) {
            return DailyPayrollLog::create([
                'employee_id' => $employee_id,
                'payroll_period_id' => $period->daily_payroll_id,
                'gross_salary' => 0,
                'net_salary' => 0,
                'deduction' => 0,
                'overtime' => 0,
                'night_differential' => 0,
                'holiday_pay' => 0,
                'cash_bond' => 0,
                'work_hours' => 0,
                'late_time' => 0,
                'clock_in_time' => '00:00',
                'clock_out_time' => '00:00',
                'payroll_date' => $today,
            ]);
        }
        /*
         * computes payroll, then creates the payroll log
         * todo: should check if created successfully after log out, if not, run again
         * */
        return $this->payroll->computePayroll($employee_id);
    }
}
