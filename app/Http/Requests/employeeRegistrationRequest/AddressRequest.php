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
            'region_name' => 'required|string|max:255',
            'province_name' => 'required|string|max:255',
            'city_name' => 'required|string|max:255',
            'barangay_name' => 'required|string|max:255',
            'zip' => 'required|digits:4',
            'street' => 'required|string|max:255',
            'house_number' => 'required|string|max:20',

            'id_country' => 'required|string|max:255',
            'id_region_name' => 'required|string|max:255',
            'id_province_name' => 'required|string|max:255',
            'id_city_name' => 'required|string|max:255',
            'id_barangay_name' => 'required|string|max:255',
            'id_zip' => 'required|digits:4',
            'id_street' => 'required|string|max:255',
            'id_house_number' => 'required|string|max:20',

            'phone_number' => [
                'required',
                'string',
                'regex:/^\d{11}$/',//
            ],
            'email' => 'nullable|string|email|max:255|unique:employees,email',
        ];
    }

}
