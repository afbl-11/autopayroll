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
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'suffix' => ['required', 'string', 'max:255'], //TODO: add this on the db table, and make it enum
            'dateOfBirth' => ['required', 'date', 'date_format:Y-m-d'],
            'gender' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
            'bloodtype' => ['required', 'string', 'max:255'],


//            TODO: all for revisions and checks if matching with db table columns
        ];
    }
}
