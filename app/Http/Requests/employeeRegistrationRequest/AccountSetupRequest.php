<?php

namespace App\Http\Requests\employeeRegistrationRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Password;

class AccountSetupRequest extends FormRequest
{
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'email' => 'required|string|email|max:255|unique:employees',
            'username' => 'required|string|max:20|unique:employees',
            'password' => [
                'required',
                'string',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
                ]
        ];

//        TODO: subject for checks and revisions. make username as the primary log in option for the mobile device
//        TODO:password should be default

    }
}
