<?php

use App\Http\Controllers\AdminRegistrationController;
use App\Http\Controllers\ClientRegistrationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('auth.admin-register-step1');
});

/**admin registration*/
Route::post('/register/admin/success', [AdminRegistrationController::class, 'register'])->name('admin.register');
Route::post('/register/admin/personal-info', [AdminRegistrationController::class, 'storeStep1'])->name('auth.store.step1');
Route::get('/register/admin/address', [AdminRegistrationController::class, 'showStep2'])->name('auth.register.step2');

//login
Route::get('/register/success', function () {
    return view('registrationSuccess');
})->name('register.success');

Route::get('/login', function () {
    return view('auth.auth');})
    ->name('login');

Route::post('/login/admin', [LoginController::class, 'authenticate'])->name('login.admin');

Route::get('/dashboard', [DashboardController::class, 'showDashboard'])
    ->middleware(['auth:admin'])
    ->name('dashboard');

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

/**company registration*/
Route::post('/client/onboarding', [ClientRegistrationController::class, 'register'])->name('onboarding.client');
Route::get('client/register', [ClientRegistrationController::class, 'showForm'])->name('register.client');







