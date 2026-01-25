<?php

namespace App\Services;

use App\Models\Company;
use App\Models\CreditAdjustment;
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
        'total_payroll' => $this->getTotalPayrollByType()['total'],
        'total_payroll_full_time' => $this->getTotalPayrollByType()['full_time'],
        'total_payroll_part_time' => $this->getTotalPayrollByType()['part_time'],
        'total_payroll_contractual' => $this->getTotalPayrollByType()['contractual'],
        'total_deductions' => $this->getDeductionsByType()['total'],
        'total_deductions_full_time' => $this->getDeductionsByType()['full_time'],
        'total_deductions_part_time' => $this->getDeductionsByType()['part_time'],
        'total_deductions_contractual' => $this->getDeductionsByType()['contractual'],
        'end_period' => $this->getEndPeriod(),
        'company'  => $this->showCompanies(),
        'adminAll' => $this->getAdminAll(),
        'adminFirstName' => $this->getAdminByFirstName(),
        ];
    }

    public function showAdjustmentRequest() {
        return CreditAdjustment::where('status', 'pending')->get();
    }

    public function getAttendance() {
        $employee = Employee::where('status', 'active');
    }

    //New total payroll
    public function getTotalPayrollByType()
    {
        $companies = Company::with(['employees.dailyPayrolls'])->get();

        $totals = [
            'full_time' => 0,
            'contractual' => 0,
            'part_time' => 0,
        ];

    
        //Full-time and contractual has been seperated from part-time.

        //Full-time and contractual
        $companies = Company::with(['employees.dailyPayrolls'])->get();

        foreach ($companies as $company) {
            foreach ($company->employees as $employee) {
                if ($employee->employment_type === 'full-time') {
                    foreach ($employee->dailyPayrolls as $dailyPayroll) {
                        $totals['full_time'] += $dailyPayroll->gross_salary;
                    }
                }
                elseif ($employee->employment_type === 'contractual') {
                    foreach ($employee->dailyPayrolls as $dailyPayroll) {
                        $totals['contractual'] += $dailyPayroll->gross_salary;
                    }
                }
            }
        }

        // Part-time
        $partTimeEmployees = Employee::where('employment_type', 'part-time')->with('dailyPayrolls')->get();

        foreach ($partTimeEmployees as $employee) {
            foreach ($employee->dailyPayrolls as $dailyPayroll) {
                $totals['part_time'] += $dailyPayroll->gross_salary;
            }
        }

        $totals['total'] = $totals['full_time'] + $totals['contractual'] + $totals['part_time'];

        return $totals;
    }

    //New total deductions
    public function getDeductionsByType()
    {
        $companies = Company::with(['employees.dailyPayrolls'])->get();

        $totals = [
            'full_time' => 0,
            'contractual' => 0,
            'part_time' => 0,
        ];

        // Full-timers and employees in contractual terms' deductions
        $companies = Company::with(['employees.dailyPayrolls'])->get();

        foreach ($companies as $company) {
            foreach ($company->employees as $employee) {
                if ($employee->employment_type === 'full-time') {
                    foreach ($employee->dailyPayrolls as $dailyPayroll) {
                        $totals['full_time'] += $dailyPayroll->deduction;
                    }
                }
                elseif ($employee->employment_type === 'contractual') {
                    foreach ($employee->dailyPayrolls as $dailyPayroll) {
                        $totals['contractual'] += $dailyPayroll->deduction;
                    }
                }
            }
        }

        // Part-timers' deductions
        $partTimeEmployees = Employee::where('employment_type', 'part-time')->with('dailyPayrolls')->get();

        foreach ($partTimeEmployees as $employee) {
            foreach ($employee->dailyPayrolls as $dailyPayroll) {
                $totals['part_time'] += $dailyPayroll->deduction;
            }
        }

        $totals['total'] = $totals['full_time'] + $totals['contractual'] + $totals['part_time'];

        return $totals;
    }
}