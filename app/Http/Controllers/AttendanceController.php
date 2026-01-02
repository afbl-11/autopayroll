<?php

namespace App\Http\Controllers;

use App\Services\AttendanceReport;
use App\Models\AttendanceLogs;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AttendanceController extends Controller
{
    public function __construct(
        protected AttendanceReport $report,
    ){}

    public function showAttendance($id)
    {
        return view(
            'employee.employee-attendance',
            $this->report->data($id)
        )->with('title','Employee Attendance');
    }


    // Manual Attendance Controller added here:

    public function employees($companyId)
    {
        $employees = Employee::where('company_id', $companyId)
            ->get()
            ->map(fn ($e) => [
                'employee_id'   => $e->employee_id,
                'employee_name' => trim($e->first_name.' '.$e->last_name),
            ]);

        return response()->json(['data' => $employees]);
    }

    public function attendanceDates($companyId)
    {
        $dates = AttendanceLogs::where('company_id', $companyId)
            ->selectRaw('DISTINCT log_date as date')
            ->orderBy('date')
            ->get();

        return response()->json(['data' => $dates]);
    }

    public function attendanceByDate($companyId, $date)
    {
        $logs = AttendanceLogs::where([
            'company_id' => $companyId,
            'log_date'   => $date,
        ])->get();

        $result = [];

        foreach ($logs as $log) {
            $result[$log->employee_id] = [
                'status'   => $log->status,
                'time_in'  => $log->clock_in_time,
                'time_out' => $log->clock_out_time,
            ];
        }

        return response()->json(['data' => $result]);
    }

    public function bulkSave(Request $request)
    {
        $request->validate([
            'company_id' => 'required',
            'date'       => 'required|date',
            'records'    => 'required|array',
        ]);

        $statusMap = [
            'P'   => 'present',
            'A'   => 'absent',
            'LT'  => 'on_leave',
            'OB'  => 'official_business',
            'DO'  => 'day_off',
            'R'   => 'regular_holiday',
            'S'   => 'special_holiday',
            'L'   => 'legal_holiday',
            'CO'  => 'change_day_off',
            'CDO' => 'cancel_day_off',
        ];

        DB::beginTransaction();

        try {
            foreach ($request->records as $employeeId => $data) {

                AttendanceLogs::updateOrCreate(
                    [
                        'admin_id'    => auth('admin')->id(),
                        'company_id'  => $request->company_id,
                        'employee_id' => $employeeId,
                        'log_date'    => $request->date,
                    ],
                    [
                        'log_id'         => Str::uuid()->toString(),
                        'status'         => $statusMap[$data['status']] ?? 'absent',
                        'clock_in_time'  => $data['time_in'] ?: null,
                        'clock_out_time' => $data['time_out'] ?: null,
                        'is_adjusted'    => 1,
                    ]
                );
            }

            DB::commit();

            return response()->json([
                'message' => 'Attendance saved successfully'
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function createDate(Request $request)
    {
        $request->validate([
            'company_id' => 'required',
            'date'       => 'required|date',
        ]);

        $exists = AttendanceLogs::where([
            'company_id' => $request->company_id,
            'log_date'   => $request->date,
        ])->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Date already exists'
            ], 422);
        }

        return response()->json(['message' => 'Date created']);
    }

    public function deleteDate(Request $request)
    {
        $request->validate([
            'company_id' => 'required',
            'date'       => 'required|date',
        ]);

        AttendanceLogs::where('company_id', $request->company_id)
            ->where('log_date', $request->date)
            ->delete();

        return response()->json(['message' => 'Date deleted successfully']);
    }
}