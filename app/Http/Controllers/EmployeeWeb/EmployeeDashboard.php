<?php

namespace App\Http\Controllers\EmployeeWeb;

use App\Http\Controllers\Controller;
use App\Models\AttendanceLogs;
use App\Models\EmployeeSchedule;
use App\Services\AttendanceService;
use Auth;
use Carbon\Carbon;

class EmployeeDashboard extends Controller
{

    public function __construct(
        protected AttendanceService $logsService,
    ){}
    public function workingHours() {
        $employee = Auth::guard('employee_web')->user();

        $schedule = employeeSchedule::where('employee_id', $employee->employee_id)
            ->whereNull('end_date')
            ->first();

        if(!$schedule) {
            return [
                'timeIn' => false,
                'timeOut' => false,
            ];
        }

        $timeIn = Carbon::parse($schedule->start_time);
        $timeOut = Carbon::parse($schedule->end_time);

        return  [
            'timeIn' => $timeIn,
            'timeOut' => $timeOut,
        ];
    }

    public function getAttendanceSummary() {
        $employee = Auth::guard('employee_web')->user();

        $log = AttendanceLogs::where('employee_id', $employee->employee_id)
            ->latest('log_date')
            ->first();

        if(!$log) {
            return false;
        }

        $timeIn = Carbon::parse($log['clock_in_time']);
        $timeOut = Carbon::parse($log['clock_out_time']);

        $temp_hours = abs($timeIn->diffInHours($timeOut));
        $hoursWorked =  round($temp_hours, 1);

        //overtime hours
        $sched = $this->workingHours();

        $overtime = 0;

        if($timeOut > $sched['timeOut']) {
            $overtime = abs($timeOut->diffInHours($sched['timeOut']));
        }

        //late
        $late = 0;
        if($timeIn > $sched['timeIn']) {
            $late = abs($timeIn->diffInMinutes($sched['timeIn']));
        }

        return [
            'hoursWorked' => $hoursWorked,
            'overtime' => $overtime,
            'late' => $late,
        ];
    }

    public function getAttendance() {
        $employee = Auth::guard('employee_web')->user();

        $log = AttendanceLogs::where('employee_id', $employee->employee_id)
            ->latest()
            ->take(3)
            ->get()
            ->reverse();

        return $log;
    }


    public function index() {
        $employee = Auth::guard('employee_web')->user();

        $sched = $this->workingHours();
        $timeIn = Carbon::parse($sched['timeIn'])->format('g:i');
        $timeOut = Carbon::parse($sched['timeOut'])->format('g:i');

        $company = $employee->company;

        $attendanceSummary = $this->getAttendanceSummary();
        $leaveBalance = $employee->getCreditDays();
        $absences = $this->logsService->countTotalAbsences($employee->employee_id);
        $attendance = $this->getAttendance();

        return view('employee_web.dashboard', compact('employee','attendance','absences','leaveBalance', 'attendanceSummary','company', 'timeIn', 'timeOut') );
    }
}
