<?php

namespace App\Http\Controllers\EmployeeWeb;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Services\EmployeeWeb\LeaveDashboardService;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Str;

class LeaveDashboardController extends Controller
{

    public function __construct(
        protected LeaveDashboardService $leaveService
    ) {}

    public function index(Request $request) {
        $employee = Auth::guard('employee_web')->user();

        if (! $employee) {
            abort(403);
        }

        $log = $this->leaveService->getLeaveBalances($employee->employee_id);

        $query = LeaveRequest::where('employee_id', $employee->employee_id);

        if ($request->filled('from')) {
            $query->whereDate('start_date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('end_date', '<=', $request->to);
        }

        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('leave_type', $request->type);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(3)->withQueryString();

        // the approved/pending for the calendar
        $approved = LeaveRequest::where('employee_id', $employee->employee_id)
            ->where('status', 'approved')->get();
        $pending = LeaveRequest::where('employee_id', $employee->employee_id)
            ->where('status', 'pending')->get();

        return view('employee_web.leaveModule.leaveModule', compact('log', 'requests', 'approved', 'pending'));
    }

    public function sendLeaveRequest(Request $request) {
        $employee = Auth::guard('employee_web')->user();

        if (! $employee) {
            abort(403);
        }

       $validated =  $request->validate([
           'start_date' => 'required|date_format:Y-m-d|before_or_equal:end_date',
           'end_date'   => 'required|date_format:Y-m-d|after_or_equal:start_date',
           'reason' => 'required|string|max:255',
           'leave_type' => 'required|in:Sick,Vacation,Maternity,Bereavement,Paternity',
           'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('attachment')) {
            $validated['attachment'] = $request->file('attachment')->store('leave_attachments', 'public');
        }

        LeaveRequest::create([
            'leave_request_id' => Str::uuid(),
            'admin_id' => $employee->admin_id,
            'employee_id' => $employee->employee_id,
            'leave_type' => $request->leave_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'supporting_doc' => $validated['attachment'] ?? null,
            'submission_date' => Carbon::now()->toDateTimeString(),
        ]);

        return back()->with('success', 'Leave request send successfully.');
    }

}
