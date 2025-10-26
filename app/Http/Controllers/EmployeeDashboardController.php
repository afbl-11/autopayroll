<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Repositories\AttendanceRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\EmployeeRepository;
use App\Services\AttendanceService;
use Carbon\Carbon;
use Illuminate\Http\Request;


class EmployeeDashboardController extends Controller
{

    public function __construct(
        protected CompanyRepository $companyRepository,
        protected EmployeeRepository $employeeRepository,
        protected AttendanceRepository $attendanceRepository,
        protected AttendanceService $attendanceService
    ){}

    public function showStep1() {
        return view('employee.addEmp1')->with('title','Add Employee');
    }
    public function showDashboard(Request $request) {
        $companies = $this->companyRepository->getCompanies();
        $employees = $this->employeeRepository->getEmployees();

        return view('employeeDashboard', compact('employees', 'companies'))->with('title', 'Employee Dashboard');
    }

    public function showInfo($id) {
        $employee = Employee::findOrFail($id);
        $fullName = $employee->first_name . ' ' .$employee->middle_name . ' '. $employee->last_name . ' ' . $employee->suffix;
        $res_address =
            $employee->country . ', '
            . $employee->region . ', '
            . $employee->zip . ', '
            . $employee->city . ', '
            . $employee->barangay .', '
            .$employee->street . ', '
            .$employee->house_number;
        $id_address =
             $employee->id_country . ', '
             . $employee->id_region . ', '
             . $employee->id_zip . ', '
             . $employee->id_city . ', '
             . $employee->id_barangay .', '
             .$employee->id_street . ', '
             .$employee->id_house_number;

        $age = $employee->birthdate->age;

        return view('employee.employee-information', compact('employee','fullName','res_address', 'id_address', 'age'))->with('title','Employee Information');
    }

    public function showContract($id) {
        $employee = Employee::findOrFail($id);
        return view('employee.employee-contract',compact('employee'))->with('title','Employee Contract');
    }
    public function data($id){
        $employee = Employee::with('attendanceLogs')->findOrFail($id);
        $daysActive = $this->attendanceService->countAttendance($id);
        $absences = $this->attendanceService->countTotalAbsences($id);
        $overtime = $this->attendanceService->computeOvertime($id);
        $late = $this->attendanceService->computeLate($id);
        $hasLogIn = $this->attendanceService->hasLogIn($id);
        $totalOvertime = $this->attendanceService->totalOvertime($id);
        $totalNoClockOut = $this->attendanceService->totalNoClockOut($id);
        $noClock = $this->attendanceService->noClockOut($id);
        $countLate = $this->attendanceService->countLate($id);

        return [
            'employee' => $employee,
            'daysActive' => $daysActive,
            'absences' => $absences,
            'overtime' => $overtime,
            'late' => $late,
            'hasLogIn' => $hasLogIn,
            'totalOvertime' => $totalOvertime,
            'totalNoClockOut' => $totalNoClockOut,
            'noClock' => $noClock,
            'countLate' => $countLate,
            ];
    }
    public function showAttendance($id) {

        return view('employee.employee-attendance',$this->data($id))->with('title','Employee Attendance');
    }
    public function showPayroll($id) {
        $employee = Employee::findOrFail($id);
        return view('employee.employee-payroll',compact('employee'))->with('title','Employee Payroll');
    }
    public function showDocuments($id) {
        $employee = Employee::findOrFail($id);
        return view('employee.employee-documents',compact('employee'))->with('title','Employee Documents');
    }
}
