<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRegisterAddress extends FormRequest
{
    public function authorize() {
        return true;
    }
    public function rules() {
        return [
            'company_name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'region_name' => 'required|string|max:255',
            'province_name' => 'required|string|max:255',
            'city_name' => 'required|string|max:255',
            'barangay_name' => 'required|string|max:255',
            'zip' => 'required|digits:4',
            'street' => 'required|string|max:255',
            'house_number' => 'required|string|max:20',
        ];
    }
}
