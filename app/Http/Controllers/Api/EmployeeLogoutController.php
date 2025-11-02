<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeLogoutController extends Controller
{
    public function logout(Request $request, $id)
    {
        $header = $request->header('Authorization');

        if (!$header || !str_starts_with($header, 'Bearer ')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $token = substr($header, 7);

        $employee = Employee::where('employee_id', $id)
            ->where('api_token', hash('sha256', $token))
            ->first();

        if (!$employee) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $employee->api_token = null;
        $employee->save();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

}
