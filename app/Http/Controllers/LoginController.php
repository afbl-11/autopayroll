<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\Auth\LoginService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
     * Handles authentication
     * **/
    public function authenticate(LoginRequest $request, LoginService $loginService): RedirectResponse
    {
        $credentials = $request->only(['email', 'password']);
        $userType = $loginService->attemptLogin($credentials);

        if ($userType) {
            if ($userType === 'admin') {
                return redirect()->intended('/dashboard');
            }
            if ($userType === 'employee') {
                return redirect()->intended('/employee/employee-dashboard');
            }
        }

        $admin = Admin::where('email', $request->email)->first();
        $employee = Employee::where('email', $request->email)->first();

        if ($admin) {
            return back()->withErrors([
                'password' => 'The password is incorrect.',
            ])->onlyInput('email');
        }

        if ($employee) {
            return back()->withErrors([
                'password' => 'The password is incorrect.',
            ])->onlyInput('email');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
