<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AttendanceLogs;
use App\Models\LeaveCredits;
use App\Services\AttendanceService;
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
}
