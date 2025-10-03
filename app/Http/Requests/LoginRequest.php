<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class LoginRequest extends FormRequest
{
    public function authorize() {
        return true;
    }
    public function rules(): array {
       return [
            'email' => ['required', 'email'],
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
