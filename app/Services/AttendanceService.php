<?php

namespace App\Services;

use App\Models\AttendanceLogs;
use App\Models\EmployeeSchedule;
use App\Models\PayrollPeriod;
use App\Traits\PayrollPeriodTrait;
use App\Traits\ScheduleTrait;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class AttendanceService
{
    use ScheduleTrait;
    use PayrollPeriodTrait;
    public function countAttendance($id):int {
        /*
         * This method counts the total attendances from the start to end of the payroll period.
         * */
        [$payroll_start, $payroll_end] = $this->hasPeriod();

        return AttendanceLogs::where('employee_id', $id)
            ->whereBetween('log_date', [$payroll_start, $payroll_end])
            ->count();
    }

    public function countTotalAbsences($id):int {
        /*
         * This method counts total absences from the start to end of the payroll period
         * absences from the previous period will not be counted.
         * */
        [$payroll_start, $payroll_end] = $this->hasPeriod();

        $schedule = EmployeeSchedule::where('employee_id', $id)
            ->latest()
            ->first();

        if (!$schedule) {
            return 0;
        }


        $workingDays = is_array($schedule->working_days)
            ? $schedule->working_days
            : json_decode($schedule->working_days, 0);

        $expectedWorkingDays = 0;
//        loops through the days
        foreach (CarbonPeriod::create($payroll_start, $payroll_end) as $date) {
            if (in_array($date->format('D'), $workingDays)) {
                $expectedWorkingDays++;
            }
        }
        $presentDays = AttendanceLogs::where('employee_id', $id)
            ->whereBetween('log_date', [$payroll_start, $payroll_end])
            ->selectRaw('COUNT(DISTINCT log_date) as present_days')
            ->value('present_days') ?? 0;

        if ($presentDays === 0) {
            return $expectedWorkingDays;
        }

        return max(0, $expectedWorkingDays - $presentDays);
    }

    public function computeOvertime($id):int
    {
        $todayData = $this->isScheduledToday($id);
        $schedule = $todayData['schedule'];

        if (!$todayData['isWorkingDay']) {
            return 0;
        }

        $end_time = Carbon::parse($schedule->end_time);

//        gets the latest/current day log record
        $log = AttendanceLogs::where('employee_id', $id)
            ->whereDate('log_date', today())
            ->latest('log_date')
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

        [$payroll_start, $payroll_end] = $this->hasPeriod();

        $logs = AttendanceLogs::where('employee_id', $id)
            ->whereBetween('log_date', [$payroll_start, $payroll_end])
            ->whereNotNull('clock_out_time')
            ->get();

        foreach ($logs as $log) {
            $todayData = $this->isScheduledToday($id);
            $schedule = $todayData['schedule'];

            if (!$todayData['isWorkingDay']) {
                continue;
            }

            $end_time = Carbon::parse($schedule->end_time);
            $clock_out = Carbon::parse($log->clock_out_time);

            if ($clock_out->greaterThan($end_time)) {
                $totalOvertime += $clock_out->floatDiffInHours($end_time);
            }
        }

        return (int) round(abs($totalOvertime));
    }

    public function computeLate($id): int {
        /*
         * computes the late attendance of the employee on the same log
         * */
        $todayData = $this->isScheduledToday($id);
        $schedule = $todayData['schedule'];

        if (!$todayData['isWorkingDay']) {
            return 0;
        }

        $log = AttendanceLogs::where('employee_id', $id)
            ->whereDate('created_at', today())
            ->latest('clock_in_time')
            ->first();

        if (!$log || !$log->clock_in_time) return 0;

        $clock_in = Carbon::parse($log->clock_in_time);

        $start_time = Carbon::parse($log->created_at)
            ->setTimeFromTimeString($schedule->start_time);

        if ($clock_in->lessThanOrEqualTo($start_time)) return 0;

        return abs($clock_in->diffInMinutes($start_time));
    }

    public function countLate($id): int {
        /*
         * counts all the late clock-in of the employee. example 5 late clock-in in 5 working days
         * */
        $todayData = $this->isScheduledToday($id);
        $schedule = $todayData['schedule'];

        if (!$todayData['isWorkingDay']) {
            return 0;
        }
        [$payroll_start, $payroll_end] = $this->hasPeriod();

        return AttendanceLogs::where('employee_id', $id)
            ->whereBetween('log_date', [$payroll_start, $payroll_end])
            ->whereNotNull('clock_in_time')
            ->whereTime('clock_in_time', '>', $schedule->start_time)
            ->count();
    }
    public function hasLogIn($id): bool {

        $todayData = $this->isScheduledToday($id);

        if (!$todayData['isWorkingDay']) {
            return true;
        }

        $today = now()->toDateString();

        return AttendanceLogs::where('employee_id', $id)
            ->whereDate('log_date', $today)
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
            ->whereDate('log_date', $today)
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
        [$payroll_start, $payroll_end] = $this->hasPeriod();

        return AttendanceLogs::where('employee_id', $id)
            ->whereBetween('log_date', [$payroll_start, $payroll_end])
            ->whereNotNull('clock_in_time')
            ->whereNull('clock_out_time')
            ->count();
    }

//    public function getHoursWork(): int {
//
//    }
    public function getAttendance($id)  {
        [$payroll_start, $payroll_end] = $this->hasPeriod();
        
        $logs = AttendanceLogs::where('employee_id', $id)
            ->whereBetween('log_date', [$payroll_start, $payroll_end])
            ->orderBy('log_date', 'desc')
            ->get()
            ->map(function ($log) {
                // Handle manual attendance
                if ($log->is_manual) {
                    $date = Carbon::parse($log->log_date);
                    $dayOfWeek = $date->format('l');
                    
                    // Calculate duration if time_in and time_out exist
                    $duration = 0;
                    if ($log->time_in && $log->time_out) {
                        $timeIn = Carbon::parse($log->time_in);
                        $timeOut = Carbon::parse($log->time_out);
                        $minutes = $timeIn->diffInMinutes($timeOut);
                        $duration = floor($minutes * 100 / 60) / 100;
                    }
                    
                    return [
                        'date' => $date->toDateString(),
                        'day' => $dayOfWeek,
                        'clock_in_time' => $log->time_in ?? 'N/A',
                        'clock_out_time' => $log->time_out ?? 'N/A',
                        'duration' => $duration,
                        'status' => $log->status,
                    ];
                }
                
                // Handle automated attendance
                if (!$log->clock_in_time) {
                    return null; // Skip logs without clock in time
                }

                // Parse clock in/out as Carbon instances
                $clockIn = Carbon::parse($log->clock_in_time);
                $clockOut = $log->clock_out_time ? Carbon::parse($log->clock_out_time) : null;

                // Only date
                $date = $clockIn->toDateString();

                // Day of the week (Monday, Tuesday, Wednesday…)
                $dayOfWeek = $clockIn->format('l');
                $minutes = $clockIn->diffInminutes($clockOut);
                $hours = floor($minutes * 100 / 60) / 100;
                return [
                    'date' => $date,
                    'day' => $dayOfWeek,
                    'clock_in_time' => $clockIn->toTimeString(),
                    'clock_out_time' => $clockOut?->toTimeString(),
                    'duration' => $hours,
                    'status' => $log->status,
                ];
            })
            ->filter(); // Remove null values

        $lateInMinutes = $this->computeLate($id);

        return [$logs, $lateInMinutes];
    }

    public function getWorkingHours($id): float {

        $logs = AttendanceLogs::where('employee_id', $id)->first();
        $start_time = Carbon::parse($logs->clock_in_time);
        $end_time = Carbon::parse($logs->clock_out_time);

        return abs($end_time->diffInMinutes($start_time)) / 60;
    }
}
