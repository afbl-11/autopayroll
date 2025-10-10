<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;

class EmployeeDashboardController extends Controller
{

    public function showDashboard() {

        return view('employeeDashboard')->with('title','Employee Dashboard');
    }

    public function showStep1() {
        $title = 'Add Employee';
        return view('employee.addEmp1', compact('title'));
    }
}
