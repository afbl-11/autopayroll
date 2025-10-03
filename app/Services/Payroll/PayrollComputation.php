<?php

namespace App\Services\Payroll;

use App\Models\AttendanceLogs;
use App\Models\Employee;
use App\Models\Payroll;
use App\Models\PayrollPeriod;
use App\Repositories\AttendanceRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\PayrollRepository;

class PayrollComputation
{
    public function __construct(
        protected PayrollPeriod $payrollPeriod,
        protected AttendanceLogs $attendanceLogs,
        protected Employee  $employee,
        protected Payroll $payroll,
    )
    {}

    public function VerifyAttendance(string $employeeId, $payrollPeriodId) {




    }
}
