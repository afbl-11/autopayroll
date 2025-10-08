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
            'country_name' => 'required|string|max:255',
            'region_name' => 'required|string|max:255',
            'province_name' => 'required|string|max:255',
            'city_name' => 'required|string|max:255',
            'barangay_name' => 'required|string|max:255',
            'zip_code' => 'required|digits:4',
            'street_name' => 'required|string|max:255',
            'house_number_' => 'required|string|max:20',

            'country_id' => 'required|string|max:255',
            'region_id' => 'required|string|max:255',
            'province_id' => 'required|string|max:255',
            'city_id' => 'required|string|max:255',
            'barangay_id' => 'required|string|max:255',
            'zip_code_id' => 'required|digits:4',
            'street_id' => 'required|string|max:255',
            'house_number_id' => 'required|string|max:20',

            'contact' => 'required|string|max:20',
            'email' => 'string|email|max:255|unique:employees', // TODO: make sure this is optional on the table
        ];
    }

//    TODO: Should add hidden input fields under address selected
//TODO: separate address column on employee table. make own address table with employee as fk
}
