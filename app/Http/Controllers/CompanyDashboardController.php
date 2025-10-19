<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Repositories\CompanyRepository;
use App\Repositories\EmployeeRepository;

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

    public function show($id) {
        $company = Company::with('employees')
            ->findOrFail($id);
      return view('company.company-information', compact('company'))->with('title', $company->company_name . ' ' . 'Dashboard');
    }
}
