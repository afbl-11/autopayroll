<?php

namespace App\Http\Requests\employeeRegistrationRequest;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    public function authorize() {
        return true;
    }
    public function rules() {
        return [
            'country' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'zip' => 'required|digits:4',
            'street' => 'required|string|max:255',
            'house_number' => 'required|string|max:20',

            'id_country' => 'required|string|max:255',
            'id_region' => 'required|string|max:255',
            'id_province' => 'required|string|max:255',
            'id_city' => 'required|string|max:255',
            'id_barangay' => 'required|string|max:255',
            'id_zip' => 'required|digits:4',
            'id_street' => 'required|string|max:255',
            'id_house_number' => 'required|string|max:20',

            'phone_number' => [
                'required',
                'string',
                'regex:/^\+63\d{10}$/',//TODO: forms should start with a +63
            ],
            'email' => 'nullable|string|email|max:255|unique:employees,email',
        ];
    }

}
