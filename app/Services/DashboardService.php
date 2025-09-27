<?php

namespace App\Services;

use App\Repositories\AdminRepository;
use App\Repositories\AttendanceRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\EmployeeRepository;

class DashboardService
{
    public function __construct(
        protected AdminRepository $adminRepository,
        protected AttendanceRepository $attendanceRepository,
        protected CompanyRepository $companyRepository,
        protected EmployeeRepository $employeeRepository,
    ){}

    protected function getAdminName()
    {
        $admin = $this->adminRepository->signedAdmin();
        return $admin ? strtoupper($admin->first_name . ' ' . $admin->last_name) : null;

    }
    public function getDashboardData() {
        return [
            'admin' => $this->getAdminName(),
            'attendance' => $this->attendanceRepository->getAll(),
            'employee_count' => $this->employeeRepository->countEmployees(),
        ];
    }
}
