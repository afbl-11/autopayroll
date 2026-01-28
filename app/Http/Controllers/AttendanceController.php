<?php

namespace App\Http\Controllers;

use App\Services\AttendanceReport;
use App\Services\Payroll\AttendancePayrollService;
use App\Models\AttendanceLogs;
use App\Models\DailyPayrollLog;
use App\Models\Employee;
use App\Models\Company;
use App\Models\EmployeeSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AttendanceController extends Controller
{
    public function __construct(
        protected AttendanceReport $report,
    ){}

    public function showAttendance($id)
    {
        return view(
            'employee.employee-attendance',
            $this->report->data($id)
        )->with('title','Employee Attendance');
    }


    // Manual Attendance Controller added here:

    public function employees($companyId)
    {
        $adminId = auth('admin')->id();
        // Fetch only permanent employees (company_id assigned)
        $employees = Employee::where('admin_id', $adminId)
            ->where('company_id', $companyId)
            ->get()
            ->map(fn ($e) => [
                'employee_id'   => $e->employee_id,
                'employee_name' => trim($e->first_name.' '.$e->last_name),
                'first_name' => $e->first_name,
                'last_name' => $e->last_name,
                'employment_type' => $e->employment_type,
                'days_available' => null, // Permanent employees don't have restricted days
            ]);

        return response()->json(['data' => $employees]);
    }

    public function partTimeEmployees($companyId)
    {
        $adminId = auth('admin')->id();
        // Fetch part-time employees assigned to this company through part_time_assignments table
        $partTimeEmployees = DB::table('part_time_assignments')
            ->join('employees', 'part_time_assignments.employee_id', '=', 'employees.employee_id')
            ->where('employees.admin_id', $adminId)
            ->where('part_time_assignments.company_id', $companyId)
            ->select(
                'employees.employee_id',
                DB::raw("TRIM(CONCAT(employees.first_name, ' ', employees.last_name)) as employee_name"),
                'employees.first_name',
                'employees.last_name',
                'employees.employment_type',
                'part_time_assignments.assigned_days as days_available',
                'part_time_assignments.week_start',
                'part_time_assignments.week_end'
            )
            ->get()
            ->map(fn ($e) => (array) $e);

        return response()->json(['data' => $partTimeEmployees]);
    }

    public function allPartTimeEmployees()
    {
        $adminId = auth('admin')->id();
        // Fetch ALL part-time employees from part_time_assignments table
        $partTimeEmployees = DB::table('part_time_assignments')
            ->join('employees', 'part_time_assignments.employee_id', '=', 'employees.employee_id')
            ->where('employees.admin_id', $adminId)
            ->select(
                'employees.employee_id',
                DB::raw("TRIM(CONCAT(employees.first_name, ' ', employees.last_name)) as employee_name"),
                'employees.first_name',
                'employees.last_name',
                'employees.employment_type',
                'part_time_assignments.company_id',
                'part_time_assignments.assigned_days as days_available',
                'part_time_assignments.week_start',
                'part_time_assignments.week_end'
            )
            ->get()
            ->map(fn ($e) => (array) $e);

        return response()->json(['data' => $partTimeEmployees]);
    }

    public function attendanceDates($companyId)
    {
        $adminId = auth('admin')->id();
        $dates = AttendanceLogs::where('admin_id', $adminId)
            ->where('company_id', $companyId)
            ->selectRaw('DISTINCT log_date as date')
            ->orderBy('date')
            ->get();

        return response()->json(['data' => $dates]);
    }

    public function attendanceByDate($companyId, $date)
    {
        $adminId = auth('admin')->id();
        $logs = AttendanceLogs::where('admin_id', $adminId)
            ->where([
                'company_id' => $companyId,
                'log_date'   => $date,
            ])->get();

        $result = [];

        foreach ($logs as $log) {
            // For manual attendance, use time_in/time_out
            // For clock-in attendance, use clock_in_time/clock_out_time
            $timeIn = $log->is_manual ? $log->time_in : ($log->clock_in_time ? date('H:i', strtotime($log->clock_in_time)) : null);
            $timeOut = $log->is_manual ? $log->time_out : ($log->clock_out_time ? date('H:i', strtotime($log->clock_out_time)) : null);
            
            $result[$log->employee_id] = [
                'status'   => $log->status,
                'time_in'  => $timeIn,
                'time_out' => $timeOut,
                'is_manual' => $log->is_manual ?? false,
            ];
        }

        return response()->json(['data' => $result]);
    }

    public function bulkSave(Request $request)
    {
        $request->validate([
            'company_id' => 'required',
            'date'       => 'required|date',
            'records'    => 'required|array',
        ]);

        DB::beginTransaction();

        try {
            $adminId = auth('admin')->id() ?? auth('admin')->user()?->admin_id ?? 1;
            $payrollService = new AttendancePayrollService();
            
            foreach ($request->records as $employeeId => $data) {
                
                // Convert time to datetime by combining with the date
                $clockInTime = null;
                $clockOutTime = null;
                $timeIn = null;
                $timeOut = null;
                
                if (!empty($data['time_in'])) {
                    // Check if time already has seconds
                    $timeIn = $data['time_in'];
                    if (substr_count($timeIn, ':') === 1) {
                        $timeIn .= ':00'; // Add seconds only if not present
                    }
                    $clockInTime = $request->date . ' ' . $timeIn;
                }
                
                if (!empty($data['time_out'])) {
                    // Check if time already has seconds
                    $timeOut = $data['time_out'];
                    if (substr_count($timeOut, ':') === 1) {
                        $timeOut .= ':00'; // Add seconds only if not present
                    }
                    $clockOutTime = $request->date . ' ' . $timeOut;
                }

                // Save attendance
                $attendanceLog = AttendanceLogs::withoutGlobalScope(\App\Models\Scopes\AdminScope::class)
                    ->updateOrCreate(
                        [
                            'company_id'  => $request->company_id,
                            'employee_id' => $employeeId,
                            'log_date'    => $request->date,
                        ],
                        [
                            'admin_id'       => $adminId,
                            'status'         => $data['status'],
                            'time_in'        => $timeIn,
                            'time_out'       => $timeOut,
                            'clock_in_time'  => $clockInTime,
                            'clock_out_time' => $clockOutTime,
                            'is_adjusted'    => 1,
                            'is_manual'      => 1,
                        ]
                    );
                
                // Immediately sync this attendance to payroll
                try {
                    $payrollService->syncAttendanceToPayroll(
                        $employeeId,
                        $request->date,
                        $request->company_id
                    );
                } catch (\Exception $e) {
                    \Log::error('Payroll sync failed for employee: ' . $employeeId, [
                        'error' => $e->getMessage(),
                        'date' => $request->date
                    ]);
                    // Continue with other records even if one fails
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Attendance and payroll saved successfully'
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();
            
            \Log::error('Bulk save error: ' . $e->getMessage(), [
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => basename($e->getFile())
            ], 500);
        }
    }

    public function createDate(Request $request)
    {
        $request->validate([
            'company_id' => 'required',
            'date'       => 'required|date',
        ]);

        $exists = AttendanceLogs::where([
            'company_id' => $request->company_id,
            'log_date'   => $request->date,
        ])->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Date already exists'
            ], 422);
        }

        return response()->json(['message' => 'Date created']);
    }

    public function deleteDate(Request $request)
    {
        $request->validate([
            'company_id' => 'required',
            'date'       => 'required|date',
        ]);

        try {
            DB::beginTransaction();

            // FIRST: Get employee IDs from attendance logs BEFORE deleting
            // This ensures we only delete payroll for employees who had attendance at THIS company on THIS date
            $employeeIds = AttendanceLogs::where('company_id', $request->company_id)
                ->where('log_date', $request->date)
                ->pluck('employee_id')
                ->unique()
                ->toArray();

            // Delete attendance logs for this date and company
            $deletedAttendance = AttendanceLogs::where('company_id', $request->company_id)
                ->where('log_date', $request->date)
                ->delete();

            // Delete daily payroll logs ONLY for employees who had attendance at this company on this date
            // This prevents deleting payroll from other companies for part-time employees
            $deletedPayroll = 0;
            if (!empty($employeeIds)) {
                $deletedPayroll = DailyPayrollLog::withoutGlobalScope(\App\Models\Scopes\AdminScope::class)
                    ->whereIn('employee_id', $employeeIds)
                    ->where('payroll_date', $request->date)
                    ->delete();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Date deleted successfully',
                'deleted_attendance' => $deletedAttendance,
                'deleted_payroll' => $deletedPayroll
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Delete date error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete date: ' . $e->getMessage()
            ], 500);
        }
    }

    // Manual Input Attendance Methods
    
    public function verifyCompanyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);
        
        // The code is the company_id itself for simplicity
        $company = Company::where('company_id', $request->code)->first();
        
        if ($company) {
            return response()->json([
                'success' => true,
                'company_id' => $company->company_id,
                'company_name' => $company->company_name
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Invalid company code'
        ], 401);
    }
    
    public function getCompanyEmployees($companyId)
    {
        // Handle part-time employees
        if ($companyId === 'part-time') {
            $date = request('date');
            
            if (!$date) {
                return response()->json([]);
            }
            
            // Get day of week from date (e.g., "Monday", "Tuesday", etc.)
            $dayOfWeek = \Carbon\Carbon::parse($date)->format('l');
            
            // Get all part-time employees (where employment_type is 'part-time')
            $employees = Employee::where('employment_type', 'part-time')
                ->with(['employeeSchedule' => function($query) {
                    $query->whereNull('end_date')->orWhere('end_date', '>=', now());
                }])
                ->get()
                ->filter(function($emp) use ($dayOfWeek) {
                    // Filter by days_available
                    $daysAvailable = $emp->days_available;
                    
                    // Ensure it's an array
                    if (!is_array($daysAvailable)) {
                        $daysAvailable = json_decode($daysAvailable, true) ?? [];
                    }
                    
                    return in_array($dayOfWeek, $daysAvailable);
                })
                ->map(function($emp) {
                    $schedule = $emp->employeeSchedule->first();
                    return [
                        'employee_id' => $emp->employee_id,
                        'first_name' => $emp->first_name,
                        'last_name' => $emp->last_name,
                        'employment_type' => $emp->employment_type,
                        'schedule_start' => $schedule ? substr($schedule->start_time, 0, 5) : null,
                        'schedule_end' => $schedule ? substr($schedule->end_time, 0, 5) : null,
                    ];
                })
                ->values();
            
            return response()->json($employees);
        }
        
        // Handle regular company employees
        $employees = Employee::where('company_id', $companyId)
            ->with(['employeeSchedule' => function($query) {
                $query->whereNull('end_date')->orWhere('end_date', '>=', now());
            }, 'partTimeAssignments'])
            ->get()
            ->map(function($emp) {
                $schedule = $emp->employeeSchedule->first();
                return [
                    'employee_id' => $emp->employee_id,
                    'first_name' => $emp->first_name,
                    'last_name' => $emp->last_name,
                    'employment_type' => $emp->employment_type,
                    'days_available' => $emp->partTimeAssignments->first() ? json_decode($emp->partTimeAssignments->first()->days_available) : null,
                    'schedule_start' => $schedule ? substr($schedule->start_time, 0, 5) : null,
                    'schedule_end' => $schedule ? substr($schedule->end_time, 0, 5) : null,
                ];
            });
        
        return response()->json($employees);
    }
    
    public function saveManualAttendance(Request $request)
    {
        DB::beginTransaction();
        
        try {
            $request->validate([
                'company_id' => 'required|exists:companies,company_id',
                'employee_id' => 'required|exists:employees,employee_id',
                'datetime_in' => 'required',
                'datetime_out' => 'nullable',
                'status' => 'nullable|string|in:P,A,LT,O,OT,RH,SH,DO,CD,CDO'
            ]);
            
            // Parse datetime
            $datetimeIn = new \DateTime($request->datetime_in);
            $attendanceDate = $datetimeIn->format('Y-m-d');
            $timeIn = $datetimeIn->format('H:i:s');
            $clockInTime = $datetimeIn->format('Y-m-d H:i:s');
            $timeOut = null;
            $clockOutTime = null;
        
            if ($request->datetime_out) {
                $datetimeOut = new \DateTime($request->datetime_out);
                $timeOut = $datetimeOut->format('H:i:s');
                $clockOutTime = $datetimeOut->format('Y-m-d H:i:s');
            }
        
            // Check if attendance already exists
            $exists = AttendanceLogs::withoutGlobalScope(\App\Models\Scopes\AdminScope::class)
                ->where('company_id', $request->company_id)
                ->where('employee_id', $request->employee_id)
                ->where('log_date', $attendanceDate)
                ->exists();
            
            if ($exists) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Attendance already recorded for this date'
                ], 422);
            }
        
            // Use provided status or calculate if not provided
            if ($request->has('status') && $request->status) {
                $status = $request->status;
            } else {
                // Calculate status only if not provided
                $employee = Employee::with(['employeeSchedule' => function($query) {
                    $query->whereNull('end_date')->orWhere('end_date', '>=', now());
                }])->find($request->employee_id);
            
                $schedule = $employee->employeeSchedule->first();
                $status = 'P'; // Default: Present
            
                if ($schedule) {
                    $scheduleStart = strtotime($schedule->start_time);
                    $timeInSeconds = strtotime($timeIn);
                
                    // Late if more than 5 minutes after schedule start
                    if ($timeInSeconds > $scheduleStart + 300) {
                        $status = 'LT';
                    }
                
                    // Check undertime if time_out provided
                    if ($timeOut && $schedule->end_time) {
                        $scheduleEnd = strtotime($schedule->end_time);
                        $timeOutSeconds = strtotime($timeOut);
                    
                        if ($timeOutSeconds < $scheduleEnd - 300) {
                            $status = 'LT';
                        }
                    }
                }
            }
        
            // Create attendance log
            $adminId = auth('admin')->id() ?? auth('admin')->user()?->admin_id ?? 1;
            
            AttendanceLogs::withoutGlobalScope(\App\Models\Scopes\AdminScope::class)
                ->create([
                    'admin_id' => $adminId,
                    'company_id' => $request->company_id,
                    'employee_id' => $request->employee_id,
                    'log_date' => $attendanceDate,
                    'time_in' => $timeIn,
                    'time_out' => $timeOut,
                    'clock_in_time' => $clockInTime,
                    'clock_out_time' => $clockOutTime,
                    'status' => $status,
                    'is_manual' => true,
                    'is_adjusted' => 1
                ]);
            
            // Automatically sync to payroll
            try {
                $payrollService = new AttendancePayrollService();
                $payrollService->syncAttendanceToPayroll(
                    $request->employee_id,
                    $attendanceDate,
                    $request->company_id
                );
            } catch (\Exception $e) {
                \Log::error('Payroll sync failed in manual attendance modal', [
                    'employee_id' => $request->employee_id,
                    'date' => $attendanceDate,
                    'error' => $e->getMessage()
                ]);
                // Continue even if payroll sync fails
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Attendance and payroll recorded successfully'
            ]);
        
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving attendance: ' . $e->getMessage()
            ], 500);
        }
    }
}