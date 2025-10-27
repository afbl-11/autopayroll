<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class AdminRegisterPersonal extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => ['required','string','max:255'],
            'middle_name' => ['required','string','max:255'],
            'last_name' => ['required','string','max:255'],
            'suffix' => [ 'nullable', 'in:Sr.,Jr.,Other'],
            'email' => ['required','email','unique:admins,email'],
            'password' => [
                'required',
                'string',
                Password::min(8)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            ],
        ];

    }
}
