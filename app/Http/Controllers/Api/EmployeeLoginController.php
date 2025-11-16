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
            'identifier' => 'required|string',
            'password' => 'required|string',
            'android_id' => 'required|string',
        ]);

        $identifier = $request->identifier;

        $employee = Employee::where('username', $identifier)
            ->orWhere('email', $identifier)
            ->first();

        $androidUsedByOther = Employee::where('android_id', $request->android_id)
            ->where('employee_id', '!=', $employee->employee_id)
            ->exists();

        if ($androidUsedByOther) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot log in with this device. It is already linked to another employee.',
            ], 401);
        }

        $deviceRestriction = Employee::where('employee_id', $employee->employee_id)
            ->whereNotNull('android_id')
            ->where('android_id', '!=', $request->android_id)
            ->exists();

        if($deviceRestriction) {
            return response()->json([
                'success' => false,
                'message' => 'Account is currently logged in another device.'
            ],401);
        }

        if (!$employee || !Hash::check($request->password, $employee->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $employee->createToken('API Token')->plainTextToken;

        $employee['android_id'] = $request->android_id;
        $employee->save();

        return response()->json([
            'employee_id' => $employee->employee_id,
            'token' => $token,
        ]);
    }
}
