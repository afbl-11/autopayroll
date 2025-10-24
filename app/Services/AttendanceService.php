<?php

namespace App\Services;

use App\Models\AttendanceLogs;
use App\Models\EmployeeSchedule;
use App\Models\PayrollPeriod;
use Carbon\CarbonPeriod;

class AttendanceService
{
    public function countAttendance($id):int {
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

    public function hasAttendance($id): bool
    {
        $today = now()->toDateString();
        $todayDay = now()->format('D'); // "Mon", "Tue", etc....

        $schedule = EmployeeSchedule::where('employee_id', $id)
            ->latest()
            ->firstOrFail();

        $workingDays = is_array($schedule->working_days)
            ? $schedule->working_days
            : json_decode($schedule->working_days, true);

        // if today is not a working day, employee is not absent
        if (!in_array($todayDay, $workingDays)) {
            return 0;
        }

        //  if employee has attendance today
        $hasAttendance = AttendanceLogs::where('employee_id', $id)
            ->whereDate('created_at', $today)
            ->exists();

        return $hasAttendance ? 0 : 1; // 0 = present, 1 = absent
//        in the payroll service, get this function.if absent,
// make sure that there is no payroll for the day,
// but there should be a record or log
    }
}
