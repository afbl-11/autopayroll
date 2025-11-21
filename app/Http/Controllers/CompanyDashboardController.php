<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyAddressRequest;
use App\Http\Requests\CreateScheduleRequest;
use App\Models\Company;
use App\Models\Employee;
use App\Models\EmployeeSchedule;
use App\Models\Shift;
use App\Repositories\CompanyRepository;
use App\Repositories\EmployeeRepository;
use App\Services\EmployeeAssignmentService;
use App\Services\GenerateId;
use App\Services\ScheduleService;
use App\Services\UpdateCompanyAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyDashboardController extends Controller
{
    public function __construct(
        protected CompanyRepository $companyRepository,
        protected EmployeeRepository $employeeRepository,
        protected EmployeeAssignmentService $employeeAssign,
        protected GenerateId $generateId,
        protected ScheduleService $scheduleService,
        protected UpdateCompanyAddress $updateCompanyAddress,
    )
    {}
    public function index() {
        $companies = $this->companyRepository->getCompanyWithEmployee();

        return view('company.company-dashboard', compact('companies'))->with('title','Company Dashboard');
    }

    public function showInfo($id) {
        $company = Company::with('employees')
            ->find($id);
      return view('company.company-information', compact('company'))->with('title', $company->company_name . ' ' . 'Dashboard');
    }
    public function showEmployees($id) {
        $company = Company::with('employees')->find($id);
        return view('company.company-employees', compact('company'));
    }
    public function showSchedules($id) {
        $company = Company::with(['employees.employeeSchedule' => function($query) {
            $query->whereNull('end_date');
        }])->find($id);

        return view('company.company-schedules', compact('company'));
    }

    public function showEmployeeAssign($id) {
        $company = Company::with('employees')->find($id);
        $employees = Employee::whereNull('company_id')->get();
        return view('company.company-employee-assignment', compact('employees', 'company'));
    }

    public function showEmployeeUnassign($id) {
        $company = Company::with('employees')->find($id);
        $employees = Employee::where('company_id', $id)->get();
        return view('company.employee-unassign', compact('company', 'employees'));
    }

    public function assignEmployees(Request $request, $companyId)
    {
       $this->employeeAssign->assignEmployees($request, $companyId);
        return back();
    }

    public function unassignEmployees(Request $request, $companyId) {
        $this->employeeAssign->unassign($request, $companyId);
        return back();
    }

    public function createSchedule(CreateScheduleRequest $request) {
        $this->scheduleService->createSchedule($request->validated());

        return back();
    }

    public function showLocationChange(string $id)
    {
        $company = Company::with('employees')
            ->find($id);
        return view('company.company-location', compact('id', 'company'))->with(['title' => 'Change Company Location']);
    }

    public function storeUpdatedClientAddress(CompanyAddressRequest $request, $id)
    {
        $this->updateCompanyAddress->updateAddress($request->validated(),$id);

        return redirect()->route('company.dashboard.detail', ['id' => $id]);
    }

}
