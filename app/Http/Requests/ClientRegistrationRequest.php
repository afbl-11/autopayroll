<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientRegistrationRequest extends FormRequest
{
    public function authorize() {
        return true;
    }
    public function rules()
    {
        return [
            'company_name' => 'required|string|max:255',
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'tin_number' => [
                    'required',
                    'regex:/^[\d-]{11,15}$/',
                    function ($attribute, $value, $fail) {
                        $digits = str_replace('-', '', $value);
                        if (strlen($digits) < 9 || strlen($digits) > 12) {
                            $fail('The tin number field must be between 9 and 12 digits.');
                        }
                    },
                    Rule::unique('companies', 'tin_number')->ignore($this->route('company')),
                ],
            'industry'     => 'required|string|max:255',
            'company_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }
    public function messages()
    {
        return [
            'tin_number.required'       => 'The tin number is required.',
            'tin_number.regex' => 'The tin number field must be between 9 and 12 digits.',
            'tin_number.unique'         => 'This tin number has already been registered to another company.',
        ];
    }
}