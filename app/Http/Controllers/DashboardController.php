<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Repositories\EmployeeRepository;
use App\Services\DashboardService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardService $service,
    ){}
    public function showDashboard() {
        $data = $this->service->getDashboardData();


        return view('admin.admin', $data);
    }


}
