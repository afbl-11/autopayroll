<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EmployeeSchedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function getSchedule(Request $request) {
        $employee = $request->user();

        if(!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'Employee not found',
            ], 401);
        }

        $sched = EmployeeSchedule::where('employee_id', $employee->employee_id)
            ->whereNull('end_date')
            ->first();

        if(!$sched) {
            return response()->json([
                'success' => false,
                'message' => 'Schedule not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'schedule' => $sched,
        ], 200);
    }
}
