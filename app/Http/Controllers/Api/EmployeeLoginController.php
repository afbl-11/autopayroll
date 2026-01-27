<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeDevice;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeLoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string',
            'password' => 'required|string',
            'fcm_token' => 'required|string',
        ]);

        $identifier = $request->identifier;

        $employee = Employee::where('username', $identifier)
            ->orWhere('email', $identifier)
            ->first();

        if (!$employee || !Hash::check($request->password, $employee->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $employee->createToken('API Token')->plainTextToken;

        $employee->save();

        EmployeeDevice::updateOrCreate(
            ['fcm_token' => $request->fcm_token],
            [
                'employee_id' => $employee->employee_id,
                'platform' => 'android',
            ]
        );

        return response()->json([
            'employee_id' => $employee->employee_id,
            'token' => $token,
            'fcm_token' => $request->fcm_token,
        ]);
    }
}
