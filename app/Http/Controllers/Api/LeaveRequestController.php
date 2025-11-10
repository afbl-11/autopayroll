<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LeaveRequestController extends Controller
{
    public function leaveRequest(Request $request){

        $employee = $request->user();

        if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'Employee not found or not authenticated'
            ], 401);
        }

        try {
            $request->validate([
                'start_date' => 'required|date|before_or_equal:end_date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'reason' => 'required|string|max:255',
                'leave_type' => 'required|in:sick,vacation,maternity,bereavement,emergency',
                'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        }

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('leave_attachments');
        }
        $admin = Admin::first();

        $leave = $employee->leaves()->create([
            'leave_request_id' => Str::uuid(),
            'admin_id' => $admin->admin_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'leave_type' => $request->leave_type,
            'supporting_doc' => $attachmentPath,
            'status' => 'pending',
            'submission_date' =>Carbon::now()->toDateString(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Leave request submitted successfully',
            'leave' => $leave
        ]);
    }
}
