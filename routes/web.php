<?php

use App\Http\Controllers\AdminRegistrationController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\ClientRegistrationController;
use App\Http\Controllers\CompanyDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeDashboardController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PayrollController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\EmployeeRegistrationController;



Route::get('/', function () {
    return view('welcome');
});
/**admin registration*/
Route::get('/register/admin/credentials', [AdminRegistrationController::class, 'showStep1'])
    ->name('auth.register.step1');
Route::get('/register/admin/address', [AdminRegistrationController::class, 'showStep2'])
    ->name('auth.register.step2');
Route::post('/register/admin/success', [AdminRegistrationController::class, 'register'])
    ->name('admin.register');
Route::post('/register/admin/personal-info', [AdminRegistrationController::class, 'storeStep1'])
    ->name('auth.store.step1');


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
Route::post('/logout', [LogoutController::class, 'logout'])
    ->middleware('auth:admin')
    ->name('logout');

/**company registration TODO:protect route */
Route::get('/company/register', [ClientRegistrationController::class, 'showForm'])
    ->middleware(['auth:admin'])
    ->name('show.register.client');

Route::post('/company/register/store', [ClientRegistrationController::class, 'storeBasicInformation'])
    ->middleware(['auth:admin'])
    ->name('store.register.client');

Route::get('/company/register/address', [ClientRegistrationController::class, 'showCompanyMap'])
    ->middleware(['auth:admin'])
    ->name('show.register.client.map');

Route::post('/company/register/address/store', [ClientRegistrationController::class, 'storeAddress'])
    ->middleware(['auth:admin'])
    ->name('store.client.address');

Route::get('/company/register/review', [ClientRegistrationController::class, 'showReview'])
    ->middleware(['auth:admin'])
    ->name('show.client.register.review');

Route::post('/company/register/attempt', [ClientRegistrationController::class, 'register'])
    ->middleware(['auth:admin'])
    ->name('register.client');

//company dashboard
Route::get('/dashboard/company', [CompanyDashboardController::class, 'index'])
    ->middleware(['auth:admin'])
    ->name('company.dashboard');

Route::get('/company/detail/{id}', [CompanyDashboardController::class, 'showInfo'])
    ->middleware(['auth:admin'])
    ->name('company.dashboard.detail');

Route::get('company/employees/{id}', [CompanyDashboardController::class, 'showEmployees'])
    ->middleware(['auth:admin'])
    ->name('company.dashboard.employees');

Route::get('company/schedules/{id}', [CompanyDashboardController::class, 'showSchedules'])
    ->middleware(['auth:admin'])
    ->name('company.dashboard.schedules');

Route::get('company/location/{id}', [CompanyDashboardController::class, 'showLocation'])
    ->middleware(['auth:admin'])
    ->name('company.dashboard.location');

Route::get('company/employee/assign/{id}', [CompanyDashboardController::class, 'showEmployeeAssign'])
    ->middleware(['auth:admin'])
    ->name('company.employee.assign');

Route::get('/company/employee/unassign/{id}', [CompanyDashboardController::class, 'showEmployeeUnassign'])
    ->middleware('auth:admin')
    ->name('company.employee.unassign');

Route::post('/company/{company}/employee/assign', [CompanyDashboardController::class, 'assignEmployees'])
    ->middleware(['auth:admin'])
    ->name('company.employee.assign.save');

Route::post('/company/{company}/employee/unassign', [CompanyDashboardController::class, 'unassignEmployees'])
    ->middleware(['auth:admin'])
    ->name('company.employee.unassign.save');

Route::post('/company/{employee}/schedule/store', [CompanyDashboardController::class, 'store'])
    ->name('company.create.schedule');



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
})->middleware(['auth:admin', 'throttle:6,1']
)->name('verification.send');


//employee dashboard
Route::get('/employee/dashboard', [EmployeeDashboardController::class, 'showDashboard'])
    ->middleware('auth:admin')
    ->name('employee.dashboard');
//only used to filter employees
Route::get('/employees/filter', [EmployeeDashboardController::class, 'filter'])
    ->middleware('auth:admin')
    ->name('employee.filter');

Route::get('dashboard/employee/detail/{id}', [EmployeeDashboardController::class, 'showInfo'])
    ->middleware('auth:admin')
    ->name('employee.dashboard.detail');

Route::get('dashboard/employee/contract/{id}', [EmployeeDashboardController::class, 'showContract'])
    ->middleware('auth:admin')
    ->name('employee.dashboard.contract');

Route::get('dashboard/employee/attendance/{id}', [EmployeeDashboardController::class, 'showAttendance'])
    ->middleware('auth:admin')
    ->name('employee.dashboard.attendance');

Route::get('dashboard/employee/documents/{id}', [EmployeeDashboardController::class, 'showDocuments'])
    ->middleware('auth:admin')
    ->name('employee.dashboard.documents');

Route::get('dashboard/employee/payroll/{id}', [EmployeeDashboardController::class, 'showPayroll'])
    ->middleware('auth:admin')
    ->name('employee.dashboard.payroll');
//employee registration
Route::middleware(['auth:admin', 'verified'])->group(function () {
Route::get('/employees/register/1', [EmployeeDashboardController::class, 'showStep1'])->name('employee.register.1');
Route::get('/employees/register/2', [EmployeeRegistrationController::class, 'showStep2'])->name('employee.register.2');
Route::get('/employees/register/3', [EmployeeRegistrationController::class, 'showStep3'])->name('employee.register.3');
Route::get('/employees/register/4', [EmployeeRegistrationController::class, 'showStep4'])->name('employee.register.4');
Route::get('/employees/register/5', [EmployeeRegistrationController::class, 'showStep5'])->name('employee.register.5');

Route::post('/employees/register/basic', [EmployeeRegistrationController::class, 'storeBasicInformation'])->name('store.employee.register.1');
Route::post('/employees/register/address', [EmployeeRegistrationController::class, 'storeAddress'])->name('store.employee.register.2');
Route::post('/employees/register/designation', [EmployeeRegistrationController::class, 'storeDesignation'])->name('store.employee.register.3');
Route::post('/employees/register/credentials', [EmployeeRegistrationController::class, 'storeCredentials'])->name('store.employee.register.4');
Route::post('/employees/register/create', [EmployeeRegistrationController::class, 'createEmployee'])->name('employee.create');
});

//password management
Route::get('/forgot_password', function () {
    return view('auth.authVerify');
})->name('forgot.password');
