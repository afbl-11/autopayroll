<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Services\AttendanceReport;
use App\Services\LeaveRequestService;
use Carbon\Carbon;

class LeaveRequestController extends Controller
{
    public function __construct(
       protected LeaveRequestService $leaveRequestService,
        protected AttendanceReport $report
    ){}

    public function showLeaveRequest($id) {

       [$employee, $leave] = $this->leaveRequestService->showRequests($id);
        $reports = $this->report->data($id);
        return view('employee.leaveRequest',compact('employee', 'leave','reports'))->with('title','Leave Request');
    }

    public function showLeaveRequestDetail($leaveId,$employeeId) {
        $employee = Employee::find($employeeId);
        $leave = LeaveRequest::find($leaveId);

        $leaveCount = $leave->count() ?: 0;

        $duration = Carbon::parse($leave->start_date)->diffInDays(Carbon::parse($leave->end_date));

        $reports = $this->report->data($employeeId);

        return view('employee.leave-detail',compact('employee', 'leave', 'leaveCount', 'duration', 'reports'))->with('title','Leave Request');
    }

    public function approveLeaveRequest($employeeId, $leaveId) {

        $this->leaveRequestService->leaveApprove($employeeId, $leaveId);

       return back()->with('success','Leave Request Approved');
    }

    public function rejectLeaveRequest($employeeId, $leaveId) {
        $this->leaveRequestService->rejectRequest($employeeId, $leaveId);

        return back()->with('success','Leave Request Rejected');
    }

    public function reviseLeaveRequest($employeeId, $leaveId) {
        $this->leaveRequestService->reviseRequest($employeeId, $leaveId);
        return back()->with('success','Leave Request Revised');
    }
}
