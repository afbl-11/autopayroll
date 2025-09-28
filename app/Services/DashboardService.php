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
    protected function getEndPeriod() {
        return PayrollPeriod::orderByDesc('end_date')->value('end_date');
    }
    public function showCompanies()
    {
        return Company::withCount('employees')->get();
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


        ];
    }

}
