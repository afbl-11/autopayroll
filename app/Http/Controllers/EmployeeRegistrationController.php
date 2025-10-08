<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\employeeRegistrationRequest\AccountSetupRequest;
use App\Http\Requests\employeeRegistrationRequest\AddressRequest;
use App\Http\Requests\employeeRegistrationRequest\AssignmentRequest;
use App\Http\Requests\employeeRegistrationRequest\BasicInformationRequest;
use App\Services\Auth\EmployeeRegistration;

class EmployeeRegistrationController extends Controller
{
    public function __construct(protected EmployeeRegistration $employeeRegistration){}

    public function showStep1() {
        return view('employee.addEmp1');
    }
    public function showStep2() {
        return view('employee.addEmp2');
    }
    public function showStep3() {
        return view('employee.addEmp3');
    }
    public function showStep4() {
        return view('employee.addEmp4');
    }
    public function showStep5() {
        return view('employee.addEmp5');
    }

    public function storeBasicInformation(BasicInformationRequest $request){
        $this->employeeRegistration->storeBasicInformation($request->validated());

        return redirect()->route('employee.register.2');
    }

    public function storeAddress(AddressRequest $request){
        $this->employeeRegistration->storeAddress($request->validated());
        return redirect()->route('employee.register.3');
    }

    public function storeDesignation(AssignmentRequest $request){
        $this->employeeRegistration->storeDesignation($request->validated());
        return redirect()->route('employee.register.4');
    }

    public function storeCredentials(AccountSetupRequest $request) {
        $this->employeeRegistration->storeCredentials($request->validated());
        return redirect()->route('employee.register.5');
    }

    public function createEmployee() {
        $this->employeeRegistration->createEmployee();


    }
}
