<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRegisterAddress;
use App\Http\Requests\AdminRegisterPersonal;
use App\Services\Auth\AdminRegistration;

class AdminRegistrationController extends Controller
{
    public function __construct(
        protected AdminRegistration $adminService)
    {}

    public function storeStep1(AdminRegisterPersonal $request) {

        $this->adminService->processStep1($request->validated());
        return redirect()->route('auth.register.step2');

    }
    public function showStep2() {
        return view('auth.admin-register-step2');
    }

    public function showAdminDashboard()
    {
        return view('admin.admin');
    }
    public function register(AdminRegisterAddress $request)
    {
        $this->adminService->createAdmin($request->validated());
        return redirect()->route('admin.onboarding')->with('success', 'Admin registered successfully!');
    }

}
