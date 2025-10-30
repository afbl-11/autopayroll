<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Shift;
use App\Repositories\CompanyRepository;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;

class CompanyDashboardController extends Controller
{
    public function __construct(
        protected CompanyRepository $companyRepository,
        protected EmployeeRepository $employeeRepository
    )
    {}
    public function index() {
        $companies = $this->companyRepository->getCompanyWithEmployee();

        return view('company.company-dashboard', compact('companies'))->with('title','Company Dashboard');
    }

    public function showInfo($id) {
        $company = Company::with('employees')
            ->findOrFail($id);
      return view('company.company-information', compact('company'))->with('title', $company->company_name . ' ' . 'Dashboard');
    }
    public function showEmployees($id) {
        $company = Company::with('employees')->find($id);
        return view('company.company-employees', compact('company'));
    }
    public function showSchedules($id) {
        $company = Company::with(['employees.employeeSchedule'])->find($id);

        return view('company.company-schedules', compact('company'));
    }

    public function showEmployeeAssign($id) {
        $company = Company::with('employees')->find($id);
        $employees = Employee::whereNull('company_id')->get();
        return view('company.company-employee-assignment', compact('employees', 'company'));
    }

    public function assignEmployees(Request $request, $companyId)
    {
        $request->validate([
            'employees' => 'array|required',
        ]);

        // assign employees to this company
            Employee::whereIn('employee_id', $request->employees)
            ->update(['company_id' => $companyId]);

        return redirect()
            ->route('dashboard', $companyId)
            ->with('success', 'Employees assigned successfully.');
    }

}
