<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Auth;

class LoginService
{
    public function AttemptLogin(array $credentials):bool {
        if (Auth::guard('admin')->attempt($credentials)) {
            request()->session()->regenerate();
            return true;
        }
        return false;
    }
}
