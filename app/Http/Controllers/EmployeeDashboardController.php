<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class EmployeeDashboardController extends Controller
{

    public function showDashboard() {
        return view('employeeDashboard');
    }

    public function showStep1() {
        return view('employee.addEmp1');
    }
}
