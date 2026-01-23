<?php

namespace App\Http\Controllers\EmployeeWeb;

use App\Http\Controllers\Controller;
use App\Models\CreditAdjustment;
use App\Services\EmployeeWeb\CreditAdjustmentService;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CreditAdjustmentController extends Controller
{

    public function __construct(
        protected CreditAdjustmentService $adjustment
    ){}
    public function index(Request $request) {
        $employeeId = Auth::guard('employee_web')->id();

        $pending = $this->adjustment->getPendingRequests($employeeId);
        $approved = $this->adjustment->getApprovedRequests($employeeId);
        $latestRequest = $this->adjustment->getLatestAdjustment($employeeId);

        $adjustments = $this->adjustment->getAdjustmentHistory($employeeId);

        $query = CreditAdjustment::where('employee_id', $employeeId);

        // Date filter
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        // Adjustment type
        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('adjustment_type', $request->type);
        }

        // Status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $adjustments = $query->latest()->paginate(3)->withQueryString();

        return view('employee_web.creditAdjustmentModule.creditAdjustmentModule', compact('pending', 'adjustments','latestRequest', 'approved'));
    }

    protected array $typeMap = [
        'Attendance' => 'attendance',
        'Leave' => 'leave',
        'Payroll' => 'payroll',
        'Official Business' => 'official_business',
    ];

    public function sendAdjustmentRequest(Request $request) {
        $request->validate([
            'adjustment_type' => 'required|string',
            'adjustment_sub_type' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'reason' => 'required|string|max:1000',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $dbAdjustmentType = $this->typeMap[$request->adjustment_type];

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('adjustments', 'public');
        }

        $employee = Auth::guard('employee_web')->user();
        $adjustment = CreditAdjustment::create([
            'adjustment_id' => Str::uuid()->toString(),
            'admin_id' => $employee->admin_id,
            'employee_id' => $employee->employee_id, // or however you identify employee
            'adjustment_type' => $dbAdjustmentType,
            'subtype' => $request->adjustment_sub_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'attachment_path' => $attachmentPath,
            'status' => 'Pending', // default
        ]);

        return redirect()->back()->with('success', 'Adjustment request submitted successfully.');
    }
}
