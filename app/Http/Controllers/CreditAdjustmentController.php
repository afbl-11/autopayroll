<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CreditAdjustment;
use App\Models\Employee;
use App\Services\CreditAdjustmentService;
use Illuminate\Http\Request;

class CreditAdjustmentController extends Controller
{
    public function __construct(
        protected CreditAdjustmentService $adjustmentService,
    ){}

    public function showAdjustments() {
       $employees = Employee::whereHas('creditAdjustments', function($query) {
           $query->where('status', 'pending');
       })->with(['creditAdjustments' => function($query) {
           $query->where('status', 'pending');
       }])->get();

        return view('creditAdjustment.creditAdjustment', compact('employees'))->with(['title' => 'Credit Adjustments']);
    }

    public function rejectRequest(Request $request) {

        $validated = $request->validate([
            'adjustment_id' => 'required|exists:credit_adjustments,adjustment_id',
        ]);

        $this->adjustmentService->rejectRequest($validated);

       return back();


    }

    public function approveRequest(Request $request)
    {
        $validated = $request->validate([
            'adjustment_id' => 'required|exists:credit_adjustments,adjustment_id',
        ]);

        $this->adjustmentService->approveRequest($validated);

        return back();

    }

    public function alterClockIn(Request $request) {

        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,employee_id',
            'clock_in_time' => 'required|date_format:H:i',
            'affected_date' => 'required|date_format:Y-m-d',
        ]);

        $this->adjustmentService->adjustClockIn($validated);

        return back();
    }

    public function alterClockOut(Request $request) {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,employee_id',
            'clock_out_time' => 'required|date_format:H:i',
            'affected_date' => 'required|date_format:Y-m-d',
        ]);

        $this->adjustmentService->adjustClockOut($validated);

        return back();
    }

    public function alterAttendance(Request $request) {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,employee_id',
            'affected_date' => 'required|date_format:Y-m-d',
            'log_date' => 'required|date_format:Y-m-d',

        ]);

        $this->adjustmentService->markPresent($validated);

        return back();
    }

    public function alterLeave(Request $request) {
        $validated = $request->validate([
               'employee_id' => 'required|exists:employees,employee_id',
               'start_date' => 'required|date_format:Y-m-d',
               'end_date' => 'required|date_format:Y-m-d',
            'new_start_date' => 'required|date_format:Y-m-d',
            'new_end_date' => 'required|date_format:Y-m-d',
        ]);

        $this->adjustmentService->adjustLeaveDate($validated);

        return back();
    }


    public function alterClockInOut(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,employee_id',
            'clock_in_time' => 'required|date_format:H:i',
            'clock_out_time' => 'required|date_format:H:i',
            'affected_date' => 'required|date_format:Y-m-d',
        ]);

        $this->adjustmentService->adjustClockInOut($validated);

        return back();
    }
}
