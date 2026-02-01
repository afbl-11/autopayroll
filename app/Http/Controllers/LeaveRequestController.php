<?php

namespace App\Http\Controllers;

use App\Enums\NotificationType;
use App\Http\Controllers\Controller;
use App\Mail\LeaveMail;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Services\AttendanceReport;
use App\Services\LeaveRequestService;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class LeaveRequestController extends Controller
{
    public function __construct(
        protected LeaveRequestService $leaveRequestService,
        protected AttendanceReport $report,
        protected NotificationService $notificationService,
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

        $this->notificationService->notifyEmployees(
            [$employeeId],
            'Leave Approved',
            'Your leave request has been approved.',
            [
                'type' => NotificationType::LEAVE_APPROVED,
                'leave_id' => $leaveId,
            ]
        );


        $leave = LeaveRequest::where('leave_request_id', $leaveId)->first();
        $employee = Employee::where('employee_id', $leave->employee_id)->first();

        Mail::to($employee->email)->send(
            new LeaveMail($leave)
        );
        return back()->with('success','Leave Request Approved');
    }

    public function rejectLeaveRequest($employeeId, $leaveId) {
        $this->leaveRequestService->rejectRequest($employeeId, $leaveId);


        $leave = LeaveRequest::where('leave_request_id', $leaveId)->first();
        $employee = Employee::where('employee_id', $leave->employee_id)->first();

        Mail::to($employee->email)->send(
            new LeaveMail($leave)
        );

        $this->notificationService->notifyEmployees(
            [$employeeId],
            'Leave Rejected',
            'Your leave request has been rejected.',
            [
                'type' => NotificationType::LEAVE_REJECTED,
                'leave_id' => $leaveId,
            ]
        );

        return back()->with('success','Leave Request Rejected');
    }

    public function reviseLeaveRequest($employeeId, $leaveId) {
        $this->leaveRequestService->reviseRequest($employeeId, $leaveId);

        $this->notificationService->notifyEmployees(
            [$employeeId],
            'Leave Request Needs Revision',
            'Your leave request has been rejected. Please revise your request.',
            [
                'type' => NotificationType::LEAVE_REVISION,
                'leave_id' => $leaveId,
            ]
        );

        return back()->with('success','Leave Request Revised');
    }
}
