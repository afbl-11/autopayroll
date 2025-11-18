<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\Employee;

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
        $creditDays = $employee->getCreditDays();
        $hasLogIn = $this->attendanceService->hasLogIn($id);
        $totalOvertime = $this->attendanceService->totalOvertime($id);
        $totalNoClockOut = $this->attendanceService->totalNoClockOut($id);
        $noClock = $this->attendanceService->noClockOut($id);
        $countLate = $this->attendanceService->countLate($id);
        [$logs, $late] = $this->attendanceService->getAttendance($id);


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
            'attendance' =>
                [
                    'logs' => $logs,
                    'late' => $late
                ],
        ];
    }
}

