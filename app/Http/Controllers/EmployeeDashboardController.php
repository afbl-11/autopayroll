<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class EmployeeDashboardController extends Controller
{

    public function showDashboard() {
        return view('employeeDashboard');
    }
    public function index() {
        return view('employee.addEmp1');
    }
    public function showStep2() {
        return view('employee.addEmp2');
    }
    public function showStep3() {
        return view('employee.addEmp3');
    }
    public function showStep4() {
        return view('employee.addEmp4');
    }
    public function showStep5() {
        return view('employee.addEmp5');
    }
}
