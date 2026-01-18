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
        $data = $request->validated();
        
        // Remove uploaded_documents from data to avoid serialization error
        unset($data['uploaded_documents']);
        
        // Handle file uploads - store temporarily
        if ($request->hasFile('uploaded_documents')) {
            $tempFiles = [];
            foreach ($request->file('uploaded_documents') as $file) {
                // Generate unique filename while preserving original name
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $filename = $originalName . '_' . time() . '_' . uniqid() . '.' . $extension;
                
                $tempPath = $file->storeAs('temp/employee_uploads', $filename, 'public');
                $tempFiles[] = $tempPath;
            }
            $data['temp_uploaded_documents'] = $tempFiles;
        }
        
        $this->employeeRegistration->storeDesignation($data);
        return redirect()->route('employee.register.4');
    }

    public function storeCredentials(AccountSetupRequest $request) {
        $this->employeeRegistration->storeCredentials($request->validated());
        return redirect()->route('employee.register.5');
    }

    public function createEmployee() {
        $this->employeeRegistration->createEmployee();

        return redirect()->route('dashboard')->with('success', 'Successfully Registered Employee.');
    }
}
