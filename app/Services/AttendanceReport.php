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

    public function data($id){
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
        [$paginator, $late] = $this->attendanceService->getAttendance($id);

        $sched = Employee::with(['employeeSchedule' => function ($query) {
            $query->whereNull('end_date');
        }])->find($id);

        $firstSchedule = $sched->employeeSchedule->first();
        $start_time = $firstSchedule?->start_time;
        $end_time = $firstSchedule?->end_time;

        $logs = $paginator->through(function($logItem) use ($start_time, $end_time) {
            // Generate timeline (you already have this)
            $timeline = $this->generateTimeline(
                $start_time,
                $end_time,
                $logItem->time_in,
                $logItem->time_out
            );

            $logItem->timeline = $timeline;

            // Calculate work hours
            if ($logItem->time_in && $logItem->time_out) {
                $timeIn = Carbon::parse($logItem->time_in);
                $timeOut = Carbon::parse($logItem->time_out);

                $diffInSeconds = $timeIn->diffInSeconds($timeOut);
                $diffInHours = $diffInSeconds / 3600; // convert seconds to hours

                $logItem->work_hours = abs(round($diffInHours, 2)); // rounded to 2 decimal places
            } else {
                $logItem->work_hours = 0;
            }

            return $logItem;
        });

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
//            'timeline' => [
//                'startPercent' => $timeline['startPercent'],
//                'workedPercent' => $timeline['workedPercent'],
//                'labels' => $timeline['labels'],
//            ],
            'attendance' =>
                [
                    'logs' => $logs,
                    'late' => $late
                ],
        ];
    }

    public function generateTimeline($scheduleStart, $scheduleEnd, $clockIn, $clockOut)
    {
        $timelineStart = Carbon::parse($scheduleStart);
        $timelineEnd   = Carbon::parse($scheduleEnd);
        $totalMinutes  = $timelineEnd->diffInMinutes($timelineStart);

        $startPercent = null;
        $workedPercent = null;

        $labels = [];
        $pointer = $timelineStart->copy();

        while ($pointer <= $timelineEnd) {
            $labels[] = $pointer->format('g A');
            $pointer->addHours(2);
        }

        if (!$clockIn || !$clockOut) {
            return [
                'labels' => $labels,
                'startPercent' => null,
                'workedPercent' => null,
            ];
        }


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

