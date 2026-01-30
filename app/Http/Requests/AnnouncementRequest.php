<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnnouncementRequest extends FormRequest
{
    public function authorize() {
        return true;
    }
    public function rules() {
        return [
            'title' => 'required|string|max:255',
            'subject' => 'nullable|string|max:255',
            'announcement_type_id' => 'nullable|exists:announcement_types,announcement_type_id',
            'type' => 'required',
            'message' => 'required|',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
    }
}
