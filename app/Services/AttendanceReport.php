<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\AttendanceLogs;
use App\Models\Employee;
use Carbon\Carbon;

class AttendanceReport
{
    public function __construct(
        protected AttendanceService $attendanceService,
    ){}

    public function data($id){ //todo:this one
        $employee = Employee::with('attendanceLogs')->find($id);

        $daysActive = $this->attendanceService->countAttendance($id);
        $absences = $this->attendanceService->countTotalAbsences($id);
        $overtime = $this->attendanceService->computeOvertime($id);
        $creditDays = $employee->getCreditDays()  ?: 0;
        $hasLogIn = $this->attendanceService->hasLogIn($id);
        $totalOvertime = $this->attendanceService->totalOvertime($id);
        $totalNoClockOut = $this->attendanceService->totalNoClockOut($id);
        $noClock = $this->attendanceService->noClockOut($id);
        $countLate = $this->attendanceService->countLate($id);
        [$logs, $late] = $this->attendanceService->getAttendance($id);

        $sched = Employee::with(['employeeSchedule' => function ($query) {
            $query->whereNull('end_date');
        }])->find($id);

        $start_time =  $sched->employeeSchedule->first()->start_time;
        $end_time =  $sched->employeeSchedule->first()->end_time;

        $log = AttendanceLogs::where('employee_id',$id)->first();

        if($log) {
            $timeline = $this->generateTimeline($start_time, $end_time,$log->clock_in_time,$log->clock_out_time);
        } else {
            $timeline = [
                'labels' => [],
                'startPercent' => null,
                'workedPercent' => null,
            ];
        }
//

        return [
            'employee' => $employee,
            'daysActive' => $daysActive,
            'absences' => $absences,
            'overtime' => $overtime,
            'hasLogIn' => $hasLogIn,
            'totalOvertime' => $totalOvertime,
            'totalNoClockOut' => $totalNoClockOut,
            'noClock' => $noClock,
            'countLate' => $countLate,
            'creditDays' => $creditDays,
            'timeline' => [
                'startPercent' => $timeline['startPercent'],
                'workedPercent' => $timeline['workedPercent'],
                'labels' => $timeline['labels'],
            ],
            'attendance' =>
                [
                    'logs' => $logs,
                    'late' => $late
                ],
        ];
    }

    public function generateTimeline($scheduleStart, $scheduleEnd, $clockIn, $clockOut)
    {
        // Convert to Carbon
        $timelineStart = Carbon::parse($scheduleStart);
        $timelineEnd   = Carbon::parse($scheduleEnd);
        $totalMinutes  = $timelineEnd->diffInMinutes($timelineStart);

        $startPercent = null;
        $workedPercent = null;

        // ---- Generate timeline labels (every 2 hours) ----
        $labels = [];
        $pointer = $timelineStart->copy();

        while ($pointer <= $timelineEnd) {
            $labels[] = $pointer->format('g A');
            $pointer->addHours(2);
        }

        // ---- If there is no clock in/out, just return labels ----
        if (!$clockIn || !$clockOut) {
            return [
                'labels' => $labels,
                'startPercent' => null,
                'workedPercent' => null,
            ];
        }

        // ---- Calculate bar percentages ----
        $clockInC  = Carbon::parse($clockIn);
        $clockOutC = Carbon::parse($clockOut);

        // Clamp
        if ($clockInC->lessThan($timelineStart)) $clockInC = $timelineStart;
        if ($clockOutC->greaterThan($timelineEnd)) $clockOutC = $timelineEnd;

        // Percentages
        $startPercent = ($clockInC->diffInMinutes($timelineStart)) / $totalMinutes * 100;
        $endPercent   = ($clockOutC->diffInMinutes($timelineStart)) / $totalMinutes * 100;

        return [
            'labels'       => $labels,
            'startPercent' => $startPercent,
            'workedPercent'=> $endPercent - $startPercent,
        ];
    }
}

