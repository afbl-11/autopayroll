<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyAddressRequest;
use App\Http\Requests\CreateScheduleRequest;
use App\Models\Company;
use App\Models\CompanySchedule;
use App\Models\Employee;
use App\Models\EmployeeSchedule;
use App\Models\Shift;
use App\Repositories\CompanyRepository;
use App\Repositories\EmployeeRepository;
use App\Services\EmployeeAssignmentService;
use App\Services\GenerateId;
use App\Services\ScheduleService;
use App\Services\UpdateCompanyAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin;
use App\Models\PartTimeAssignment;
use Carbon\Carbon;


class CompanyDashboardController extends Controller
{
    public function __construct(
        protected CompanyRepository $companyRepository,
        protected EmployeeRepository $employeeRepository,
        protected EmployeeAssignmentService $employeeAssign,
        protected GenerateId $generateId,
        protected ScheduleService $scheduleService,
        protected UpdateCompanyAddress $updateCompanyAddress,
    )
    {}
    public function index() {
        $companies = $this->companyRepository->getCompanyWithEmployee();

        return view('company.company-dashboard', compact('companies'))->with('title','Company Dashboard');
    }

    public function showInfo($id) {
        $company = Company::with('employees')
            ->find($id);
      return view('company.company-information', compact('company'))->with('title', $company->company_name . ' ' . 'Dashboard');
    }
    public function showEmployees($id) {
        // Get company with permanently assigned employees
        $company = Company::with('employees')->find($id);
        
        // Get part-time employees hired for this company (any active assignment)
        // Include those with company_id set to this company OR those with null company_id but have assignments
        $partTimeHiredEmployees = Employee::where('employment_type', 'part-time')
            ->where(function($query) use ($id) {
                $query->whereNull('company_id')
                      ->orWhere('company_id', $id);
            })
            ->whereHas('partTimeAssignments', function($query) use ($id) {
                $query->where('company_id', $id);
            })
            ->with(['partTimeAssignments' => function($query) use ($id) {
                $query->where('company_id', $id);
            }])
            ->get()
            ->map(function($employee) {
                // Collect all assigned days from all assignments for this company
                $allAssignedDays = [];
                foreach ($employee->partTimeAssignments as $assignment) {
                    $days = $assignment->assigned_days;
                    if (!is_array($days)) {
                        $days = json_decode($days, true) ?? [];
                    }
                    $allAssignedDays = array_merge($allAssignedDays, $days);
                }
                $employee->assigned_days_for_company = array_unique($allAssignedDays);
                return $employee;
            })
            ->filter(function($employee) use ($company) {
                // Filter out employees that are already in the permanent employees list
                return !$company->employees->contains('employee_id', $employee->employee_id);
            });
        
        // Merge part-time hired employees with regular employees
        $company->part_time_hired = $partTimeHiredEmployees;
        
        // Get available part-time employees (not assigned to any company permanently)
        $availablePartTimeEmployees = Employee::where('employment_type', 'part-time')
            ->whereNull('company_id')
            ->get()
            ->map(function ($employee) {
                // Get employee's available days (automatically cast to array)
                $availableDays = $employee->days_available;
                
                // Ensure it's an array
                if (!is_array($availableDays)) {
                    $availableDays = json_decode($availableDays, true) ?? [];
                }
                
                // Get all active assignments (from any company, any week)
                $assignments = PartTimeAssignment::where('employee_id', $employee->employee_id)
                    ->get();
                
                // Collect all assigned days across all companies
                $assignedDays = [];
                foreach ($assignments as $assignment) {
                    $days = $assignment->assigned_days;
                    // Ensure it's an array
                    if (!is_array($days)) {
                        $days = json_decode($days, true) ?? [];
                    }
                    $assignedDays = array_merge($assignedDays, $days);
                }
                $assignedDays = array_unique($assignedDays);
                
                // Calculate remaining days
                $remainingDays = array_diff($availableDays, $assignedDays);
                
                // Add remaining_days to employee object
                $employee->remaining_days = array_values($remainingDays);
                $employee->assigned_days = $assignedDays;
                
                return $employee;
            })
            ->filter(function ($employee) {
                // Only show employees with at least one day available
                return count($employee->remaining_days) > 0;
            });
        
        return view('company.company-employees', compact('company', 'availablePartTimeEmployees'));
    }
    public function showSchedules($id) {
        // Load company with permanently assigned employees
        $company = Company::with([
            'employees.employeeSchedule' => function($query) use ($id) {
                $query->where('company_id', $id)
                      ->whereNull('end_date');
            },
            'companySchedule'
        ])->find($id);
        
        // Get part-time employees hired for this company (any active assignment)
        $partTimeHiredEmployees = Employee::where('employment_type', 'part-time')
            ->whereNull('company_id')
            ->whereHas('partTimeAssignments', function($query) use ($id) {
                $query->where('company_id', $id);
            })
            ->with([
                'employeeSchedule' => function($query) use ($id) {
                    $query->where('company_id', $id)
                          ->whereNull('end_date');
                },
                'partTimeAssignments' => function($query) use ($id) {
                    $query->where('company_id', $id)
                          ->latest('week_start');
                }
            ])
            ->get()
            ->map(function($employee) {
                // For part-time hired employees, override days_available with company-specific assigned days
                $assignment = $employee->partTimeAssignments->first();
                if ($assignment) {
                    $employee->days_available_for_company = $assignment->assigned_days;
                }
                return $employee;
            });
        
        // Merge part-time hired employees with regular employees
        $allEmployees = $company->employees->merge($partTimeHiredEmployees);
        $company->setRelation('employees', $allEmployees);

        return view('company.company-schedules', compact('company'));
    }

