<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdjustmentType;
use App\Models\AttendanceLogs;
use App\Models\CreditAdjustment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CreditAdjustmentController extends Controller
{
    public function adjustmentTypes(Request $request) {

        $request->validate([
            'main_type' => 'required|in:attendance,leave,payroll,official_business'
        ]);

        $main_type = $request->input('main_type');

        $types = AdjustmentType::where('main_type', $main_type)
            ->where('is_active', true)
            ->get(['adjustment_type_id', 'code', 'label', 'description']);

        if($types->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No types found'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $types
        ]);
    }

    public function adjustmentRequest(Request $request) {

        $employee = $request->user();

        if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ]);
        }

        try {
            $validated = $request->validate([
                'employee_id' => 'required|exists:employees,employee_id',
                'main_type' => 'required|in:attendance,leave,payroll,official_business',
                'subtype' => 'required|exists:adjustment_types,code',
                'affected_date' => 'nullable|date',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'reason' => 'nullable|string',
                'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        }

        $log = AttendanceLogs::where('employee_id', $validated['employee_id'])
            ->where('log_date',  $validated['affected_date'])
            ->first();

        if($validated['main_type'] == 'attendance') {
            if(!$log){
                return response()->json([
                    'success' => false,
                    'message' => 'Log not found on requested date'
                ]);
            }
        }


        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('adjustments', 'public');
        }


        $adjustment = CreditAdjustment::create([
            'adjustment_id' => Str::uuid(),
            'admin_id' => $employee->admin_id,
            'employee_id' => $validated['employee_id'],
            'adjustment_type' => $validated['main_type'],
            'subtype' => $validated['subtype'],
            'affected_date' => $validated['affected_date'] ?? null,
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'reason' => $validated['reason'] ?? null,
            'attachment_path' => $attachmentPath,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'data' => $adjustment
        ]);
    }

    public function showAdjustmentRequest(Request $request) {

        $employee = $request->user();
        if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ]);
        }

        $adjustmentRequest = CreditAdjustment::where('employee_id', $employee->employee_id)->get();

        return response()->json([
            'success' => true,
            'data' => $adjustmentRequest
        ]);
    }

    public function trackAdjustmentRequest(Request $request) {

        $employee = $request->user();
        if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ]);
        }
        $adjustmentRequest = CreditAdjustment::where('employee_id', $employee->employee_id)
            ->whereNull('approver_id')
            ->where('status', 'pending')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $adjustmentRequest
        ]);
    }

}
