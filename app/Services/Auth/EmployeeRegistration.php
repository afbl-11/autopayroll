<?php

namespace App\Services\Auth;

use App\Models\Employee;
use App\Services\GenerateId;
use Illuminate\Support\Facades\Hash;

class EmployeeRegistration
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

        $data['password'] = Hash::make($data['password'] ?? 'DefaultPassword123!');

        $data['employee_id'] = $this->generateId->generateId(Employee::class, 'employee_id');

        session()->forget('register.basicInformation');
        session()->forget('register.address');
        session()->forget('register.designation');
        session()->forget('register.credentials');

        return Employee::create($data);

    }


}
