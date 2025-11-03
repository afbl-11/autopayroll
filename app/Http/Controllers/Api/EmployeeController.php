<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function profile(Request $request)
    {
        $employee = $request->user();

        if (!$employee) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return response()->json([
            'employee_id' => $employee->employee_id,
            'company_id' => $employee->company_id,
            'profile_photo' => $employee->profile_photo,
            'first_name' => $employee->first_name,
            'middle_name' => $employee->middle_name,
            'last_name' => $employee->last_name,
            'suffix' => $employee->suffix,
            'email' => $employee->email,
            'username' => $employee->username,
            'phone_number' => $employee->phone_number,
            'job_position' => $employee->job_position,
            'contract_start' => $employee->contract_start,
            'contract_end' => $employee->contract_end,
            'employment_type' => $employee->employment_type,
            'birthdate' => $employee->birthdate,
            'gender' => $employee->gender,
            'marital_status' => $employee->marital_status,
            'blood_type' => $employee->blood_type,
            'country' => $employee->country,
            'region_name' => $employee->region_name,
            'province_name' => $employee->province_name,
            'zip' => $employee->zip,
            'city_name' => $employee->city_name,
            'barangay_name' => $employee->barangay_name,
            'street' => $employee->street,
            'house_number' => $employee->house_number,
            'id_country' => $employee->id_country,
            'id_region' => $employee->id_region,
            'id_province' => $employee->id_province,
            'id_zip' => $employee->id_zip,
            'id_city' => $employee->id_city,
            'id_barangay' => $employee->id_barangay,
            'id_street' => $employee->id_street,
            'id_house_number' => $employee->id_house_number,
            'bank_account_number' => $employee->bank_account_number,
            'sss_number' => $employee->sss_number,
            'phil_health_number' => $employee->phil_health_number,
            'pag_ibig_number' => $employee->pag_ibig_number,
            'tin_number' => $employee->tin_number,
            'uploaded_documents' => $employee->uploaded_documents,
            'created_at' => $employee->created_at,
            'updated_at' => $employee->updated_at,
        ]);
    }
}