    public function showEmployeeAssign($id) {
        $company = Company::with('employees')->find($id);
        $employees = Employee::whereNull('company_id')->get();
        return view('company.company-employee-assignment', compact('employees', 'company'));
    }

    public function showEmployeeUnassign($id) {
        $company = Company::with('employees')->find($id);
        
        // Get permanently assigned employees
        $permanentEmployees = Employee::where('company_id', $id)->get();
        
        // Get part-time employees hired (any active assignment)
        $partTimeHiredEmployees = Employee::where('employment_type', 'part-time')
            ->whereNull('company_id')
            ->whereHas('partTimeAssignments', function($query) use ($id) {
                $query->where('company_id', $id);
            })
            ->with(['partTimeAssignments' => function($query) use ($id) {
                $query->where('company_id', $id)
                      ->latest('week_start');
            }])
            ->get()
            ->map(function($employee) {
                $assignment = $employee->partTimeAssignments->first();
                if ($assignment) {
                    $employee->hired_days = $assignment->assigned_days;
                    $employee->is_part_time_hired = true;
                }
                return $employee;
            });
        
        // Merge both collections
        $employees = $permanentEmployees->merge($partTimeHiredEmployees);
        
        return view('company.employee-unassign', compact('company', 'employees'));
    }

    public function assignEmployees(Request $request, $companyId)
    {
       $this->employeeAssign->assignEmployees($request, $companyId);
        return back();
    }

    public function unassignEmployees(Request $request, $companyId) {
        $this->employeeAssign->unassign($request, $companyId);
        return redirect()->route('company.dashboard.employees', ['id' => $companyId])
            ->with('success', 'Employee(s) unassigned successfully.');
    }

