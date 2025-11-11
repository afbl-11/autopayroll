<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\LeaveCredits;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Support\Str;

class LeaveRequestService
{
    public function leaveApprove($employeeId, $leaveId)
    {

        $employee = Employee::find($employeeId);
        $leave = LeaveRequest::find($leaveId);

        $leaveDuration = Carbon::parse($leave->start_date)->diffInDays(Carbon::parse($leave->end_date)) + 1;
        $creditUsed = $leaveDuration;

        $leaveCredit = LeaveCredits::where('employee_id', $employeeId)->first();

        if ($leaveCredit) {
            if($leaveCredit->is_used) {
                return back()->with(['message' => 'Leave credits already used']);
            }

            $newLeaveCredit = $leaveCredit->credit_days - $creditUsed;
            $newUsedDays = $leaveCredit->used_days + $creditUsed;

            $isUsed = $newLeaveCredit <= 0 ? 1 : 0;

            $leaveCredit->update([
                'credit_days' => $newLeaveCredit,
                'used_days' => $newUsedDays,
                'is_used' => $isUsed,
                'approved_date' => Carbon::now()->toDateTimeString(),
            ]);
//        todo:set a default leave credits when the user is created
        }

        $leave->update([
            'approver_id' => $employee->admin_id,
            'status' => "approved",
        ]);

        return back()->with(['message' => 'Leave approved successfully']);
    }


    public function rejectRequest($employeeId, $leaveId){

        $employee = Employee::find($employeeId);

        $leave = LeaveRequest::find($leaveId);

        $leave->update([
            'status' => "rejected",
            'approver_id' => $employee->admin_id,
        ]);
        return back()->with(['message' => 'Leave rejected successfully']);
    }

    public function reviseRequest($employeeId, $leaveId){
        $employee = Employee::find($employeeId);
        $leave = LeaveRequest::find($leaveId);

        $leave->update([
            'status' => "need revision",
            'approver_id' => $employee->admin_id,
        ]);
    }
}
