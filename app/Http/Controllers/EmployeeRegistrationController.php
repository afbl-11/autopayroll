<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\employeeRegistrationRequest\AccountSetupRequest;
use App\Http\Requests\employeeRegistrationRequest\AddressRequest;
use App\Http\Requests\employeeRegistrationRequest\AssignmentRequest;
use App\Http\Requests\employeeRegistrationRequest\BasicInformationRequest;
use App\Repositories\CompanyRepository;
use App\Services\Auth\EmployeeRegistrationService;

class EmployeeRegistrationController extends Controller
{
    public function __construct(
        protected EmployeeRegistrationService $employeeRegistration,
        protected CompanyRepository $companyRepository
    ){}

    public function showStep1() {
        return view('employee.addEmp1');
    }
    public function showStep2() {
        return view('employee.addEmp2')->with('title', 'Add Employee');
    }
    public function showStep3() {
        $companies = $this->companyRepository->getCompanies();
        return view('employee.addEmp3',compact('companies'))->with('title', 'Add Employee',);
    }
    public function showStep4() {
        $email = $this->employeeRegistration->getEmail();
        return view('employee.addEmp4',compact('email'))->with('title', 'Add Employee');
    }
    public function showStep5() {

        $data = $this->employeeRegistration->getEmployeeInformation();
        $address = $this->employeeRegistration->concatenateResAddress();
        $idAddress = $this->employeeRegistration->concatenateIdResAddress();
        if (isset($data['message'])) {
            return redirect()->route('employee.register.1')
                ->with('error', $data['message']);

        }

        return view('employee.addEmp5', compact('data', 'address','idAddress'))->with('title', 'Add Employee');
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

        return redirect()->route('dashboard')->with('success', 'Successfully Registered Employee');
    }
}
