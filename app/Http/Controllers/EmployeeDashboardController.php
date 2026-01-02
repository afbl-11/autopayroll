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
use Illuminate\Support\Facades\Storage;

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
            $employee->house_number . ', '
            .$employee->street . ', '
            . $employee->barangay_name .', '
            . $employee->city_name . ', '
            . $employee->province_name . ', '
            . $employee->zip . ', '
            . $employee->region_name. ', '
            .$employee->country ;
        $id_address =
             $employee->id_country . ', '
             . $employee->id_region_name . ', '
             . $employee->id_zip . ', '
             . $employee->id_city_name . ', '
             . $employee->id_barangay_name .', '
             .$employee->id_street . ', '
             .$employee->id_house_number;

        $age = $employee->birthdate->age;

        return view('employee.employee-information', compact('employee','fullName','res_address', 'id_address', 'age'))->with('title','Employee Information');
    }

    public function showContract($id) {
        $employee = Employee::find($id);
        return view('employee.employee-contract',compact('employee'))->with('title','Employee Contract');
    }



    public function showDocuments($id) {
        $employee = Employee::findOrFail($id);
        return view('employee.employee-documents',compact('employee'))->with('title','Employee Documents');
    }
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);

        if (!is_null($employee->company_id)) {
            return back()->with(
                'error',
                'Cannot delete this employee while assigned to a company.'
            );
        }

        if ($employee->profile_photo) {
            Storage::disk('public')->delete($employee->profile_photo);
        }

        if ($employee->uploaded_documents) {

            if (is_array($employee->uploaded_documents)) {
                foreach ($employee->uploaded_documents as $file) {
                    Storage::disk('public')->delete($file);
                }
            }

            if (is_string($employee->uploaded_documents)) {
                $files = array_filter(explode(',', $employee->uploaded_documents));
                foreach ($files as $file) {
                    Storage::disk('public')->delete($file);
                }
            }
        }

        $employee->delete();

        return redirect()
            ->route('employee.dashboard')
            ->with('success', 'Employee deleted successfully.');
    }
}