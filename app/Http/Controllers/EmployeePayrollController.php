<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Services\Payroll\PayrollSummary;
use Illuminate\Http\Request;

class EmployeePayrollController extends Controller
{
    public function __construct(
        protected PayrollSummary $payrollSummary,
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


}
