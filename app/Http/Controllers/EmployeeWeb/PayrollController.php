<?php

namespace App\Http\Controllers\EmployeeWeb;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Payroll;
use App\Models\Payslip;
use App\Services\Payroll\MonthlyPayslipService;
use App\Services\Payroll\PayrollHistory;
use Auth;
use Illuminate\Http\Request;

class PayrollController extends Controller
{

    public function __construct(
        protected PayrollHistory $payrollHistory,
        protected MonthlyPayslipService $monthlyPayslipService,
    ){}
        public function showPayroll(Request $request){

            $employee = Auth::guard('employee_web')->user();

            $query = Payslip::query();

            if ($request->filled('date_from')) {
                $query->where('pay_date', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->where('pay_date', '<=', $request->date_to);
            }

            if ($request->filled('status') && $request->status !== 'all') {
                $query->where('status', $request->status);
            }

            $payslips = $query->where('employee_id', $employee->employee_id)->orderBy('pay_date', 'desc')->paginate(2)->withQueryString();

            return view('employee_web.payrollViewingModule.payrollScreen', compact('payslips', 'employee'));
        }

    public function showPayslip($id, Request $request) {
        // 1. Capture and sanitize inputs
        $year = $request->query('year', date('Y'));
        $month = $request->query('month', date('m'));
        $period = $request->query('period', '1-15');

        // 2. Use findOrFail to prevent errors if the ID is invalid
        $employee = Employee::find($id);

        try {
            // 3. Pass values to your service
            $payslipData = $this->monthlyPayslipService->generateMonthlyPayslip($id, $year, $month, $period);

//
            if (!$payslipData) {
                // It's better to redirect to the index with a message than 'back'
                // to avoid loop issues if the previous page was the one that failed
                return redirect()->route('web.employee.payroll')
                    ->with('error', 'No payroll data found for the selected period.');
            }

            return view('employee_web.payrollViewingModule.monthly-payslip', [
                'payslipData' => $payslipData,
                'employee' => $employee,
                'year' => $year,
                'month' => $month,
                'period' => $period,
                'title' => 'Monthly Payslip'
            ]);

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error("Payslip Generation Error: " . $e->getMessage());
            return redirect()->route('web.employee.payroll')
                ->with('error', 'An error occurred while generating the payslip.');
        }
    }
}
