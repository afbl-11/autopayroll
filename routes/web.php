<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddressController;

Route::get('/', function () {
    return view('onboarding.admin');
});

/**onboarding*/
Route::post('/admin/register', [AuthController::class, 'register'])->name('admin.register');


//use App\Http\Controllers\AdminController;

Route::get('/admin/onboarding', [AuthController::class, 'showForm'])->name('admin.onboarding');
Route::post('/admin/register', [AuthController::class, 'register'])->name('admin.register');


Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/authVerify', [AuthController::class, 'authVerify'])->name('auth.authVerify');


