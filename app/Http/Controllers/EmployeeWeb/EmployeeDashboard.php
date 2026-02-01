<?php

namespace App\Http\Controllers\EmployeeWeb;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\AttendanceLogs;
use App\Models\EmployeeSchedule;
use App\Models\Payslip;
use App\Services\AttendanceService;
use Auth;
use Carbon\Carbon;

class EmployeeDashboard extends Controller
{

    public function __construct(
        protected AttendanceService $logsService,
    ){}
    public function workingHours()
    {
        $employee = Auth::guard('employee_web')->user();

        $schedule = EmployeeSchedule::where('employee_id', $employee->employee_id)
            ->whereNull('end_date')
            ->first();

        if (!$schedule) {
            return null;
        }

        return [
            'timeIn'  => Carbon::parse($schedule->start_time),
            'timeOut' => Carbon::parse($schedule->end_time),
        ];
    }


    public function getAttendanceSummary()
    {
        $employee = Auth::guard('employee_web')->user();

        $log = AttendanceLogs::where('employee_id', $employee->employee_id)
            ->latest('log_date')
            ->first();

        if (!$log) {
            return null;
        }

        if (!$log->time_in || !$log->time_out) {
            return null;
        }

        $timeIn  = Carbon::parse($log->time_in);
        $timeOut = Carbon::parse($log->time_out);

        $hoursWorked = round($timeIn->floatDiffInHours($timeOut), 1);

        $sched = $this->workingHours();
        if (!$sched) {
            return null;
        }

        // OVERTIME
        $overtime = 0;
        if ($timeOut->greaterThan($sched['timeOut'])) {
            $overtime = round($sched['timeOut']->floatDiffInHours($timeOut), 1);
        }

        // LATE (minutes)
        $late = 0;
        if ($timeIn->greaterThan($sched['timeIn'])) {
            $late = $sched['timeIn']->diffInMinutes($timeIn);
        }

        return [
            'hoursWorked' => $hoursWorked,
            'overtime'    => $overtime,
            'late'        => $late,
        ];
    }


    public function getAttendance() {
        $employee = Auth::guard('employee_web')->user();

        $log = AttendanceLogs::where('employee_id', $employee->employee_id)
            ->latest('log_date')
            ->take(3)
            ->get();

        return $log;
    }

    public function getAnnouncement($adminId) {
        $post = Announcement::where('admin_id', $adminId)
            ->latest()
            ->take(2)
            ->get();

        if(!$post) {
            return 'no announcement';
        }

        return $post;
    }


    public function index()
    {
        $employee = Auth::guard('employee_web')->user();
        $company  = $employee->company;

        $sched = $this->workingHours();

        $timeIn  = $sched ? $sched['timeIn']->format('g:i') : 'N/A';
        $timeOut = $sched ? $sched['timeOut']->format('g:i') : 'N/A';

        $attendanceSummary = $this->getAttendanceSummary();
        $leaveBalance = $employee->getCreditDays();
        $absences = $this->logsService->countTotalAbsences($employee->employee_id);
        $attendance = $this->getAttendance();

        $announcement = $this->getAnnouncement($employee->admin_id);

        $payslips = Payslip::where('employee_id', $employee->employee_id)
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->orderByDesc('period_start')
            ->first();

        return view('employee_web.dashboard', compact(
            'employee',
            'attendance',
            'absences',
            'leaveBalance',
            'attendanceSummary',
            'company',
            'timeIn',
            'timeOut',
            'announcement',
            'payslips',
        ));
    }

}
