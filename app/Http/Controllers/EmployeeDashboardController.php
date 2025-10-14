<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Repositories\AttendanceRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;


class EmployeeDashboardController extends Controller
{

    public function __construct(
        protected CompanyRepository $companyRepository,
        protected EmployeeRepository $employeeRepository,
        protected AttendanceRepository $attendanceRepository,
    ){}


    public function showDashboard(Request $request) {
        $companies = $this->companyRepository->getCompanies();
        $employees = $this->employeeRepository->getEmployees();

        return view('employeeDashboard', compact('employees', 'companies'))->with('title', 'Employee Dashboard');
    }




    public function showStep1() {
        return view('employee.addEmp1')->with('title','Add Employee');
    }
}
