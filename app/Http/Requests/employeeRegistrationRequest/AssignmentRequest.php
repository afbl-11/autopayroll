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
          'company_designation_id' => 'required|string|max:20',
            'employmentType_id' => 'required|string|max:20',
            'startingDate' => 'required|date',
            'endingDate' => 'required|date',
            'jobPosition_id' => 'required|string|max:20',
            'uploadedDocuments' => 'required|array',
        ];

//        TODO: subject for checks and revisions. check migration
    }
}
