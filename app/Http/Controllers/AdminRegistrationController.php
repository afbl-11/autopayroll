<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRegisterAddress;
use App\Http\Requests\AdminRegisterPersonal;
use App\Services\Auth\AdminRegistration;

class AdminRegistrationController extends Controller
{
    public function __construct(
        protected AdminRegistration $adminService,)
    {}

    public function showForm()
    {
        return view('admin_dashboard.admin_dashboard');
    }

    public function storeStep1(AdminRegisterPersonal $request) {

        $this->adminService->processStep1($request->validated());
        return redirect()->route('auth.register.step2');

    }
    public function showStep2() {
//        dd(session('register.personal'));
        return view('admin_registration.admin_dashboard-register-step2');
    }
    public function register(AdminRegisterAddress $request)
    {
        $this->adminService->createAdmin($request->validated());
        return redirect()->route('admin_dashboard.admin_registration')->with('success', 'Admin registered successfully!');
    }

}
