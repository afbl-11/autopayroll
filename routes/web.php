<?php

use App\Http\Controllers\AdminRegistrationController;
use App\Http\Controllers\ClientRegistrationController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('admin_registration.company');
});

/**admin_dashboard registration*/
Route::post('/admin/register', [AdminRegistrationController::class, 'register'])->name('admin_dashboard.register');
Route::get('/admin/admin_registration', [AdminRegistrationController::class, 'showForm'])->name('admin_dashboard.admin_registration');
Route::post('/admin/step1', [AdminRegistrationController::class, 'storeStep1'])->name('auth.store.step1');
Route::get('/admin/address', [AdminRegistrationController::class, 'showStep2'])->name('auth.register.step2');
/**company registration*/
Route::post('/client/admin_registration', [ClientRegistrationController::class, 'register'])->name('admin_registration.client');
Route::get('client/register', [ClientRegistrationController::class, 'showForm'])->name('register.client');





