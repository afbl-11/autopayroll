<?php

namespace App\Http\Requests\employeeRegistrationRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BasicInformationRequest extends FormRequest
{
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'suffix' => ['nullable', 'in:Sr.,Jr.,Other'],
            'birthdate' => ['required', 'date', 'date_format:Y-m-d', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
            'age' => ['required', 'integer', 'min:18', 'max:65'],
            'gender' => ['required', 'in:male,female'],
            'marital_status' => ['required', 'in:single,married,widowed'],
            'blood_type' => ['required', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
            'profile_photo' => ['nullable', 'file', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],

            'bank_account_number' => ['required', 'digits_between:10,16', 'unique:employees'],

            'sss_number' => [
                'required',
                'regex:/^\d{2}-\d{7}-\d{1}$/',
                'unique:employees',
            ],

            'phil_health_number' => [
                'required',
                'regex:/^\d{2}-\d{9}-\d{1}$/',
                'unique:employees',
            ],

            'pag_ibig_number' => [
                'required',
                'regex:/^\d{4}-\d{4}-\d{4}$/',
                'unique:employees',
            ],

            'tin_number' => [
                'required',
                'regex:/^\d{3}-\d{3}-\d{3}-\d{3}$/',
                'unique:employees',
            ],
        ];
    }

    public function messages()
    {
        return [
            'sss_number.regex' => 'The sss number field must be 10 digits.',
            'phil_health_number.regex' => 'The phil health number field must be 12 digits.',
            'pag_ibig_number.regex' => 'The pag ibig number field must be 12 digits.',
            'tin_number.regex' => 'The tin number field must be between 9 and 12 digits.',
        ];
    }
}
//TODO: change forms addEmp1