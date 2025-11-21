<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Employee;
use App\Models\PayrollPeriod;
use App\Repositories\AdminRepository;
use App\Repositories\AttendanceRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\PayrollRepository;

class DashboardService
{
    public function __construct(
        protected AdminRepository $adminRepository,
        protected AttendanceRepository $attendanceRepository,
        protected CompanyRepository $companyRepository,
        protected EmployeeRepository $employeeRepository,
        protected PayrollRepository $payrollRepository,
    ){}

    protected function getAdminName()
    {
        $admin = $this->adminRepository->signedAdmin();
        return $admin ? strtoupper($admin->first_name . ' ' . $admin->last_name) : null;
    }
    protected function getAdminByFirstName() {
        $admin = $this->adminRepository->signedAdmin();
        return $admin ? strtoupper($admin->first_name) : null;
    }

    protected function getAdminAll() {
        return  $this->adminRepository->signedAdmin();
    }
    protected function getEndPeriod() {
        return PayrollPeriod::orderByDesc('end_date')->value('end_date');
    }
    public function showCompanies()
    {
        $companies = Company::with('employees.dailyPayrolls')->withCount('employees')->get();

        $companies->each(function ($company) {
            $company->companyPayroll = $company->employees->sum(function ($employee) {
                return $employee->dailyPayrolls->sum('gross_salary');
            });
        });

        return $companies;
    }
    public function countEmployeesByCompany()
    {
     return Company::withCount('employees')->get();
    }
    public function getDashboardData() {
        return [
            'admin' => $this->getAdminName(),
            'attendance' => $this->attendanceRepository->getAll(),
            'employee_count' => $this->employeeRepository->countEmployees(),
            'total_payroll' => $this->payrollRepository->getTotalGrossSalary(),
            'total_deductions' => $this->payrollRepository->getTotalDeductions(),
            'end_period' => $this->getEndPeriod(),
            'company'  => $this->showCompanies(),
            'adminAll' =>$this->getAdminAll(),
            'adminFirstName' => $this->getAdminByFirstName(),
            'totalPayroll' => $this->getTotalPayroll(),
            'totalDeduction' => $this->getDeductions(),
        ];
    }

    public function getTotalPayroll()
    {
       $companies = Company::with(['employees.dailyPayrolls'])->get();

       $totalPayroll = 0;
       foreach ($companies as $company) {
           foreach ($company->employees as $employee) {
               foreach ($employee->dailyPayrolls as $dailyPayroll) {
                   $totalPayroll += $dailyPayroll->gross_salary;
               }
           }
       }
       return $totalPayroll;
    }

    public function getDeductions() {
        $companies = Company::with(['employees.dailyPayrolls'])->get();

        $totalDeductions = $companies->sum(function ($company) {
            return $company->employees->sum(function ($employee) {
                return $employee->dailyPayrolls->sum('deduction');
            });
        });

        return $totalDeductions;
    }

}
