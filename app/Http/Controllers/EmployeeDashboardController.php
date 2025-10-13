<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Repositories\CompanyRepository;

class EmployeeDashboardController extends Controller
{

    public function __construct(
        protected CompanyRepository $companyRepository,
    ){}
    public function showDashboard() {
        $companies = $this->companyRepository->getCompanies();
        return view('employeeDashboard', compact('companies'))->with('title','Employee Dashboard');
    }

    public function showStep1() {
        $title = 'Add Employee';
        return view('employee.addEmp1', compact('title'));
    }
}
