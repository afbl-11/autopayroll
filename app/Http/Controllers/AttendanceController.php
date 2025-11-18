<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\AttendanceReport;

class AttendanceController extends Controller
{
    public function __construct(
        protected AttendanceReport $report,
    ){}
    public function showAttendance($id) {

        return view('employee.employee-attendance',$this->report->data($id))->with('title','Employee Attendance');
    }
}
