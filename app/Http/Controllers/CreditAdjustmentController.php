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
    public function adjustClockIn(Request $request) {

        $validated = $request->validate([
           'employee_id' => 'required|exists:employees,employee_id',
            'log_id' => 'required|exists:attendance_logs,log_id',
            'new_clock_in' => 'required|date_format:H:i',
            'log_date' => 'required|date_format:Y-m-d',
        ]);

        $this->adjustmentService->adjustClockIn($validated);
    }

    public function showAdjustments() {
       $employees = Employee::whereHas('creditAdjustments', function($query) {
           $query->where('status', 'pending');
       })->with(['creditAdjustments' => function($query) {
           $query->where('status', 'pending');
       }])->get();

        return view('creditAdjustment.creditAdjustment', compact('employees'))->with(['title' => 'Credit Adjustments']);
    }
}
