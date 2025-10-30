<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRegistrationRequest extends FormRequest
{
    public function authorize() {
        return true;
    }
    public function rules() {
        return [
            'company_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'tin_number' => 'required|digits_between:9,12',
            'industry' => 'required|string|max:255',

        ];
    }
}
