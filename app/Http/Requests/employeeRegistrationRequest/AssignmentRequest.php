<?php

namespace App\Http\Requests\employeeRegistrationRequest;

use Illuminate\Foundation\Http\FormRequest;

class AssignmentRequest extends FormRequest
{
    public function authorize() {
        return true;
    }

    public function rules() {
        $rules = [
            'employment_type' => ['required', 'string', 'in:full-time,part-time,contractual'],
            'contract_start' => ['required', 'date', 'after_or_equal:today'],
            'job_position' => ['required', 'string', 'max:255'],
            'uploaded_documents' => ['nullable', 'array'],
            'uploaded_documents.*' => ['file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'rate' => ['required','regex:/^\d+(\.\d{1,2})?$/'],
        ];

        // Conditional rules based on employment type
        $employmentType = $this->input('employment_type');

        if ($employmentType === 'part-time') {
            // Part-time: no company required, days_available required, end date required
            $rules['company_id'] = ['nullable', 'string', 'exists:companies,company_id'];
            $rules['days_available'] = ['required', 'json'];
            $rules['contract_end'] = ['required', 'date', 'after_or_equal:contract_start'];
        } elseif ($employmentType === 'full-time') {
            // Full-time: company required, no end date required
            $rules['company_id'] = ['required', 'string', 'exists:companies,company_id'];
            $rules['contract_end'] = ['nullable', 'date', 'after_or_equal:contract_start'];
            $rules['days_available'] = ['nullable'];
        } elseif ($employmentType === 'contractual') {
            // Contractual: company required, end date required
            $rules['company_id'] = ['required', 'string', 'exists:companies,company_id'];
            $rules['contract_end'] = ['required', 'date', 'after_or_equal:contract_start'];
            $rules['days_available'] = ['nullable'];
        } else {
            // Default: all required
            $rules['company_id'] = ['nullable', 'string', 'exists:companies,company_id'];
            $rules['contract_end'] = ['nullable', 'date', 'after_or_equal:contract_start'];
            $rules['days_available'] = ['nullable'];
        }

        return $rules;
    }
}
