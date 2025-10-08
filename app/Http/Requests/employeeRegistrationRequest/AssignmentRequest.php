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
            'company_id' => ['required', 'string', 'exists:companies,company_id'],
            'employment_type' => ['required', 'string', 'in:full-time,part-time,contractual'],
            'contract_start' => ['required', 'date', 'date_format:Y-m-d'],
            'contract_end' => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:contract_start'],
            'job_position' => ['required', 'string', 'max:255'],
            'uploaded_documents' => ['nullable', 'array'],
            'uploaded_documents.*' => ['file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ];
    }
}
