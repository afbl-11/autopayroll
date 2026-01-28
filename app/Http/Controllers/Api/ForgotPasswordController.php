<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SendOtpMail;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class ForgotPasswordController extends Controller
{
    public function requestOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:employees,email',
        ]);


        $key = 'otp-request:' . $request->email;

        if (RateLimiter::tooManyAttempts($key, 3)) {
            return response()->json([
                'message' => 'Too many OTP requests. Please try again later.'
            ], 429);
        }

        RateLimiter::hit($key, 600); // 10 minutes

        $otp = rand(100000, 999999);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'otp' => Hash::make($otp),
                'expires_at' => Carbon::now()->addMinutes(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        Mail::to($request->email)->send(new SendOtpMail($otp));

        return response()->json([
            'success' => true,
            'message' => 'otp sent to your email',
        ], 200);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
            'email' => 'required|email|exists:employees,email',
        ]);

        $record = DB::table('password_resets')->where('email', $request->email)->first();

        if (!$record) {
            return response()->json(['otp' => 'Invalid OTP'], 404);
        }

        if (Carbon::now()->greaterThan($record->expires_at)) {
            return response()->json(['otp' => 'OTP expired'], 410);
        }

        if (!Hash::check($request->otp, $record->otp)) {
            return response()->json(['otp' => 'Incorrect OTP'], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'OTP Verified',
        ], 200);

    }
}
