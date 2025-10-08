<?php

namespace App\Services\Payroll;

use App\Models\AttendanceLogs;
use App\Models\Contracts;
use App\Models\DailyPayrollLog;
use App\Models\Employee;
use App\Models\Payroll;
use App\Models\PayrollPeriod;
use App\Models\Schedule;
use App\Repositories\AttendanceRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\PayrollRepository;
use Carbon\Carbon;
use http\Exception;

class PayrollComputation
{
    public function __construct(){}

    public function computeDailyPayroll($employee_id) :array {

        $employee = Employee::where('employee_id', $employee_id)->first();
        if(!$employee){
            return ['error' => 'Employee not found'];
        }

        $contract = Contracts::where('employee_id', $employee->employee_id)->first();
        if(!$contract){
            return ['error' => 'Contract not found'];
        }

        $attendance = AttendanceLogs::where('employee_id', $employee->employee_id)
            ->whereDate('clock_out_time',now()->toDateString())->first();
        if(!$attendance){
            return ['error' => 'Attendance not found'];
        };

        $schedule = Schedule::where('company_id', $employee->company_id)->first();
        if(!$schedule){
            return ['error' => 'Schedule not found'];
        }

        $regularHours = 8;
        $dailyRate = $contract->rate;
        $hourlyRate = $dailyRate / $regularHours;
        $cashBond = 0;

        $startTime = Carbon::parse($schedule->start_time);
        $endTime = Carbon::parse($schedule->end_time);
        $overtimeRate = 1.25;

        $night_diff_start = Carbon::parse('22:00:00');
        $night_diff_end = Carbon::parse('06:00:00')->addDay();
        $ndRate = 0.10;

        $clock_in = Carbon::parse($attendance->clock_in_time);
        $clock_out = Carbon::parse($attendance->clock_out_time);
        $workHours = $clock_in->diffInMinutes($clock_out);
        $late_time = $startTime->diffInMinutes($clock_in);

        if ($clock_out > $endTime) {
            $overtime_hours = $clock_out->diffInMinutes($endTime, false);
            $overtimePay = $this->computeOvertime($hourlyRate, $overtime_hours,$overtimeRate);
        } else {
            $overtimePay = 0;
        }

        if ($clock_out > $night_diff_start) {
            $nightDiffPay =  $this->computeNightDifferential($hourlyRate, $clock_in,$clock_out,$night_diff_start,$night_diff_end, $ndRate);
        } else {
            $nightDiffPay = 0;
        }

        $late_deductions = $this->computeLateDeduction($hourlyRate, $regularHours, $late_time);

        $gross_daily_salary = $hourlyRate * $workHours ;

        $holidayPay = $dailyRate * 2;
//        TODO: verify if its holiday

        $net_salary = ($gross_daily_salary + $holidayPay + $overtimePay + $nightDiffPay) - $late_deductions;

        $payroll = DailyPayrollLog::create([
            'employee_id' => $employee->employee_id,
            'payroll_period_id' => $contract->payroll_period_id,
            'log_id' => $attendance->log_id,
            'gross_salary' => $gross_daily_salary,
            'net_salary' => $net_salary,
            'deduction' => $late_deductions,
            'overtime' => $overtimePay,
            'night_differential' => $nightDiffPay,
            'holiday_pay' => $holidayPay,
            'cash_bond' => $cashBond,
            'work_hours' => $workHours,
            'late_time' => $late_time,
            'clock_in_time' => $clock_in,
            'clock_out_time' => $clock_out,

        ]);

        return $payroll->toArray();

    }

    public function computeLateDeduction($rate, $regularHours, $late_time)  {

        $deductible = ($rate / $regularHours) / 60;
        return  $deductible * $late_time;

    }

/*
 * ndHours = night differential hours
 * ndPay = night differential pay
 * */
    public function computeNightDifferential($hourlyRate, $clock_in, $clock_out, $night_diff_start, $night_diff_end,$ndRate) {

        $ndHours = $clock_in->max($night_diff_start)->diffInMinutes($clock_out->min($night_diff_end));
        return  $ndPay = $hourlyRate * $ndRate *  $ndHours;
    }

    public function computeOvertime($hourlyRate, $overtimeHours, $overtimeRate) {

        return $overtimePay = $hourlyRate * $overtimeRate * $overtimeHours;

    }

}
