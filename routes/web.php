<?php

use App\Http\Controllers\AdminRegistrationController;
use App\Http\Controllers\ClientRegistrationController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

/**admin registration*/
Route::post('/register/admin/success', [AdminRegistrationController::class, 'register'])->name('admin.register');
Route::post('/register/admin/personal-info', [AdminRegistrationController::class, 'storeStep1'])->name('auth.store.step1');
Route::get('/register/admin/address', [AdminRegistrationController::class, 'showStep2'])->name('auth.register.step2');
//should not redirect to dashboard
Route::get('/admin/onboarding', [AdminRegistrationController::class, 'showAdminDashboard'])->name('admin.onboarding');

/**company registration*/
Route::post('/client/onboarding', [ClientRegistrationController::class, 'register'])->name('onboarding.client');
Route::get('client/register', [ClientRegistrationController::class, 'showForm'])->name('register.client');







