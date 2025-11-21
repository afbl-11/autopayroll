<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\Employee;
use App\Models\LeaveCredits;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LeaveRequestService
{
    public function leaveApprove($employeeId, $leaveId)
    {

        $employee = Employee::find($employeeId);
        $leave = LeaveRequest::find($leaveId);

        $leaveDuration = Carbon::parse($leave->start_date)->diffInDays(Carbon::parse($leave->end_date));
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
/*
 * this method gets only requests to specific employees
 * */
    public function showRequests($id) {
        $employee = Employee::find($id);
        $leave = LeaveRequest::where('employee_id', $id)
            ->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END")
            ->orderBy('created_at', 'desc')
            ->get();

        return [$employee, $leave];
    }
    /*
     * gets all requests. used in the dashboard
     * */
//    public function showAllLeaveRequests() {
//        $adminId = auth('admin')->id();
//
//        // Subquery: latest leave_request_id
//        $latestLeaveIdSub = \DB::table('leave_request')
//            ->select('leave_request_id')
//            ->whereColumn('leave_request.employee_id', 'employees.employee_id')
//            ->whereColumn('leave_request.admin_id', 'employees.admin_id')
//            ->orderBy('leave_request.created_at', 'desc')
//            ->limit(1);
//
//        // Subquery: latest status
//        $latestStatusSub = \DB::table('leave_request')
//            ->select('status')
//            ->whereColumn('leave_request.employee_id', 'employees.employee_id')
//            ->whereColumn('leave_request.admin_id', 'employees.admin_id')
//            ->orderBy('leave_request.created_at', 'desc')
//            ->limit(1);
//
//        // Subquery: latest created_at
//        $latestCreatedSub = \DB::table('leave_request')
//            ->select('created_at')
//            ->whereColumn('leave_request.employee_id', 'employees.employee_id')
//            ->whereColumn('leave_request.admin_id', 'employees.admin_id')
//            ->orderBy('leave_request.created_at', 'desc')
//            ->limit(1);
//
//        // Main Employee Query
//        $employees = Employee::query()
//            ->where('employees.admin_id', $adminId)
//            ->addSelect([
//                'latest_leave_request_id' => $latestLeaveIdSub,
//                'latest_status'           => $latestStatusSub,
//                'latest_created_at'       => $latestCreatedSub,
//            ])
//            ->orderByRaw("CASE WHEN latest_status = 'pending' THEN 0 ELSE 1 END")
//            ->orderBy('latest_created_at', 'desc')
//            ->with('leaves')
//            ->get();
//
//
//
//
//        return [$employees];
//    }

    public function showAllLeaveRequests(): Collection {
       $adminId = Auth::guard('admin')->id();

       return LeaveRequest::where('admin_id', $adminId)
           ->where('status', "pending")->get();

    }
}
