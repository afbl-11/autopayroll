<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeLoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);


        $employee = Employee::where('email', $request->email)
            ->orWhere('username', $request->email)
            ->first();

        if (!$employee || !Hash::check($request->password, $employee->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }


        $token = $employee->api_token;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,

            'employee' => $employee->makeHidden(['password', 'api_token', 'created_at', 'updated_at']),
        ]);
    }
}
