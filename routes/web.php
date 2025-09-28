<?php

use App\Http\Controllers\AdminRegistrationController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\ClientRegistrationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeDashboardController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\LoginController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;



Route::get('/', function () {
    return view('auth.admin-register-step1');
});

/**admin registration*/
Route::post('/register/admin/success', [AdminRegistrationController::class, 'register'])->name('admin.register');
Route::post('/register/admin/personal-info', [AdminRegistrationController::class, 'storeStep1'])->name('auth.store.step1');
Route::get('/register/admin/address', [AdminRegistrationController::class, 'showStep2'])->name('auth.register.step2');

//login
Route::get('/login', function () {
    return view('auth.auth');})
    ->name('login');

Route::get('/register/success', function () {
    return view('auth.registrationSuccess');
})->name('register.success');

Route::post('/login/admin', [LoginController::class, 'authenticate'])->name('login.admin');
Route::get('/dashboard', [DashboardController::class, 'showDashboard'])
    ->middleware(['auth:admin'])
    ->name('dashboard');

//logout
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

/**company registration TODO:protect route */
Route::post('/client/onboarding', [ClientRegistrationController::class, 'register'])->name('onboarding.client');
Route::get('client/register', [ClientRegistrationController::class, 'showForm'])->name('register.client');

//email verification
Route::get('/email/verify', function () {
   return view('auth.verify-email');
})->middleware('auth:admin')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('dashboard')->with('verified', true);
})->middleware(['auth:admin', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth:admin', 'throttle:6,1'])->name('verification.send');


//web linking
Route::get('/employees/register=1', [EmployeeDashboardController::class, 'index'])->name('employee.register');
Route::get('/employees/register=2', [EmployeeDashboardController::class, 'showStep2'])->name('employee.register.2');
Route::get('/employees/register=3', [EmployeeDashboardController::class, 'showStep3'])->name('employee.register.3');
Route::get('/employees/register=4', [EmployeeDashboardController::class, 'showStep4'])->name('employee.register.4');
Route::get('/employees/register=5', [EmployeeDashboardController::class, 'showStep5'])->name('employee.register.5');