    public function createSchedule(CreateScheduleRequest $request, $id) {
        $validated = $request->validated();
        
        // Get the selected employee (can be regular employee or part-time hired)
        $employee = Employee::where('employee_id', $validated['employee_id'])
            ->first();
        
        if (!$employee) {
            return back()->with('error', 'Employee not found.');
        }
        
        // Verify employee is accessible to this company
        $isRegularEmployee = $employee->company_id == $id;
        $weekStart = Carbon::now()->startOfWeek();
        $partTimeAssignment = PartTimeAssignment::where('employee_id', $employee->employee_id)
                                  ->where('company_id', $id)
                                  ->where('week_start', $weekStart)
                                  ->first();
        $isPartTimeHired = $employee->employment_type === 'part-time' && $partTimeAssignment;
        
        if (!$isRegularEmployee && !$isPartTimeHired) {
            return back()->with('error', 'Employee not assigned to this company.');
        }
        
        // For part-time employees, validate that working days match hired days
        if ($employee->employment_type === 'part-time' && $partTimeAssignment) {
            $hiredDays = $partTimeAssignment->assigned_days;
            $submittedDays = $validated['working_days'];
            
            // Convert full day names to short format for comparison
            $dayMap = [
                'Monday' => 'Mon',
                'Tuesday' => 'Tues',
                'Wednesday' => 'Wed',
                'Thursday' => 'Thurs',
                'Friday' => 'Fri',
                'Saturday' => 'Sat',
                'Sunday' => 'Sun'
            ];
            $hiredDaysShort = array_map(function($day) use ($dayMap) {
                return $dayMap[$day] ?? $day;
            }, $hiredDays);
            
            // Check if submitted days are within hired days
            $invalidDays = array_diff($submittedDays, $hiredDaysShort);
            if (!empty($invalidDays)) {
                return back()->with('error', 'Cannot schedule part-time employee on days not hired: ' . implode(', ', $invalidDays));
            }
        }
        
        // End previous schedules for this employee at this company
        EmployeeSchedule::where('employee_id', $employee->employee_id)
            ->where('company_id', $id)
            ->whereNull('end_date')
            ->update(['end_date' => now()]);
        
        // Determine start_date and end_date based on employment type
        $startDate = $employee->contract_start ?? now();
        $endDate = null;
        
        if ($employee->employment_type === 'contractual' && $employee->contract_end) {
            $endDate = $employee->contract_end;
        }
        
        // Create new schedule for the selected employee
        EmployeeSchedule::create([
            'employee_id' => $employee->employee_id,
            'company_id' => $id,
            'working_days' => $validated['working_days'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'shift_name' => ucfirst($employee->employment_type) . ' Shift',
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        return back()->with('success', 'Schedule saved for ' . $employee->first_name . ' ' . $employee->last_name);
    }

    public function showLocationChange(string $id)
    {
        $company = Company::with('employees')
            ->find($id);
        return view('company.company-location', compact('id', 'company'))->with(['title' => 'Change Company Location']);
    }

    public function storeUpdatedClientAddress(CompanyAddressRequest $request, $id)
    {
        $this->updateCompanyAddress->updateAddress($request->validated(),$id);

        return redirect()->route('company.dashboard.detail', ['id' => $id]);
    }

    public function manualAttendance()
    {
        $companies = Company::all();

        return view('company.manual-attendance', compact('companies'));
    }

    public function edit($id)
    {
        $company = Company::where('company_id', $id)->firstOrFail();

        return view('company.company-information-edit', compact('company'))
            ->with('title', 'Edit Company');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'company_name' => 'nullable|string|max:255',
            'first_name'   => 'nullable|string|max:255',
            'last_name'    => 'nullable|string|max:255',
            'industry'     => 'nullable|string|max:255',
            'tin_number'   => [
                'nullable',
                'regex:/^[\d-]{11,15}$/',
                Rule::unique('companies', 'tin_number')
                    ->ignore($id, 'company_id'),
            ],
            'company_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if (
            isset($validated['tin_number']) &&
            Employee::where('tin_number', $validated['tin_number'])->exists()
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'tin_number' => 'This TIN number is already assigned to an employee.'
                ]);
        }

        $company = Company::where('company_id', $id)->firstOrFail();

        $companyName = ucwords(strtolower($request->input('company_name')));
        $industry = ucwords(strtolower($request->input('industry')));

        $companyExists = Company::where('company_name', $companyName)
            ->where('industry', $industry)
            ->where('company_id', '!=', $id)
            ->exists();

        $adminExists = Admin::where('company_name', $companyName)->exists();

        if ($companyExists || $adminExists) {
            return back()->withErrors([
                'company_name' => $adminExists
                    ? 'This is your company name.'
                    : 'A company with the same name and industry already exists.',
            ])->withInput();
        }

        if ($request->hasFile('company_logo')) {
            if ($company->company_logo) {
                Storage::disk('public')->delete($company->company_logo);
            }

            $validated['company_logo'] = $request
                ->file('company_logo')
                ->store('company-logos', 'public');
        }

        $validated = array_filter($validated, fn ($value) => !is_null($value));

        $company->update($validated);

         if ($company->wasChanged()) {
            return redirect()
                ->route('company.dashboard.detail', $id)
                ->with('success', 'Company information updated.');
        }

        return redirect()->route('company.dashboard.detail', $id);
    }

