<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\AnnouncementMail;
use App\Models\Announcement;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Scopes\AdminScope;
use App\Repositories\EmployeeRepository;
use App\Services\DashboardService;
use App\Services\LeaveRequestService;
use Illuminate\Support\Facades\Auth;
use Mail;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardService $service,
        protected LeaveRequestService $leaveRequestService,
        protected EmployeeRepository $employeeRepository,
    ){}
    public function showDashboard() {
        $data = $this->service->getDashboardData();

        $employee = $this->leaveRequestService->showAllLeaveRequests();
        $adjustment = $this->service->showAdjustmentRequest();
        $attendance = $this->employeeRepository->getEmployees();

        return view('admin.admin', compact('employee',  'data','adjustment', 'attendance'));
    }


}
