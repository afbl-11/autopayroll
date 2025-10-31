<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Employee;
use App\Models\EmployeeSchedule;
use App\Models\Shift;
use App\Repositories\CompanyRepository;
use App\Repositories\EmployeeRepository;
use App\Services\EmployeeAssignmentService;
use App\Services\GenerateId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyDashboardController extends Controller
{
    public function __construct(
        protected CompanyRepository $companyRepository,
        protected EmployeeRepository $employeeRepository,
        protected EmployeeAssignmentService $employeeAssign,
        protected GenerateId $generateId,
    )
    {}
    public function index() {
        $companies = $this->companyRepository->getCompanyWithEmployee();

        return view('company.company-dashboard', compact('companies'))->with('title','Company Dashboard');
    }

    public function showInfo($id) {
        $company = Company::with('employees')
            ->findOrFail($id);
      return view('company.company-information', compact('company'))->with('title', $company->company_name . ' ' . 'Dashboard');
    }
    public function showEmployees($id) {
        $company = Company::with('employees')->find($id);
        return view('company.company-employees', compact('company'));
    }
    public function showSchedules($id) {
        $company = Company::with(['employees.employeeSchedule'])->find($id);

        return view('company.company-schedules', compact('company'));
    }

    public function showEmployeeAssign($id) {
        $company = Company::with('employees')->find($id);
        $employees = Employee::whereNull('company_id')->get();
        return view('company.company-employee-assignment', compact('employees', 'company'));
    }

    public function showEmployeeUnassign($id) {
        $company = Company::with('employees')->find($id);
        $employees = Employee::where('company_id', $id)->get();
        return view('company.employee-unassign', compact('company', 'employees'));
    }

    public function assignEmployees(Request $request, $companyId)
    {
       $this->employeeAssign->assignEmployees($request, $companyId);
        return back();
    }

    public function unassignEmployees(Request $request, $companyId) {
        $this->employeeAssign->unassign($request, $companyId);
        return back();
    }

    public function store(Request $request, $companyId)
    {
        // Validate incoming form data
        $validated = $request->validate([
            'employee_id' => 'required|string|exists:employees,employee_id',
            'company_id' => 'required|string|exists:companies,company_id',
            'working_days' => 'nullable|array',
            'working_days.*' => 'string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'custom_start' => 'nullable|date_format:H:i',
            'custom_end' => 'nullable|date_format:H:i',
            'custom_break_start' => 'nullable|date_format:H:i',
            'custom_break_end' => 'nullable|date_format:H:i',
            'custom_lunch_start' => 'nullable|date_format:H:i',
            'custom_lunch_end' => 'nullable|date_format:H:i',
        ]);
//        $id = $this->generateId->generateId(EmployeeSchedule::class, 'employee_schedules_id');
//        dd($id);
        // Create a new schedule entry
             EmployeeSchedule::create([
            'employee_schedules_id' => $this->generateId->generateId(EmployeeSchedule::class,'employee_schedules_id'),
            'employee_id' => $validated['employee_id'],
                 'company_id' => 'cpom',
            'shift_id' => null, // optional, can be assigned later
            'working_days' => $validated['working_days'] ?? [],
            'custom_start' => $validated['custom_start'] ?? null,
            'custom_end' => $validated['custom_end'] ?? null,
            'custom_break_start' => $validated['custom_break_start'] ?? null,
            'custom_break_end' => $validated['custom_break_end'] ?? null,
            'custom_lunch_start' => $validated['custom_lunch_start'] ?? null,
            'custom_lunch_end' => $validated['custom_lunch_end'] ?? null,
            'start_date' => now(),
            'end_date' => null,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Schedule created successfully for the selected employee!');
    }

}
