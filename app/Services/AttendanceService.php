<?php

namespace App\Services;

use App\Models\AttendanceLogs;
use App\Models\Employee;
use App\Models\EmployeeSchedule;
use App\Models\PayrollPeriod;
use App\Traits\PayrollPeriodTrait;
use App\Traits\ScheduleTrait;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Str;

class AttendanceService
{
    use ScheduleTrait;
    use PayrollPeriodTrait;


    private $startOfMonth;
    private $endOfMonth;
    private $currentDay;

    public function __construct() {
        $this->startOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $this->endOfMonth = Carbon::now()->endOfMonth()->toDateString();
        $this->currentDay = Carbon::now()->toDateString();
    }
    public function countAttendance($id):int {
        /*
         * This method counts the total attendances from the start to end of the month.
         * */
        return AttendanceLogs::where('employee_id', $id)
            ->whereDate('log_date', '>=', $this->startOfMonth)
            ->whereDate('log_date', '<=', $this->currentDay)
            ->where('status', 'P')
            ->count();
    }

    public function countTotalAbsences($id):int {
        /*
         * This method counts total absences from the start to end of the payroll period
         * absences from the previous period will not be counted.
         * */

        $absences = AttendanceLogs::where('employee_id', $id)
            ->whereBetween('log_date', [$this->startOfMonth, $this->endOfMonth])
            ->where('status', 'A')
            ->count();

        return $absences;
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

    public function getAttendance($id)  {

        $logs = AttendanceLogs::where('employee_id', $id)
            ->orderBy('log_date', 'desc')
            ->paginate(10);

        $lateInMinutes = $this->computeLate($id);

        return [$logs, $lateInMinutes];
    }

    public function getWorkingHours($id): float {

        $logs = AttendanceLogs::where('employee_id', $id)->first();
        $start_time = Carbon::parse($logs->clock_in_time);
        $end_time = Carbon::parse($logs->clock_out_time);

        return abs($end_time->diffInMinutes($start_time)) / 60;
    }

    public function markAbsent($id): bool {
        $schedule = EmployeeSchedule::where('employee_id', $id)
            ->whereNull('end_date')
            ->latest('start_date')
            ->first();

        if (!$schedule) return false;

        $employee = Employee::where('employee_id', $id)->first();
        if (!$employee) return false;

        // Get last attendance log
        $lastLogDate = AttendanceLogs::where('employee_id', $id)
            ->max('log_date');

        // Determine where to start checking
        $startDate = $lastLogDate
            ? Carbon::parse($lastLogDate)->addDay()
            : Carbon::parse($schedule->start_date);

        $endDate = Carbon::yesterday(); // NEVER include today

        if ($startDate->gt($endDate)) {
            return false; // Nothing to process
        }

        while ($startDate->lte($endDate)) {

            $logExists = AttendanceLogs::where('employee_id', $id)
                ->where('log_date', $startDate->toDateString())
                ->exists();

            if (!$logExists) {
                AttendanceLogs::create([
                    'log_id'      => (string) \Illuminate\Support\Str::uuid(),
                    'admin_id'    => $employee->admin_id,
                    'company_id'  => $employee->company_id,
                    'employee_id' => $id,
                    'log_date'    => $startDate->toDateString(),
                    'status'      => 'A',
                    'is_adjusted' => 0,
                    'is_manual'   => 0,
                ]);
            }

            $startDate->addDay();
        }

        return true;
    }
}
