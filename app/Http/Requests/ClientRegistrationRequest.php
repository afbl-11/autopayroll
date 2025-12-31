<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Company;
use App\Models\Admin;

class ClientRegistrationRequest extends FormRequest
{
    public function authorize() {
        return true;
    }
    public function rules()
    {
        return [
            'company_name' => 'required|string|max:255',
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'tin_number' => [
                    'required',
                    'regex:/^[\d-]{11,15}$/',
                    function ($attribute, $value, $fail) {
                        $digits = str_replace('-', '', $value);
                        if (strlen($digits) < 9 || strlen($digits) > 12) {
                            $fail('The tin number field must be between 9 and 12 digits.');
                        }
                    },
                    Rule::unique('companies', 'tin_number')->ignore($this->route('company')),
                ],
            'industry'     => 'required|string|max:255',
            'company_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $companyName = ucwords(strtolower($this->company_name));
            $industry = ucwords(strtolower($this->industry));

            $companyQuery = Company::where('company_name', $companyName)
                ->where('industry', $industry);

            if ($this->route('company')) {
                $companyQuery->where('id', '!=', $this->route('company'));
            }

            if ($companyQuery->exists()) {
                $validator->errors()->add('company_name', 'A company with the same name and industry already exists.');
            }
            
            if (Admin::where('company_name', $companyName)->exists()) {
                $validator->errors()->add(
                    'company_name',
                    'This is your company name.'
                );
            }
        });
    }
    public function messages()
    {
        return [
            'tin_number.required'       => 'The tin number is required.',
            'tin_number.regex' => 'The tin number field must be between 9 and 12 digits.',
            'tin_number.unique'         => 'This tin number has already been registered to another company.',
            'company_name.unique_industry' => 'A company with the same name and industry already exists.',
        ];
    }
}