<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AttendanceLogs;
use App\Models\EmployeeSchedule;
use App\Models\LeaveCredits;
use App\Services\AttendanceService;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function __construct(
        protected AttendanceService $attendanceService,
    ){}
    public function getTotalWorkedHours(Request $request) {
        $employee = $request->user();

        if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'Employee not found',
            ],401);
        }

        $log = AttendanceLogs::where('employee_id', $employee->employee_id)
            ->whereNotNull('clock_out_time')
            ->latest('log_date')
            ->first();

        if(!$log) {
            return response()->json([
                'success' => false,
                'message' => 'Log not found',
            ], 404);
        }
        $clock_in = Carbon::parse($log->clock_in_time);
        $clock_out = Carbon::parse($log->clock_out_time);

        $total = abs($clock_in->diffInMinutes($clock_out) / 60);  ;

        return response()->json([
            'success' => true,
            'total' => $total,
        ], 200);

    }

    public function getLeaveCredits(Request $request) {
        $employee = $request->user();

        if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'Employee not logged in'
            ], 401);
        }
        $credits = LeaveCredits::where('employee_id', $employee->employee_id)
            ->first();

        return response()->json([
            'success' => true,
            'data' => $credits->credit_days
        ],200);
    }

    public function getAbsences(Request $request) {
        $employee = $request->user();
        if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'Employee not logged in'
            ],401);
        }

        return response()->json([
            'success' => true,
            'data' => $this->attendanceService->countTotalAbsences($employee->employee_id)
        ],200);
    }

    public function workingHours($employee)
    {
        $schedule = EmployeeSchedule::where('employee_id', $employee->employee_id)
            ->whereNull('end_date')
            ->first();

        if (!$schedule) {
            return response()->json([
                'success' => false,
                'message' => 'Schedule not found',
            ], 404);
        }

        return [
            'timeIn'  => Carbon::parse($schedule->start_time),
            'timeOut' => Carbon::parse($schedule->end_time),
        ];
    }
    public function getAttendanceSummary(Request $request)
    {
        $employee = $request->user();


        $log = AttendanceLogs::where('employee_id', $employee->employee_id)
            ->latest('log_date')
            ->first();

        if (!$log) {
            return response()->json([
                'success' => false,
                'message' => 'Log not found',
            ], 404);
        }

        if (!$log->time_in || !$log->time_out) {
            return response()->json([
                'success' => false,
                'message' => 'Log time-in/out not found',
            ], 404);
        }

        $timeIn  = Carbon::parse($log->time_in);
        $timeOut = Carbon::parse($log->time_out);

        $hoursWorked = round($timeIn->floatDiffInHours($timeOut), 1);

        $sched = $this->workingHours($employee);
        if (!$sched) {
            return response()->json([
                'success' => false,
                'message' => 'Log not found',
            ], 404);
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

        return response()->json([
            'hoursWorked' => $hoursWorked,
            'overtime'    => $overtime,
            'late'        => $late,
        ],200);
    }
}
