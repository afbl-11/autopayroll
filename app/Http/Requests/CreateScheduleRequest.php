<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateScheduleRequest extends FormRequest
{
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'employee_id' => ['required', 'exists:employees,employee_id'],
            'working_days' => ['required', 'array', 'min:1'],
            'working_days.*' => ['string'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i'],
        ];
    }
    
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $startTime = $this->input('start_time');
            $endTime = $this->input('end_time');
            
            // Allow night shifts that cross midnight
            // Only validate if both times are provided
            if ($startTime && $endTime) {
                // Parse times
                $start = \Carbon\Carbon::parse($startTime);
                $end = \Carbon\Carbon::parse($endTime);
                
                // Night shift detection: if end is same or before start
                // This is valid for night shifts (e.g., 10pm-6am)
                // No validation error needed as this is acceptable
            }
        });
    }
}
