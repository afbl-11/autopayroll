<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRegisterAddress;
use App\Http\Requests\AdminRegisterPersonal;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $adminService;

    public function __construct(AuthService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function showForm()
    {
        return view('admin.admin');
    }

    public function storeStep1(AdminRegisterPersonal $request) {

        $this->adminService->processStep1($request->validated());
        return redirect()->route('auth.register.step2');

    }
    public function showStep2() {
//        dd(session('register.personal'));
        return view('onboarding.admin-register-step2');
    }
    public function register(AdminRegisterAddress $request)
    {
        $this->adminService->createAdmin($request->validated());
        return redirect()->route('admin.onboarding')->with('success', 'Admin registered successfully!');
    }

}
