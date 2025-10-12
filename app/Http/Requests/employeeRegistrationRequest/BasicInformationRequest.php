<?php

namespace App\Http\Requests\employeeRegistrationRequest;

use Illuminate\Foundation\Http\FormRequest;

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
            'suffix' => [ 'nullable', 'in:Sr.,Jr.,Other'],
            'birthdate' => ['required', 'date', 'date_format:Y-m-d', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
            'age' => ['required', 'integer', 'min:18', 'max:65'],
            'gender' => ['required', 'in:male,female'],
            'marital_status' => ['required', 'in:single,married,widowed'],
            'blood_type' => ['required', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],

            'bank_account_number' => ['required', 'digits_between:10,16', 'unique:employees'],
            'sss_number' => ['required', 'digits:10', 'unique:employees'],
            'phil_health_number' => ['required', 'digits:12', 'unique:employees'],
            'pag_ibig_number' => ['required', 'digits:12', 'unique:employees'],
            'tin_number' => ['required', 'digits_between:9,12', 'unique:employees'],
        ];
    }
}
//TODO: change forms addEmp1
