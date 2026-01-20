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
 * Calculates night differential for hours worked between 10 PM (22:00) and 6 AM (06:00)
 * Returns the 10% premium pay for those hours (not the full wage)
 * */
    public function computeNightDifferential($hourlyRate, $clock_in, $clock_out, $night_diff_start, $night_diff_end,$ndRate) {
        $ndHours = 0;
        
        // Make copies to avoid modifying original Carbon objects
        $clockIn = $clock_in->copy();
        $clockOut = $clock_out->copy();
        
        // Normalize night_diff_end to next day if needed (22:00 today to 06:00 tomorrow)
        if ($night_diff_end->lessThanOrEqualTo($night_diff_start)) {
            $night_diff_end = $night_diff_end->copy()->addDay();
        }
        
        // Handle case where shift spans across midnight
        if ($clockOut->lessThan($clockIn)) {
            $clockOut = $clockOut->copy()->addDay();
        }
        
        // Calculate overlap between work hours and night differential period
        $overlapStart = max($clockIn->timestamp, $night_diff_start->timestamp);
        $overlapEnd = min($clockOut->timestamp, $night_diff_end->timestamp);
        
        // If there's an overlap, calculate hours
        if ($overlapEnd > $overlapStart) {
            $ndHours = ($overlapEnd - $overlapStart) / 3600; // Convert seconds to hours
        }
        
        // Return night differential premium: hourly rate * night hours * 10% premium rate
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
        
        // Handle night shifts: if end time is before start time, it means shift crosses midnight
        if ($endTime->lessThanOrEqualTo($startTime)) {
            $endTime->addDay();
        }
        
        $overtimeRate = 1.25;

        $attendance = AttendanceLogs::where('employee_id', $employee_id)
            ->whereNotNull('clock_in_time')
            ->whereNotNull('clock_out_time')
            ->latest('clock_in_time')
            ->first();

        $clock_in = Carbon::parse($attendance->clock_in_time);
        $clock_out = Carbon::parse($attendance->clock_out_time);
        
        // Handle night shift clock times: if clock_out is before clock_in, add a day
        if ($clock_out->lessThan($clock_in)) {
            $clock_out->addDay();
        }
        
        // Set up night differential period based on clock_in date
        $night_diff_start = $clock_in->copy()->setTimeFromTimeString('22:00:00');
        $night_diff_end = $clock_in->copy()->addDay()->setTimeFromTimeString('06:00:00');
        $nightDiffRate = 0.10; // 10% premium for night hours
        
        $workHours = $clock_in->diffInHours($clock_out);

        // Calculate late time by comparing actual clock_in with scheduled start_time
        $scheduledStart = $clock_in->copy()->setTimeFromTimeString($schedule->start_time);
        $late_time = 0;
        
        // For payroll calculation, use actual clock in/out times
        $clock_in_for_pay = $clock_in->copy();
        $clock_out_for_pay = $clock_out->copy();
        
        // Check if employee was late
        if($clock_in > $scheduledStart) {
           $late_time = $clock_in->diffInMinutes($scheduledStart);
           // For late employees, calculate pay from scheduled time
           $clock_in_for_pay = $scheduledStart->copy();
           
           // Recalculate work hours
           $workHours = $clock_in_for_pay->diffInHours($clock_out_for_pay);
        }

        // Calculate overtime against scheduled end time
        $scheduledEnd = $clock_in->copy()->setTimeFromTimeString($schedule->end_time);
        if ($scheduledEnd->lessThanOrEqualTo($scheduledStart)) {
            $scheduledEnd->addDay();
        }
        
        if ($clock_out_for_pay > $scheduledEnd) {
            $overtime_hours = $clock_out_for_pay->diffInHours($scheduledEnd, false);
            $overtimePay = $this->computeOvertime($hourlyRate,$overtimeRate, $overtime_hours);
        } else {
            $overtimePay = 0;
        }

        // Always calculate night differential using actual work times
        $nightDiffPay = $this->computeNightDifferential($hourlyRate, $clock_in_for_pay, $clock_out_for_pay, $night_diff_start, $night_diff_end, $nightDiffRate);

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
            'admin_id' => $employee->admin_id,
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

