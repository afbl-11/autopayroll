<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Http;

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
           'g-recaptcha-response' => ['required'],
        ];
    }

    // Added CAPTCHA here
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $captcha = $this->input('g-recaptcha-response');

            $response = Http::asForm()->post(
                'https://www.google.com/recaptcha/api/siteverify',
                [
                    'secret'   => config('services.recaptcha.secret_key'),
                    'response' => $captcha,
                    'remoteip' => $this->ip(),
                ]
            );

            if (! $response->json('success')) {
                $validator->errors()->add(
                    'g-recaptcha-response',
                    'CAPTCHA verification failed.'
                );
            }
        });
    }
}
