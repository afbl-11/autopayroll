<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
{
    public function resetPassword(Request $request)
    {
        $employee = $request->user();

        if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'Employee not found or not authenticated'
            ], 401);
        }

        try {
            $request->validate([
                'password' => 'required|min:8',
                'new_password' => 'required|min:8|confirmed',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        }

        if (!Hash::check($request->password, $employee->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect'
            ], 400);
        }

        $employee->password = Hash::make($request->new_password);
        $employee->save();

        return response()->json([
            'success' => true,
            'message' => 'Password reset successfully'
        ]);
    }
}
