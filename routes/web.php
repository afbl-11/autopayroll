<?php

use App\Http\Controllers\AdminRegistrationController;
use App\Http\Controllers\ClientRegistrationController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('auth.admin-register-step1');
});

/**admin registration*/
Route::post('/admin/register', [AdminRegistrationController::class, 'register'])->name('admin.register');
Route::get('/admin/onboarding', [AdminRegistrationController::class, 'showAdminDashboard'])->name('admin.onboarding');
Route::post('/admin/step1', [AdminRegistrationController::class, 'storeStep1'])->name('auth.store.step1');
Route::get('/admin/address', [AdminRegistrationController::class, 'showStep2'])->name('auth.register.step2');
/**company registration*/
Route::post('/client/onboarding', [ClientRegistrationController::class, 'register'])->name('onboarding.client');
Route::get('client/register', [ClientRegistrationController::class, 'showForm'])->name('register.client');







