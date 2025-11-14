<?php

namespace App\Http\Requests\employeeRegistrationRequest;

use Illuminate\Foundation\Http\FormRequest;

class AssignmentRequest extends FormRequest
{
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'company_id' => ['nullable', 'string', 'exists:companies,company_id'],
            'employment_type' => ['required', 'string', 'in:full-time,part-time,contractual'],
            'contract_start' => ['required', 'date', 'after_or_equal:today'],
            'contract_end' => ['required', 'date', 'after_or_equal:contract_start'],
            'job_position' => ['required', 'string', 'max:255'],
            'uploaded_documents' => ['nullable', 'array'],
            'uploaded_documents.*' => ['file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'rate' => ['required','regex:/^\d+(\.\d{1,2})?$/'],
        ];
    }
}
