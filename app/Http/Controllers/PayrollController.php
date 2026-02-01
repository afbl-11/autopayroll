<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\DailyPayrollLog;
use App\Services\Payroll\PayrollComputation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    public function __construct(protected PayrollComputation $payroll){}

    public function index() {

    }

    public function showPayrollList(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('m'));
        $companyFilter = $request->get('company', '');
        $adminId = auth('admin')->id();

        // Get only employees who have payroll data for the selected month
        $employeeIds = DailyPayrollLog::withoutGlobalScope(\App\Models\Scopes\AdminScope::class)
            ->whereYear('payroll_date', $year)
            ->whereMonth('payroll_date', $month)
            ->distinct()
            ->pluck('employee_id');

        $employeesQuery = Employee::with(['currentRate', 'company'])
            ->where('admin_id', $adminId)
            ->whereIn('employee_id', $employeeIds);

        // Apply company filter
        if ($companyFilter === 'part-time') {
            $employeesQuery->where('employment_type', 'part-time');
        } elseif ($companyFilter) {
            $employeesQuery->whereHas('company', function($q) use ($companyFilter) {
                $q->where('company_name', $companyFilter);
            });
        }

        $employees = $employeesQuery->get()
            ->map(function ($employee) use ($year, $month) {
                // Get payroll summary for 1-15 period
                $payrollData1to15 = DailyPayrollLog::withoutGlobalScope(\App\Models\Scopes\AdminScope::class)
                    ->where('employee_id', $employee->employee_id)
                    ->whereYear('payroll_date', $year)
                    ->whereMonth('payroll_date', $month)
                    ->whereDay('payroll_date', '<=', 15)
                    ->selectRaw('COUNT(*) as days_worked,
                                SUM(gross_salary + overtime + night_differential) as gross_pay')
                    ->first();

                // Get payroll summary for 16-31 period
                $payrollData16to31 = DailyPayrollLog::withoutGlobalScope(\App\Models\Scopes\AdminScope::class)
                    ->where('employee_id', $employee->employee_id)
                    ->whereYear('payroll_date', $year)
                    ->whereMonth('payroll_date', $month)
                    ->whereDay('payroll_date', '>', 15)
                    ->selectRaw('COUNT(*) as days_worked,
                                SUM(gross_salary + overtime + night_differential) as gross_pay')
                    ->first();

                $employee->days_worked_1to15 = $payrollData1to15->days_worked ?? 0;
                $employee->gross_pay_1to15 = $payrollData1to15->gross_pay ?? 0;
                $employee->days_worked_16to31 = $payrollData16to31->days_worked ?? 0;
                $employee->gross_pay_16to31 = $payrollData16to31->gross_pay ?? 0;

                return $employee;
            });

        // Get list of unique companies for filter
        $companies = collect([]);
        if ($employeeIds->isNotEmpty()) {
            $companies = Employee::with('company')
                ->withoutGlobalScope(\App\Models\Scopes\AdminScope::class)
                ->whereIn('employee_id', $employeeIds)
                ->where('employment_type', '!=', 'part-time')
                ->get()
                ->pluck('company.company_name')
                ->filter()
                ->unique()
                ->sort()
                ->values();
        }

        // Get available years from payroll logs
        $years = DailyPayrollLog::withoutGlobalScope(\App\Models\Scopes\AdminScope::class)
            ->selectRaw('DISTINCT YEAR(payroll_date) as year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        // Ensure years has at least current year
        if ($years->isEmpty()) {
            $years = collect([date('Y')]);
        }

        return view('payroll.payroll-list', compact('employees', 'year', 'month', 'years', 'companies', 'companyFilter'))
            ->with('title', 'Payroll Management');
    }

    public function showSalaryList(Request $request)
    {
        $companyFilter = $request->get('company', '');
        $searchTerm = $request->get('search', '');
        $adminId = auth('admin')->id();

        // Get all employees with their current rates
        $employeesQuery = Employee::with(['currentRate', 'company'])
            ->where('admin_id', $adminId);

        // Apply company filter
        if ($companyFilter === 'part-time') {
            $employeesQuery->where('employment_type', 'part-time');
        } elseif ($companyFilter) {
            $employeesQuery->whereHas('company', function($q) use ($companyFilter) {
                $q->where('company_name', $companyFilter);
            });
        }

        // Apply search filter
        if ($searchTerm) {
            $employeesQuery->where(function($q) use ($searchTerm) {
                $q->where('first_name', 'like', "%{$searchTerm}%")
                  ->orWhere('last_name', 'like', "%{$searchTerm}%")
                  ->orWhere('employee_id', 'like', "%{$searchTerm}%");
            });
        }

        $employees = $employeesQuery->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        // Get list of unique companies for filter
        $companies = Employee::with('company')
            ->withoutGlobalScope(\App\Models\Scopes\AdminScope::class)
            ->where('employment_type', '!=', 'part-time')
            ->get()
            ->pluck('company.company_name')
            ->filter()
            ->unique()
            ->sort()
            ->values();

        return view('payroll.salary-list', compact('employees', 'companies', 'companyFilter', 'searchTerm'))
            ->with('title', 'Salary Management');
    }
}
