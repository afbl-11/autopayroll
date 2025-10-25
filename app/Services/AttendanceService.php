<?php

namespace App\Services;

use App\Models\AttendanceLogs;
use App\Models\EmployeeSchedule;
use App\Models\PayrollPeriod;
use App\Traits\ScheduleTrait;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class AttendanceService
{
    use ScheduleTrait;
    public function countAttendance($id):int {
        /*
         * This method counts the total attendances from the start to end of the payroll period.
         * */
        $payroll_period = PayrollPeriod::where('is_closed', false)
            ->latest()
            ->firstOrFail();


        $payroll_start = $payroll_period->start_date;
        $payroll_end = $payroll_period->end_date;

        return AttendanceLogs::where('employee_id', $id)
            ->whereBetween('created_at', [$payroll_start, $payroll_end])
            ->count();
    }

    public function countTotalAbsences($id):int {
        /*
         * This method counts total absences from the start to end of the payroll period
         * absences from the previous period will not be counted.
         * */
        $payroll_period = PayrollPeriod::where('is_closed', false)
            ->latest()
            ->firstOrFail();

        $payroll_start = $payroll_period->start_date;
        $payroll_end = $payroll_period->end_date;

        $schedule = EmployeeSchedule::where('employee_id', $id)
            ->latest()
            ->firstOrFail();

        $workingDays = is_array($schedule->working_days)
            ? $schedule->working_days
            : json_decode($schedule->working_days, true);

        $expectedWorkingDays = 0;
//        loops through the days
        foreach (CarbonPeriod::create($payroll_start, $payroll_end) as $date) {
            if (in_array($date->format('D'), $workingDays)) {
                $expectedWorkingDays++;
            }
        }
        $presentDays = AttendanceLogs::where('employee_id', $id)
            ->whereBetween('created_at', [$payroll_start, $payroll_end])
            ->selectRaw('COUNT(DISTINCT DATE(created_at)) as present_days')
            ->value('present_days') ?? 0;


        return max(0, $expectedWorkingDays - $presentDays);
    }

    public function computeOvertime($id):int
    {
        $todayData = $this->isScheduledToday($id);
        $schedule = $todayData['schedule'];

        if (!$todayData['isWorkingDay']) {
            return true;
        }

        $end_time = Carbon::parse($schedule->shift->end_time);

//        gets the latest/current day log record
        $log = AttendanceLogs::where('employee_id', $id)
            ->whereDate('created_at', today())
            ->latest('created_at')
            ->first();

        if (!$log || !$log->clock_out_time) {
            return 0; //no clock out or absent, then no overtime
        }

        $clock_out = Carbon::parse($log->clock_out_time);

        return $clock_out->greaterThan($end_time)
            ? (int) round(abs($clock_out->floatDiffInHours($end_time)))
            : 0;
    }

    public function totalOvertime($id):int {
        $totalOvertime = 0;

        $payroll_period = PayrollPeriod::where('is_closed', false)
            ->latest()
            ->firstOrFail();

        $payroll_start = $payroll_period->start_date;
        $payroll_end = $payroll_period->end_date;

        $logs = AttendanceLogs::where('employee_id', $id)
            ->whereBetween('created_at', [$payroll_start, $payroll_end])
            ->whereNotNull('clock_out_time')
            ->get();

        foreach ($logs as $log) {
            $todayData = $this->isScheduledToday($id);
            $schedule = $todayData['schedule'];

            if (!$todayData['isWorkingDay']) {
                continue;
            }

            $end_time = Carbon::parse($schedule->shift->end_time);
            $clock_out = Carbon::parse($log->clock_out_time);

            if ($clock_out->greaterThan($end_time)) {
                $totalOvertime += $clock_out->floatDiffInHours($end_time);
            }
        }

        return (int) round(abs($totalOvertime));
    }

    public function computeLate($id): int {

        $todayData = $this->isScheduledToday($id);
        $schedule = $todayData['schedule'];

        if (!$todayData['isWorkingDay']) {
            return true;
        }

        $log = AttendanceLogs::where('employee_id', $id)
            ->whereDate('created_at', today())
            ->latest('clock_in_time')
            ->first();

        if (!$log || !$log->clock_in_time) return 0;

        $clock_in = Carbon::parse($log->clock_in_time);

        $start_time = Carbon::parse($log->created_at)
            ->setTimeFromTimeString($schedule->shift->start_time);

        if ($clock_in->lessThanOrEqualTo($start_time)) return 0;

        return abs($clock_in->diffInMinutes($start_time));
    }

    public function hasLogIn($id): bool {

        $todayData = $this->isScheduledToday($id);

        if (!$todayData['isWorkingDay']) {
            return true;
        }

        $today = now()->toDateString();

        return AttendanceLogs::where('employee_id', $id)
            ->whereDate('created_at', $today)
            ->whereNotNull('clock_in_time')
            ->exists();
    }
    public function noClockOut($id): bool {
        $todayData = $this->isScheduledToday($id);

        if (!$todayData['isWorkingDay']) {
            return true;
        }
        $today = now()->toDateString();

        return AttendanceLogs::where('employee_id', $id)
            ->whereDate('created_at', $today)
            ->whereNotNull('clock_in_time')
            ->whereNull('clock_out_time')
            ->exists();
    }

    public function totalNoClockOut($id): int
    {
        $todayData = $this->isScheduledToday($id);

        if (!$todayData['isWorkingDay']) {
            return 0;
        }
        $payroll_period = PayrollPeriod::where('is_closed', false)
            ->latest()
            ->firstOrFail();

        $payroll_start = $payroll_period->start_date;
        $payroll_end = $payroll_period->end_date;

        return AttendanceLogs::where('employee_id', $id)
            ->whereBetween('created_at', [$payroll_start, $payroll_end])
            ->whereNotNull('clock_in_time')
            ->whereNull('clock_out_time')
            ->count();
    }
}
