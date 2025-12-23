<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\Auth\LoginService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
     * Handles authentication
     * **/

    public function authenticate(LoginRequest $request,LoginService $loginService): RedirectResponse {

        $userType = $loginService->attemptLogin($request->only(['email', 'password']));

        if ($userType === 'admin') {
            return redirect()->intended('/dashboard');
        }

        if ($userType === 'employee') {
            return redirect()->intended('/employee/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
