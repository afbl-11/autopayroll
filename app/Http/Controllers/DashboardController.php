<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Scopes\AdminScope;
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
//        $temp  = \App\Models\Company::withoutGlobalScope(AdminScope::class)->get();
        $temp = Auth::guard('admin')->user();


        return view('admin.admin', array_merge($data, ['temp' => $temp]));
    }


}
