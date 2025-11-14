<?php

namespace App\Services;

use App\Models\AttendanceAdjustment;
use App\Models\AttendanceLogs;
use App\Models\CreditAdjustment;
use App\Models\Employee;
use App\Models\LeaveAdjustment;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Support\Str;

class CreditAdjustmentService
{
    public function adjustClockIn(array $data) {

        $employee = Employee::find($data['employee_id']);

        $log = AttendanceLogs::where('employee_id', $employee->employee_id)
            ->where('log_id', $data['log_id'])
            ->first();

        $logDate = Carbon::parse($log->log_date)->format('Y-m-d');

        $clock_in = $logDate . ' ' . $data['new_clock_in'];

        AttendanceAdjustment::create([
            'attendance_adjustment_id' => Str::uuid(),
            'log_id' => $data['log_id'],
            'company_id' => $employee->company_id,
            'employee_id' => $data['employee_id'],
            'admin_id' => $employee->admin_id,
            'clock_in_time' =>$clock_in,
        ]);

        $log->update([
            'clock_in_time' => $clock_in,
            'is_adjusted' => true,
        ]);

        return [
            'attendance_adjustment_id' => Str::uuid(),
            'log_id' => $data['log_id'],
            'company_id' => $employee->company_id,
            'employee_id' => $data['employee_id'],
            'admin_id' => $employee->admin_id,
            'clock_in_time' =>$clock_in,
        ];
    }

    public function adjustClockOut(array $data) {

        $employee = Employee::find($data['employee_id']);
        $log = AttendanceLogs::where('employee_id', $employee->employee_id)
                ->where('log_id', $data['log_id'])
                ->first();

        $logDate = Carbon::parse($log->log_date)->format('Y-m-d');

        $clock_out = $logDate . ' ' . $data['new_clock_out'];

        AttendanceAdjustment::create([
            'attendance_adjustment_id' => Str::uuid(),
            'log_id' => $data['log_id'],
            'company_id' => $employee->company_id,
            'employee_id' => $data['employee_id'],
            'admin_id' => $employee->admin_id,
            'clock_out_time' => $clock_out,
        ]);

        $log->update([
            'clock_out_time' => $clock_out,
            'is_adjusted' => true,
        ]);

    }

    /*
     * for official business requests
     * */
  public function markPresent(array $data) {

        $employee = Employee::find($data['employee_id']);

        if(AttendanceLogs::where('employee_id', $employee->employee_id)->where('log_date', $data['log_date'])->exists()) {
            return null;
        }

        AttendanceLogs::create([
            'log_id' => Str::uuid(),
            'employee_id' => $data['employee_id'],
            'admin_id' => $employee->admin_id,
            'company_id' => $employee->company_id,
            'status' => 'official_business',
            'log_date' => $data['log_date'],
        ]);

        AttendanceAdjustment::create([
            'attendance_adjustment_id' => Str::uuid(),
            'log_id' => $data['log_id'],
            'company_id' => $employee->company_id,
            'employee_id' => $data['employee_id'],
            'admin_id' => $employee->admin_id,
            'status' => 'official_business',
        ]);
    }

    public function adjustLeaveDate(array $data) {

        $employee = Employee::find($data['employee_id']);

        $leave = LeaveRequest::where('employee_id', $employee->employee_id)
            ->where('leave_request_id', $data['leave_id'])
            ->first();

        $start = Carbon::parse($leave->start_date)->format('Y-m-d');
        $end = Carbon::parse($leave->end_date)->format('Y-m-d');


        $logs = AttendanceLogs::where('employee_id', $employee->employee_id)
            ->whereBetween('log_date',[$start, $end])
            ->get();

        foreach($logs as $log) {
            $log->update([
                'clock_in_time' => null,
                'clock_out_time' => null,
                'status' => 'on_leave',
                'is_adjusted' => true
            ]);

            AttendanceAdjustment::create([
                'attendance_adjustment_id' => Str::uuid(),
                'log_id' => $logs->log_id,
                'company_id' => $employee->company_id,
                'employee_id' => $data['employee_id'],
                'status' => 'on_leave',
            ]);
        }

        LeaveRequest::update([
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'is_adjusted' => true,
        ]);

        LeaveAdjustment::create([
            'leave_adjustment_id' => Str::uuid(),
            'leave_request_id' => $data['log_id'],
            'admin_id' => $employee->admin_id,
            'employee_id' => $data['employee_id'],
        ]);
      }

      public function showRequests() {
            $requests = CreditAdjustment::where('status', 'pending')->get();



      }
}
