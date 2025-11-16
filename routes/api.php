<?php

use App\Http\Controllers\Api\AnnouncementController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\CreditAdjustmentController;
use App\Http\Controllers\Api\EmployeeLoginController;
use App\Http\Controllers\Api\EmployeeLogoutController;
use App\Http\Controllers\Api\LeaveRequestController;
use App\Http\Controllers\Api\PayrollController;
use App\Http\Controllers\Api\PayrollWebController;
use App\Http\Controllers\Api\ResetPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ScheduleController;

Route::get('/test', function () {
    return 'API loaded!';
});

Route::get('/companies', [CompanyController::class, 'index']);
Route::get('/schedules', [ScheduleController::class, 'index']);

Route::post('/employee/login', [EmployeeLoginController::class, 'login']);
Route::middleware('auth:sanctum')->get('/employee/profile', [EmployeeController::class, 'profile']);
Route::middleware('auth:sanctum')->post('/employee/logout', [EmployeeLogoutController::class, 'logout']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('/attendance/clock-in', [AttendanceController::class, 'clockIn']);

    Route::post('/attendance/clock-out', [AttendanceController::class, 'clockOut']);

    Route::get('/attendance/today', [AttendanceController::class, 'getTodayAttendance']);

    Route::get('/payroll/view', [PayrollController::class, 'showPayroll']);

    Route::post('/employee/password-reset', [ResetPasswordController::class, 'resetPassword']);

    Route::post('/employee/leave-request', [LeaveRequestController::class, 'leaveRequest']);

    Route::get('/employee/show/leave-request', [LeaveRequestController::class, 'showLeaveRequest']);

    Route::get('/employee/track/leave-request', [LeaveRequestController::class, 'trackLeaveRequest']);

    Route::post('/employee/credit-adjustment', [CreditAdjustmentController::class, 'adjustmentRequest']);

    Route::get('/employee/show/adjustment-request', [CreditAdjustmentController::class, 'showAdjustmentRequest']);

    Route::get('/employee/track/adjustment-request', [CreditAdjustmentController::class, 'trackAdjustmentRequest']);

    Route::get('/employee/announcements', [AnnouncementController::class, 'getAnnouncements']);

});
    Route::get('/employee/credit-adjustment/types', [CreditAdjustmentController::class, 'adjustmentTypes']);

    Route::get('/employee/payroll/{employeeId}', [PayrollWebController::class, 'getPayroll'])
    ->name('get.payroll');
