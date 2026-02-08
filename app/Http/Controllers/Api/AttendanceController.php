<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Employee;
use App\Services\Payroll\CreateDailyPayroll;
use App\Traits\ScheduleTrait;
use Illuminate\Http\Request;
use App\Models\AttendanceLogs;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    use ScheduleTrait;
    public function __construct(
        protected CreateDailyPayroll $dailyPayroll,
    ){}
    /**
     * Handle employee clock-in
     */
    public function clockIn(Request $request)
    {
        $employee = $request->user();

        if(!$employee){
            return response()->json([
                'success' => false,
                'message' => 'Employee not found'
            ]);
        }

        $validated = $request->validate([
            'company_id' => 'required|string',
            'token' => 'required|string',
            'signature' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'android_id' => 'required|string',
        ]);

        /*
         * validate if payload: company id, signature, and token matches the data with the company
         * */

        $company = Company::where('company_id', $validated['company_id'])->first();

        if(!$company || $company->qr_token !== $validated['token']) {
            return response()->json(['message' => 'Invalid or expired QR code.'], 400);
        }

        $expectedSignature = hash_hmac('sha256', $company->qr_token, env('APP_KEY'));
        if ($expectedSignature !== $validated['signature']) {
            return response()->json(['message' => 'QR code signature mismatch.'], 400);
        }

        /*
         * validates the location of the employee
         * */

        $distance = $this->calculateDistance(
            $company->latitude,
            $company->longitude,
            $validated['latitude'],
            $validated['longitude']
        );

        if ($distance > $company->radius) {
            return response()->json([
                'message' => 'You are outside the company geofence. Cannot clock in.',
                'distance_m' => round($distance, 2),
                'allowed_radius_m' => $company->radius,
            ], 400);
        }

//        validate if android_id is already in use
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

//        inserts android_id on employees table
        $employee['android_id'] = $validated['android_id'];
        $employee->save();

        $today = Carbon::today();
        $existing = AttendanceLogs::where('employee_id', $employee->employee_id)
            ->whereDate('log_date', $today)
            ->first();

        if ($existing && $existing->clock_in_time) {
            return response()->json([
                'message' => 'Already clocked in today.',
            ], 400);
        }

        $data = $this->isScheduledToday($employee->employee_id);
        $isWorkingDay = $data['isWorkingDay'];
        $schedule = $data['schedule'];

        if (!$isWorkingDay || !$schedule) {
            return response()->json(['message' => "Employee $employee->employee_id has no schedule today."], 401);
        }

        $clockIn = Carbon::today()->setHour(8)->setMinute(0)->setSecond(0);
        $attendance = AttendanceLogs::updateOrCreate([
            'log_id' => Str::uuid(),
            'admin_id' => $employee->admin_id,
            'employee_id' => $employee->employee_id,
            'company_id' => $validated['company_id'],
            'log_date' => now(),
            'clock_in_time' => Carbon::now(),
            'time_in' => Carbon::now(),
            'clock_in_latitude' => $validated['latitude'],
            'clock_in_longitude' => $validated['longitude'],
        ]);

        return response()->json([
            'message' => 'Clock-in successful.',
            'data' => $attendance,
        ]);
    }

    /**
     * Handle employee clock-out
     */
    public function clockOut(Request $request)
    {

//        TODO: insert update payslip method in clockout
        /*
         * if attendance scanning comes with options of clockin in and clockin out,
         * then this method should also validate the qr payload. (copy & paste or helper function)
         * */
        $employee = $request->user();

        $validated = $request->validate([
            'company_id' => 'required|string',
            'token' => 'required|string',
            'signature' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);


        $company = Company::where('company_id', $validated['company_id'])->first();

        if(!$company || $company->qr_token !== $validated['token']) {
            return response()->json(['message' => 'Invalid or expired QR code.'], 400);
        }

        $expectedSignature = hash_hmac('sha256', $company->qr_token, env('APP_KEY'));
        if ($expectedSignature !== $validated['signature']) {
            return response()->json(['message' => 'QR code signature mismatch.'], 400);
        }

        /*
         * validates the location of the employee
         * */

        $distance = $this->calculateDistance(
            $company->latitude,
            $company->longitude,
            $validated['latitude'],
            $validated['longitude']
        );

        if ($distance > $company->radius) {
            return response()->json([
                'message' => 'You are outside the company geofence. Cannot clock in.',
                'distance_m' => round($distance, 2),
                'allowed_radius_m' => $company->radius,
            ], 400);
        }

        $today = Carbon::today();

        $attendance = AttendanceLogs::where('employee_id', $employee->employee_id)
            ->whereDate('log_date', $today)
            ->first();

        if (!$attendance) {
            return response()->json([
                'message' => 'No clock-in record found for today.',
            ], 404);
        }

        if ($attendance->clock_out_time) {
            return response()->json([
                'message' => 'Already clocked out today.',
            ], 400);
        }
        $clockOut = Carbon::today()->setHour(17)->setMinute(0)->setSecond(0); // for testing purposes
        $attendance->update([
            'clock_out_time' => Carbon::now(),
            'time_out' => Carbon::now(),
            'clock_out_latitude' => $validated['latitude'],
            'clock_out_longitude' => $validated['longitude'],
        ]);

//        remove android_id on employees table
        $employee['android_id'] = null;
        $employee->save();

        $this->dailyPayroll->createDailyPayroll($employee->employee_id);

        return response()->json([
            'message' => 'Clock-out successful.',
            'data' => $attendance,
        ]);
    }

    public function getTodayAttendance(Request $request)
    {
        $employee = $request->user();
        $today = Carbon::today();

        $attendance = AttendanceLogs::where('employee_id', $employee->employee_id)
            ->whereDate('created_at', $today)
            ->first();

        return response()->json([
            'data' => $attendance,
        ]);
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000;

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $a = sin($latDelta / 2) ** 2 +
            cos($latFrom) * cos($latTo) * sin($lonDelta / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
