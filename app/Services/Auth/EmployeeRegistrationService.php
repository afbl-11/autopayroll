<?php

namespace App\Services\Auth;

use App\Models\Company;
use App\Models\Employee;
use App\Services\GenerateId;
use App\Services\LeaveCreditService;
use App\Services\Payroll\EmployeeRatesService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class EmployeeRegistrationService
{
    public function __construct(
        protected   GenerateId $generateId,
        protected EmployeeRatesService $ratesService,
        protected LeaveCreditService $creditService,
    ){}

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
        return $email['email'] ?? null;
    }
    public function storeDesignation(array $data)
    {
        session(['register.designation' => $data]);
    }
        public function storeCredentials(array $data){
        session(['register.credentials' => $data]);
    }

    /**
     * @throws \Exception
     */
    public function createEmployee()
    {
            $basicInformation = session('register.basicInformation');
            $address = session('register.address');
            $designation = session('register.designation');
            $credentials = session('register.credentials');

            $data = array_merge($basicInformation, $address, $designation, $credentials);

            $data['profile_photo'] = 'default_profile.png';

            $data['password'] = Hash::make($data['password'] ?? 'DefaultPassword123!');

            $data['employee_id'] = $this->generateId->generateId(Employee::class, 'employee_id');

            $adminID = Auth::guard('admin')->user()->id;
            $data['admin_id'] = $adminID;

            $rateData = [
              'employee_id' => $data['employee_id'],
              'rate' => $data['rate'],
            ];

            // Move files from temp to final location
            if (isset($data['temp_uploaded_documents']) && is_array($data['temp_uploaded_documents'])) {
                $uploadedFiles = [];
                $storage = \Illuminate\Support\Facades\Storage::disk('public');
                
                foreach ($data['temp_uploaded_documents'] as $tempPath) {
                    if ($storage->exists($tempPath)) {
                        $fileName = basename($tempPath);
                        $finalPath = "employee_documents/{$data['employee_id']}/{$fileName}";
                        
                        // Move file from temp to final location
                        $storage->move($tempPath, $finalPath);
                        $uploadedFiles[] = $finalPath;
                    }
                }

                $data['uploaded_documents'] = json_encode($uploadedFiles);
                unset($data['temp_uploaded_documents']);
            }


            // Clean up temporary files if registration is cancelled
            $storage = \Illuminate\Support\Facades\Storage::disk('public');
            if (isset($data['temp_uploaded_documents'])) {
                foreach ($data['temp_uploaded_documents'] as $tempPath) {
                    if ($storage->exists($tempPath)) {
                        $storage->delete($tempPath);
                    }
                }
            }
            
            session()->forget('register.basicInformation');
            session()->forget('register.address');
            session()->forget('register.designation');
            session()->forget('register.credentials');

            Employee::create($data);

            $this->ratesService->createRate($rateData);
            $this->creditService->createCreditRecord($data['employee_id']);
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
        
        if (!$address) {
            return 'Address not available';
        }
        
        return  ($address['province_name'] ?? '') . ', ' . 
                ($address['city_name'] ?? '') . ', ' . 
                ($address['barangay_name'] ?? '') . ', ' . 
                ($address['street'] ?? '') . ', ' . 
                ($address['house_number'] ?? '');
    }

    public function concatenateIdResAddress() {
        $address = session('register.address');
        
        if (!$address) {
            return 'ID Address not available';
        }
        
        return  ($address['id_province_name'] ?? '') . ', ' . 
                ($address['id_city_name'] ?? '') . ', ' . 
                ($address['id_barangay_name'] ?? '') . ', ' . 
                ($address['id_street'] ?? '') . ', ' . 
                ($address['id_house_number'] ?? '');
    }
}
