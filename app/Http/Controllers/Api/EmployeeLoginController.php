<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EmployeeLoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string',
            'password' => 'required|string',
        ]);

        $identifier = $request->identifier;

        $employee = Employee::where('username', $identifier)
            ->orWhere('email', $identifier)
            ->first();

        if (!$employee || !Hash::check($request->password, $employee->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = Str::random(60);
        $employee->api_token = hash('sha256', $token);
        $employee->save();

        return response()->json([
            'employee_id' => $employee->employee_id,
            'token' => $token,
        ]);
    }
}
