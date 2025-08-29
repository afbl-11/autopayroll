<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('onboarding.company');
});

/**admin registration*/
Route::post('/admin/register', [AuthController::class, 'register'])->name('admin.register');
Route::get('/admin/onboarding', [AuthController::class, 'showForm'])->name('admin.onboarding');
Route::post('/admin/step1', [AuthController::class, 'storeStep1'])->name('auth.store.step1');
Route::get('/admin/address', [AuthController::class, 'showStep2'])->name('auth.register.step2');
/**company registration*/
Route::post('/client/onboarding', [ClientController::class, 'register'])->name('onboarding.client');
Route::get('client/register', [ClientController::class, 'showForm'])->name('register.client');





