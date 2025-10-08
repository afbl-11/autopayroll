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
            'middle_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'suffix' => ['required', 'string', 'in:Sr.,Jr.,Other'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:employees'],
            'birthdate' => ['required', 'date', 'date_format:Y-m-d'],
            'gender' => ['required', 'string', 'max:255', 'in:Male,Female'],
            'marital_status' => ['required', 'string', 'max:255', 'in:single,married,widowed'],
            'blood_type' => ['required', 'string', 'max:255', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],

            'bank_account_number' => ['required', 'string', 'max:255', 'unique:employees'],
            'sss_number' => ['required', 'string', 'max:255', 'unique:employees'],
            'phil_health_number' => ['required', 'string', 'max:255', 'unique:employees'],
            'pag_ibig_number' => ['required', 'string', 'max:255', 'unique:employees'],
            'tin_number' => ['required', 'string', 'max:255', 'unique:employees'],
        ];
    }
}
//TODO: change forms addEmp1
