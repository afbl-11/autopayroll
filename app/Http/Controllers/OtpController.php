<?php

namespace App\Http\Controllers;

//use GuzzleHttp\Psr7\Request;
use App\Models\Employee;
use App\Models\OtpCodes;
use App\Services\SMSService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OtpController extends Controller
{
//    public function sendOtp(Request $request)
//    {
//        $request->validate([
//            'employee_id' => 'required|exists:employees,employee_id',
//        ]);
//
//        $employee = DB::table('employees')->where('employee_id', $request->employee_id)->first();
//
//        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
//
//        DB::table('otp_codes')->insert([
//            'otp_code_id' => Str::uuid(),
//            'employee_id' => $employee->employee_id,
//            'otp_code' => $otp,
//            'expires_at' => now()->addMinutes(5),
//            'verified' => 0,
//            'created_at' => now(),
//            'updated_at' => now()
//        ]);
//
//        // Send SMS
//        $this->sendSms($employee->phone_number, $otp);
//
//        return response()->json(['message' => 'OTP sent successfully']);
//    }

    private function sendSms($phone, $otp)
    {
        $apiKey = env('SEMAPHORE_API_KEY'); // store your API key in .env
        $message = "Your OTP code for forgot password in the AutoPayroll app is: $otp. please dont share this code to anyone. ";

        $client = new \GuzzleHttp\Client();
        $response = $client->post('https://api.semaphore.co/api/v4/messages/', [
            'form_params' => [
                'apikey' => $apiKey,
                'number' => $phone,
                'message' => $message,
                'sendername' => 'AUTOPAY', // optional
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'otp_code' => 'required|string|size:6',
        ]);

        $record = DB::table('otp_codes')
            ->where('employee_id', $request->employee_id)
            ->where('otp_code', $request->otp_code)
            ->where('expires_at', '>', now())
            ->where('verified', 0)
            ->first();

        if($record) {
            DB::table('otp_codes')->where('id', $record->id)->update(['verified' => 1]);
            return response()->json(['message' => 'OTP verified successfully']);
        }

        return response()->json(['message' => 'Invalid or expired OTP'], 422);
    }

    public function sendOtp(Request $request, SMSService $sms)
    {
        $request->validate([
            'employee_id' => 'required',
        ]);

        // 1. Find employee
        $employee = Employee::where('employee_id', $request->employee_id)->first();

        if (!$employee || !$employee->phone_number) {
            return response()->json([
                'success' => false,
                'message' => 'Employee not found or no phone number registered.'
            ], 404);
        }

        // 2. Generate OTP
        $otp = rand(100000, 999999);

        // 3. Save OTP
        OtpCodes::create([
            'otp_code_id' => Str::uuid(),
            'employee_id' => $employee->employee_id,
            'otp_code' => $otp,
            'expires_at' => Carbon::now()->addMinutes(5)
        ]);

        $sms->send($employee->phone_number, "Your OTP is: $otp");

        return response()->json([
            'success' => true,
            'message' => 'OTP sent successfully.'
        ]);
    }
}
