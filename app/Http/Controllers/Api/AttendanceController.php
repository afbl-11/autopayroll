<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AttendanceLogs;
use App\Models\Company;
use App\Services\GenerateId;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function __construct(
        private GenerateId $generateId,
    ){}
    public function logAttendance(Request $request)
    {
        $employee = $request->employee;

        if (!$employee) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $request->validate([
            'company_id' => 'required|exists:companies,company_id',
            'token' => 'required|string',
            'signature' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
//            'android_id' => 'nullable|string',
        ]);

        $company = Company::where('company_id', $request->company_id)->first();

        if (!$company || $company->qr_token !== $request->token) {
            return response()->json(['message' => 'Invalid company or QR token'], 403);
        }

        $expectedSignature = hash_hmac('sha256', $company->qr_token, env('APP_KEY'));
        if (!hash_equals($expectedSignature, $request->signature)) {
            return response()->json(['message' => 'Invalid QR signature'], 403);
        }

        if ($request->latitude && $request->longitude) {
            $distance = $this->calculateDistance(
                $company->latitude,
                $company->longitude,
                $request->latitude,
                $request->longitude
            );

            if ($distance > $company->radius) {
                return response()->json([
                    'message' => 'You are outside the allowed location range.',
                    'distance' => round($distance, 2),
                    'radius' => $company->radius
                ], 403);
            }
        }

        $attendance = AttendanceLogs::where('employee_id', $employee->employee_id)
            ->where('company_id', $company->company_id)
            ->whereDate('created_at', now()->toDateString())
            ->first();

        if ($attendance && !$attendance->clock_out_time) {
            // Employee is currently clocked in, then Clock out
            $attendance->update([
                'clock_out_time' => now(),
                'clock_out_latitude' => $request->latitude,
                'clock_out_longitude' => $request->longitude,
            ]);

            return response()->json(['message' => 'Clocked out successfully']);
        }

        AttendanceLogs::create([
            'log_id' => $this->generateId->generateId(attendanceLogs::class, 'log_id'),
            'employee_id' => $employee->employee_id,
            'company_id' => $company->company_id,
            'clock_in_time' => now(),
            'clock_in_latitude' => $request->latitude,
            'clock_in_longitude' => $request->longitude,
//            'android_id' => $request->android_id,
        ]);

        return response()->json(['message' => 'Clocked in successfully']);
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meters
        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return $earthRadius * $angle;
    }

}
