<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payslip;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function showPayroll(Request $request) {

        $employee = $request->user();

        if (!$employee) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $payroll = Payslip::where('employee_id', $employee->employee_id)->get();

        if ($payroll->isEmpty()) {
            return response()->json([
                'message' => 'no record',
                'data' => $payroll
            ], 200);
        }

        return response()->json([
            'data' => $payroll,
            'success' => true,
        ],200);
    }
}