    public function destroy($id)
    {
        $company = Company::withCount('employees')
            ->where('company_id', $id)
            ->firstOrFail();

        if ($company->employees_count > 0) {
            return back()->with('error', 
                'Cannot delete this company while employees are still assigned.'
            );
        }

        if ($company->company_logo) {
            Storage::disk('public')->delete($company->company_logo);
        }

        $company->delete();

        return redirect()
            ->route('company.dashboard')
            ->with('success', 'Company deleted successfully.');
    }

    public function hirePartTimeEmployee(Request $request, $companyId)
    {
        try {
            $request->validate([
                'employee_id' => 'required|exists:employees,employee_id',
                'selected_days' => 'required|array|min:1',
            ]);

            $employeeId = $request->employee_id;
            $selectedDays = $request->selected_days;

            $weekStart = Carbon::now()->startOfWeek();
            $weekEnd = Carbon::now()->endOfWeek();

            // Get all assignments for this employee this week
            $allAssignments = PartTimeAssignment::where('employee_id', $employeeId)
                ->where('week_start', $weekStart)
                ->get();

            $allAssignedDays = [];
            foreach ($allAssignments as $assignment) {
                $days = $assignment->assigned_days;
                // Ensure it's an array
                if (!is_array($days)) {
                    $days = json_decode($days, true) ?? [];
                }
                $allAssignedDays = array_merge($allAssignedDays, $days);
            }
            $allAssignedDays = array_unique($allAssignedDays);
            
            // Check for conflicts
            $conflictingDays = array_intersect($selectedDays, $allAssignedDays);
            
            if (!empty($conflictingDays)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Employee is already assigned for: ' . implode(', ', $conflictingDays)
                ], 400);
            }

            // Create or update assignment for this company
            $existingAssignmentForCompany = PartTimeAssignment::where('employee_id', $employeeId)
                ->where('company_id', $companyId)
                ->where('week_start', $weekStart)
                ->first();

            if ($existingAssignmentForCompany) {
                $existingDays = $existingAssignmentForCompany->assigned_days;
                // Ensure it's an array
                if (!is_array($existingDays)) {
                    $existingDays = json_decode($existingDays, true) ?? [];
                }
                $companyAssignedDays = array_unique(array_merge(
                    $existingDays,
                    $selectedDays
                ));
                $existingAssignmentForCompany->update(['assigned_days' => $companyAssignedDays]);
            } else {
                PartTimeAssignment::create([
                    'employee_id' => $employeeId,
                    'company_id' => $companyId,
                    'assigned_days' => $selectedDays,
                    'week_start' => $weekStart,
                    'week_end' => $weekEnd,
                ]);
            }

            // Check if all days are now assigned
            $employee = Employee::find($employeeId);
            $totalAvailableDays = $employee->days_available;
            // Ensure it's an array
            if (!is_array($totalAvailableDays)) {
                $totalAvailableDays = json_decode($totalAvailableDays, true) ?? [];
            }
            
            $newTotalAssignedDays = array_unique(array_merge($allAssignedDays, $selectedDays));
            
            // Part-time employees should NEVER have company_id set, even if all days are hired
            // They remain as part-time across multiple companies
            $employee->update(['company_id' => null]);
            
            if (count($newTotalAssignedDays) >= count($totalAvailableDays)) {
                $message = 'Part-time employee hired for all available days. Employee will appear in all companies that hired them.';
            } else {
                $message = 'Part-time employee hired successfully for ' . implode(', ', $selectedDays) . '. Still available for other days.';
            }

            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            \Log::error('Part-time hiring error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while hiring: ' . $e->getMessage()
            ], 500);
        }
    }
}
