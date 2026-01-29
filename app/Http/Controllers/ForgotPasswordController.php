<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\SendOtpMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class ForgotPasswordController extends Controller
{
    public function requestOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
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

        return redirect()->route('verify.otp.input',['email' => $request->email])
            ->with('success', 'OTP sent to your email.');

    }

    public function verifyOtp(Request $request)
    {

        $request->validate([
            'otp' => 'required|digits:6',
            'email' => 'required|email|exists:admins,email',
        ]);

        $record = DB::table('password_resets')->where('email', $request->email)->first();

        if (!$record) {
            return back()->withErrors(['otp' => 'Invalid OTP'])->withInput();
        }

        if (Carbon::now()->greaterThan($record->expires_at)) {
            return back()->withErrors(['otp' => 'OTP expired'])->withInput();
        }

        if (!Hash::check($request->otp, $record->otp)) {
            return back()->withErrors(['otp' => 'Incorrect OTP'])->withInput();
        }

        return redirect()->route('forgot.password', ['email' => $request->email]);

    }

    public function verifyEmailAddress()
    {
        return view('forgotPassword.email_verification');
    }

    public function showOtpView(Request $request) {

        $email = $request->query('email');

        return view('forgotPassword.input_otp', compact('email'));
    }
}
