<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRegisterRequest;
use App\Services\Auth\AdminService;

class AuthController extends Controller
{
    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function showForm()
    {
        return view('admin.admin');
    }

    public function register(AdminRegisterRequest $request)
    {
        $this->adminService->createAdmin($request->validated());

        return redirect()->route('admin.onboarding')->with('success', 'Admin registered successfully!');
        // TODO: change routes and view to dashboard
        // TODO: make dashboard
    }
}
