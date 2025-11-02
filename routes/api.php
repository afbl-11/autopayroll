<?php

use App\Http\Controllers\Api\EmployeeLoginController;
use App\Http\Controllers\Api\EmployeeLogoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ScheduleController;

Route::get('/test', function () {
    return 'API loaded!';
});

//Route::get('/employees', [EmployeeController::class, 'profile']);
Route::get('/companies', [CompanyController::class, 'index']);
Route::get('/schedules', [ScheduleController::class, 'index']);

Route::post('/employee/login', [EmployeeLoginController::class, 'login']);
Route::get('/employee/{id}/profile', [EmployeeController::class, 'profile']);
Route::post('/employee/{id}/logout', [EmployeeLogoutController::class, 'logout']);

