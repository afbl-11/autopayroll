<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyAddressRequest extends FormRequest
{
    public function authorize(){
        return true;
    }
    public function rules() {
        return [
            'address' => ['required', 'string', 'max:255'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'radius' => ['required', 'numeric', 'min:1', 'max:50000'],
        ];
    }


}
