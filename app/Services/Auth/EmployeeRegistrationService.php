<?php

namespace App\Services\Auth;

use App\Models\Company;
use App\Models\Employee;
use App\Services\GenerateId;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class EmployeeRegistrationService
{
    public function __construct(protected   GenerateId $generateId){}

    public function storeBasicInformation(array $data)
    {
        session(['register.basicInformation' => $data]);
    }
    public function storeAddress(array $data)
    {
        session(['register.address' => $data]);
    }

    public function getEmail() {
        $email = session('register.address');
//        $email['email'] = 'example@gmail.com';
        return $email['email'] ?? null;
    }
    public function storeDesignation(array $data)
    {
        session(['register.designation' => $data]);
    }
        public function storeCredentials(array $data){
        session(['register.credentials' => $data]);
    }
    public function createEmployee(): Employee
    {
            $basicInformation = session('register.basicInformation');
            $address = session('register.address');
            $designation = session('register.designation');
            $credentials = session('register.credentials');

            $data = array_merge($basicInformation, $address, $designation, $credentials);

            $data['profile_photo'] = 'default_profile.png';

            $data['password'] = Hash::make($data['password'] ?? 'DefaultPassword123!');

            $data['employee_id'] = $this->generateId->generateId(Employee::class, 'employee_id');

            if (request()->hasFile('uploaded_documents')) {
                $uploadedFiles = [];

                foreach (request()->file('uploaded_documents') as $file) {
                    $path = $file->store("employee_documents/{$data['employee_id']}", 'public');
                    $uploadedFiles[] = $path;
                }

                $data['uploaded_documents'] = json_encode($uploadedFiles);
            }
            session()->forget('register.basicInformation');
            session()->forget('register.address');
            session()->forget('register.designation');
            session()->forget('register.credentials');

            return Employee::create($data);


    }

    public function getEmployeeInformation()
    {
        try {
            $basicInformation = session('register.basicInformation');
            $address = session('register.address');
            $designation = session('register.designation');
            $credentials = session('register.credentials');

            if (!$basicInformation || !$address || !$designation || !$credentials) {
                return ["message" => "Data is missing"];
            }

            return array_merge($basicInformation, $address, $designation, $credentials);

        } catch (\Throwable $e) {
            Log::error('Error getting employee information: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return ["message" => "An unexpected error occurred while processing data."];
        }
    }

    public function concatenateResAddress() {
        $address = session('register.address');
        return  $address['province_name'] . ', ' . $address['city_name'] . ', ' . $address['barangay_name'] . ', ' . $address['street'] . ', ' . $address['house_number'];
    }

    public function concatenateIdResAddress() {
        $address = session('register.address');
        return  $address['id_province'] . ', ' . $address['id_city'] . ', ' . $address['id_barangay'] . ', ' . $address['id_street'] . ', ' . $address['id_house_number'];
    }
}
