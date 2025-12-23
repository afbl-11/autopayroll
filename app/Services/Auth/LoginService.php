<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Auth;

class LoginService
{
    /**
     * Attempts login for admin or employee_web
     *
     * @param array $credentials ['email' => ..., 'password' => ...]
     * @return string|false Returns 'admin', 'employee', or false
     */
    public function attemptLogin(array $credentials): string|false
    {
        if (Auth::guard('admin')->attempt($credentials)) {
            request()->session()->regenerate();
            return 'admin';
        }

        if (Auth::guard('employee_web')->attempt($credentials)) {
            request()->session()->regenerate();
            return 'employee';
        }

        return false;
    }
}
