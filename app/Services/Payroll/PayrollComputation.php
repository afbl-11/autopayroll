<?php

namespace App\Services\Payroll;

use App\Models\AttendanceLogs;
use App\Models\Contracts;
use App\Models\DailyPayrollLog;
use App\Models\Employee;
use App\Models\Payroll;
use App\Models\PayrollPeriod;
use App\Repositories\AttendanceRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\PayrollRepository;
use App\Services\AttendanceService;
use App\Traits\PayrollPeriodTrait;
use App\Traits\ScheduleTrait;
use Carbon\Carbon;
use http\Exception;
use Illuminate\Support\Str;

class PayrollComputation
{
    use ScheduleTrait, PayrollPeriodTrait;
    public function __construct(
        private AttendanceService $attendanceService,
    ){}

    public function computeLateDeduction($rate, $regularHours, $late_time)  {
        $deductible = ($rate / $regularHours) / 60;
        return  $deductible * $late_time;
    }

/*
 * ndHours = night differential hours
 * ndPay = night differential pay
 * */
    public function computeNightDifferential($hourlyRate, $clock_in, $clock_out, $night_diff_start, $night_diff_end,$ndRate) {

        $ndHours = $clock_in->max($night_diff_start)
            ->diffInHours($clock_out->min($night_diff_end));

        return $hourlyRate * $ndHours * $ndRate;
    }

    public function computeOvertime($hourlyRate, $overtimeHours, $overtimeRate) {
        return  abs($hourlyRate * $overtimeRate * $overtimeHours);
    }

    public function computePayroll($employee_id): DailyPayrollLog {

        $data = $this->isScheduledToday($employee_id);
        $isWorkingDay = $data['isWorkingDay'];
        $schedule = $data['schedule'];

        if (!$isWorkingDay || !$schedule) {
            throw new \Exception("Employee $employee_id has no schedule today.");
        }

        $employee = Employee::with('currentRate')->find($employee_id);
        $rate = $employee->currentRate?->rate ?? 0;

        $regularHours = 9;
        $dailyRate = $rate;
        $hourlyRate = $dailyRate / $regularHours;

        $startTime = Carbon::parse($schedule->start_time);
        $endTime = Carbon::parse($schedule->end_time);
        $overtimeRate = 1.25;

        $night_diff_start = Carbon::parse('22:00');
        $night_diff_end = Carbon::parse('06:00')->addDay();
        $nightDiffRate = 1.10;

        $attendance = AttendanceLogs::where('employee_id', $employee_id)
            ->whereNotNull('clock_in_time')
            ->whereNotNull('clock_out_time')
            ->latest('clock_in_time')
            ->first();

        $clock_in = Carbon::parse($attendance->clock_in_time);
        $clock_out = Carbon::parse($attendance->clock_out_time);
        $workHours = $clock_in->diffInHours($clock_out);

        $late_time = $startTime->diffInMinutes($clock_in);

        if($clock_in > $schedule->start_time) {
           $clock_in = Carbon::parse($schedule->start_time);
           $workHours = $clock_in->diffInHours($clock_out);
        }

        if ($clock_out > $endTime) {
            $overtime_hours = $clock_out->diffInHours($endTime, false);
            $overtimePay = $this->computeOvertime($hourlyRate,$overtimeRate, $overtime_hours);
        } else {
            $overtimePay = 0;
        }

        if ($clock_out > $night_diff_start) {
            $nightDiffPay =  $this->computeNightDifferential($hourlyRate, $clock_in,$clock_out,$night_diff_start,$night_diff_end, $nightDiffRate);
        } else {
            $nightDiffPay = 0;
        }

        $late_deductions = $this->computeLateDeduction($hourlyRate, $regularHours, $late_time);

        $gross_daily_salary = $hourlyRate * $workHours ;

        $holidayPay = $dailyRate * 0;
//        TODO: we need to know if it is a holiday (could be handled from credit adjustment temporarily)

        $net_salary = ($gross_daily_salary + $holidayPay + $overtimePay + $nightDiffPay) - $late_deductions;

        $period = PayrollPeriod::where('is_closed',false)
            ->latest()
            ->first();
        $periodId = $period->payroll_period_id;

        return DailyPayrollLog::create([
            'daily_payroll_id' => Str::uuid(),
            'employee_id' => $employee->employee_id,
            'payroll_period_id' => $periodId,
            'gross_salary' => $gross_daily_salary,
            'net_salary' => $net_salary,
            'deduction' => $late_deductions,
            'overtime' => $overtimePay,
            'night_differential' => $nightDiffPay,
            'holiday_pay' => $holidayPay,
            'work_hours' => $workHours,
            'late_time' => $late_time,
            'clock_in_time' => $clock_in,
            'clock_out_time' => $clock_out,
            'payroll_date' => Carbon::now()->toDateTimeString(),
        ]);
    }

}

