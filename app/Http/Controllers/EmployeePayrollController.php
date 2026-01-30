<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Services\Payroll\PayrollSummary;
use App\Services\Payroll\MonthlyPayslipService;
use Illuminate\Http\Request;

class EmployeePayrollController extends Controller
{
    public function __construct(
        protected PayrollSummary $payrollSummary,
        protected MonthlyPayslipService $payslipService
    )
    {
    }

    public function showPayroll($id, Request $request) {

        $type = $request->get('type','daily');
        $employee = Employee::find($id);
        if ($type === 'daily') {
            $payroll = $this->payrollSummary->showDaily($id);
        }
        else {
            $payroll = $this->payrollSummary->showSemi($id);
        }

        return view('employee.employee-payroll', compact(['employee', 'payroll', 'type']))->with('title', 'Employee Payroll');;
    }

    public function showPayslip($id, Request $request) {
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('m'));
        $period = $request->get('period', '1-15'); // 1-15, 16-30

        $employee = Employee::find($id);

        try {
            $payslipData = $this->payslipService->generateMonthlyPayslip($id, $year, $month, $period);

            if (!$payslipData) {
                return redirect()->back()->with('error', 'No payroll data found for the selected period');
            }

            return view('employee.monthly-payslip', compact('payslipData', 'employee', 'year', 'month', 'period'))
                ->with('title', 'Monthly Payslip');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function printPayslipPDF($id, Request $request) {
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('m'));
        $period = $request->get('period', '1-15'); // 1-15, 16-30

        try {
            $payslipData = $this->payslipService->generateMonthlyPayslip($id, $year, $month, $period);

            if (!$payslipData) {
                return redirect()->back()->with('error', 'No payroll data found for the selected period');
            }

            return view('employee.payslip-pdf', compact('payslipData', 'year', 'month', 'period'));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function showSemiMonthlyPayslip($id, Request $request) {
        return $this->showPayslip($id, $request);
    }


}
