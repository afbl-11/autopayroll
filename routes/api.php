<?php

use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\EmployeeLoginController;
use App\Http\Controllers\Api\EmployeeLogoutController;
use App\Http\Controllers\Api\PayrollController;
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
Route::middleware('auth:sanctum')->get('/employee/profile', [EmployeeController::class, 'profile']);
Route::middleware('auth:sanctum')->post('/employee/{id}/logout', [EmployeeLogoutController::class, 'logout']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('/attendance/clock-in', [AttendanceController::class, 'clockIn']);

    Route::post('/attendance/clock-out', [AttendanceController::class, 'clockOut']);

    Route::get('/attendance/today', [AttendanceController::class, 'getTodayAttendance']);

    Route::get('/payroll/view', [PayrollController::class, 'showPayroll']);
});
