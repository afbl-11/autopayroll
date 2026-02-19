<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminRegistrationController;
use App\Http\Controllers\AnnouncementsController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ClientRegistrationController;
use App\Http\Controllers\CompanyDashboardController;
use App\Http\Controllers\CreditAdjustmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeDashboardController;
use App\Http\Controllers\EmployeePayrollController;
use App\Http\Controllers\EmployeeWeb\LeaveDashboardController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\QrCodeController;
use App\Mail\SendOtpMail;
use App\Mail\TestEmail;
use App\Models\Announcement;
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

/**company registration*/
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

Route::post('company/hire-parttime/{id}', [CompanyDashboardController::class, 'hirePartTimeEmployee'])
    ->middleware(['auth:admin'])
    ->name('company.hire.parttime');

Route::get('company/schedules/{id}', [CompanyDashboardController::class, 'showSchedules'])
    ->middleware(['auth:admin'])
    ->name('company.dashboard.schedules');

Route::get('company/qr/{id}', [QrCodeController::class, 'generate'])
    ->middleware(['auth:admin'])
    ->name('company.qr.management');

Route::post('/company/{id}/qr/download', [QrCodeController::class, 'download'])->name('company.qr.download');


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

Route::post('/company/schedule/create/{id}', [CompanyDashboardController::class, 'createSchedule'])
    ->middleware('auth:admin')
    ->name('company.create.schedule');

Route::get('/company/location/change/{id}', [CompanyDashboardController::class, 'showLocationChange'])
    ->middleware(['auth:admin'])
    ->name('company.location.change');

Route::post('/company/change/client-address/{id}', [CompanyDashboardController::class, 'storeUpdatedClientAddress'])
    ->middleware(['auth:admin'])
    ->name('company.change.client.address');



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
Route::get('/admin/employee/dashboard', [EmployeeDashboardController::class, 'showDashboard'])
    ->middleware('auth:admin')
    ->name('employee.dashboard');

Route::get('dashboard/employee/detail/{id}', [EmployeeDashboardController::class, 'showInfo'])
    ->middleware('auth:admin')
    ->name('employee.dashboard.detail');

Route::get('dashboard/employee/contract/{id}', [EmployeeDashboardController::class, 'showContract'])
    ->middleware('auth:admin')
    ->name('employee.dashboard.contract');

Route::get('dashboard/employee/attendance/{id}', [AttendanceController::class, 'showAttendance'])
    ->middleware('auth:admin')
    ->name('employee.dashboard.attendance');

Route::get('dashboard/employee/leave-request/{id}', [LeaveRequestController::class, 'showLeaveRequest'])
    ->middleware('auth:admin')
    ->name('employee.leave.request');

Route::get('/dashboard/employee/leave-detail/{leaveId}/{employeeId}', [LeaveRequestController::class, 'showLeaveRequestDetail'])
    ->middleware('auth:admin')
    ->name('employee.leave.detail');

Route::post('/dashboard/employee/leave/approve/{employeeId}/{leaveId}', [LeaveRequestController::class, 'approveLeaveRequest'])
    ->middleware('auth:admin')
    ->name('approve.leave');

Route::post('/dashboard/employee/leave/revise/{employeeId}/{leaveId}', [LeaveRequestController::class, 'reviseLeaveRequest'])
    ->middleware('auth:admin')
    ->name('revise.leave');

Route::post('/dashboard/employee/leave/reject/{employeeId}/{leaveId}', [LeaveRequestController::class, 'rejectLeaveRequest'])
    ->middleware('auth:admin')
    ->name('reject.leave');

Route::get('dashboard/employee/documents/{id}', [EmployeeDashboardController::class, 'showDocuments'])
    ->middleware('auth:admin')
    ->name('employee.dashboard.documents');

Route::get('dashboard/employee/payroll/{id}', [EmployeePayrollController::class, 'showPayroll'])
    ->middleware('auth:admin')
    ->name('employee.dashboard.payroll');

Route::get('dashboard/employee/payslip/{id}', [EmployeePayrollController::class, 'showPayslip'])
    ->middleware('auth:admin')
    ->name('employee.dashboard.payslip');

Route::get('dashboard/employee/payslip/{id}/print', [EmployeePayrollController::class, 'printPayslipPDF'])
    ->name('employee.dashboard.payslip.print');

Route::get('dashboard/employee/payslip/{id}/semi-monthly', [EmployeePayrollController::class, 'showSemiMonthlyPayslip'])
//    ->middleware('auth:admin')
    ->name('employee.dashboard.payslip.semi');

Route::get('/announcements', [AnnouncementsController::class, 'getAnnouncements'])
    ->middleware('auth:admin')
    ->name('announcements');

Route::get('/announcements/detail/{id}', [AnnouncementsController::class, 'getAnnouncementDetail'])
    ->middleware('auth:admin')
    ->name('announce.detail');

Route::get('/announcements/view/{id}', [\App\Http\Controllers\EmployeeWeb\AnnouncementController::class, 'show'])
    ->name('new.announcement.view');

Route::post('/announcement/delete/{id}', [AnnouncementsController::class, 'deleteAnnouncement'])
    ->name('delete.announcement');

Route::get('/announcement/create/', [AnnouncementsController::class, 'createAnnouncement'])
    ->middleware('auth:admin')
    ->name('create.announcement');

Route::post('/announcement/post/success', [AnnouncementsController::class, 'postAnnouncement'])
    ->middleware('auth:admin')
    ->name('post.announcement');


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

Route::get('/adjustments', [CreditAdjustmentController::class, 'showAdjustments'])
    ->middleware('auth:admin')
    ->name('adjustments');

Route::post('/adjustments/reject', [CreditAdjustmentController::class, 'rejectRequest'])
    ->middleware('auth:admin')
    ->name('reject.adjustment');

Route::post('/adjustments/approve', [CreditAdjustmentController::class, 'approveRequest'])
    ->middleware('auth:admin')
    ->name('approve.adjustment');

Route::post('adjustments/alter/clock-in', [CreditAdjustmentController::class, 'alterClockIn'])
    ->middleware('auth:admin')
    ->name('alter.clock-in');

Route::post('/adjustments/alter/clock-out', [CreditAdjustmentController::class, 'alterClockOut'])
    ->middleware('auth:admin')
    ->name('alter.clock-out');

Route::post('/adjustments/alter/attendance', [CreditAdjustmentController::class, 'alterAttendance'])
    ->middleware('auth:admin')
    ->name('alter.attendance');

Route::post('/adjustments/alter/leave', [CreditAdjustmentController::class, 'alterLeave'])
    ->middleware('auth:admin')
    ->name('alter.leave');

Route::post('/adjustments/alter/OB', [CreditAdjustmentController::class, 'alterClockInOut'])
    ->middleware('auth:admin')
    ->name('alter.clock.in.out');

Route::get('/new-payroll', [PayrollController::class, 'showPayrollList'])
    ->middleware('auth:admin')
    ->name('new.payroll');
Route::get('salary/list', [PayrollController::class, 'showSalaryList'])
    ->middleware('auth:admin')
    ->name('salary.list');
Route::get('/admin/settings', [AdminController::class, 'showSettings'])
    ->middleware('auth:admin')
    ->name('admin.settings');

Route::post('/admin/settings/success/change-location', [AdminController::class, 'changeLocation'])
    ->middleware('auth:admin')
    ->name('change.location');

Route::post('/admin/settings/success/change-password', [AdminController::class, 'changePassword'])
    ->middleware('auth:admin')
    ->name('change.password');

Route::post('/admin/settings/delete-account', [AdminController::class, 'deleteAccount'])
    ->middleware('auth:admin')
    ->name('delete.account');

Route::get('/admin/changes-password', [AdminController::class, 'showChangePassword'])
    ->middleware('auth:admin')
    ->name('change.password.view');

Route::get('/admin/change-location', [AdminController::class, 'showChangeLocation'])
    ->middleware('auth:admin')
    ->name('change.location.view');

Route::get('/attendance/manual',
    [CompanyDashboardController::class, 'manualAttendance']
)->name('attendance.manual');

// Manual Input Attendance Routes (accessible to anyone with company code)
Route::post('/attendance/manual/verify-code', [AttendanceController::class, 'verifyCompanyCode']);
Route::get('/attendance/manual/employees/{companyId}', [AttendanceController::class, 'getCompanyEmployees']);
Route::post('/attendance/manual/save', [AttendanceController::class, 'saveManualAttendance']);

Route::put('/admin/profile/update', [AdminController::class, 'updateProfile'])
    ->name('admin.profile.update');

Route::get('/company/{id}/edit', [CompanyDashboardController::class, 'edit'])
    ->name('company.edit');

Route::put('/company/{id}', [CompanyDashboardController::class, 'update'])
    ->name('company.update');

Route::get('/forgot-password', [AdminController::class, 'showForgotPassword'])
    ->name('forgot.password');

Route::post('/forgot-password', [AdminController::class, 'resetForgotPassword'])
    ->name('forgot.password.update');

Route::delete('/company/{id}', [CompanyDashboardController::class, 'destroy'])
    ->name('company.destroy');

Route::delete('/employee/{id}', [EmployeeDashboardController::class, 'destroy'])
    ->name('employee.destroy');

// Attendance routes (accessible without admin auth for manual attendance page)
Route::get('/company/{company}/employees', [AttendanceController::class, 'employees']);
Route::get('/company/{company}/part-time-employees', [AttendanceController::class, 'partTimeEmployees']);
Route::get('/all-part-time-employees', [AttendanceController::class, 'allPartTimeEmployees']);
Route::get('/company/{company}/attendance-dates', [AttendanceController::class, 'attendanceDates']);
Route::get('/company/{company}/attendance/{date}', [AttendanceController::class, 'attendanceByDate']);

Route::middleware(['auth:admin'])->group(function () {

    Route::post('/attendance/create-date', [AttendanceController::class, 'createDate']);
    Route::post('/attendance/delete-date', [AttendanceController::class, 'deleteDate']);
    Route::post('/attendance/manual/bulk-save', [AttendanceController::class, 'bulkSave']);

});


use App\Http\Controllers\EmployeeEditController;
use Kreait\Firebase\Messaging\CloudMessage;

Route::prefix('employee/{employee}')->group(function () {

    Route::get('info', [EmployeeEditController::class, 'show'])
        ->name('employee.info');

    Route::get('edit/personal', [EmployeeEditController::class, 'editPersonal'])
        ->name('employee.edit.personal');
    Route::put('edit/personal', [EmployeeEditController::class, 'updatePersonal'])
        ->name('employee.update.personal');

    Route::get('edit/address', [EmployeeEditController::class, 'editAddress'])
        ->name('employee.edit.address');
    Route::put('edit/address', [EmployeeEditController::class, 'updateAddress'])
        ->name('employee.update.address');

    Route::get('edit/job', [EmployeeEditController::class, 'editJob'])
        ->name('employee.edit.job');
    Route::put('edit/job', [EmployeeEditController::class, 'updateJob'])
        ->name('employee.update.job');

    Route::get('edit/account', [EmployeeEditController::class, 'editAccount'])
        ->name('employee.edit.account');
    Route::put('edit/account', [EmployeeEditController::class, 'updateAccount'])
        ->name('employee.update.account');

    Route::put('rate/update', [EmployeeEditController::class, 'updateRate'])
        ->name('employee.rate.update');

    Route::put('rate/{rateId}/edit', [EmployeeEditController::class, 'editRate'])
        ->name('employee.rate.edit');

    Route::get('edit/government', [EmployeeEditController::class, 'editGovernment'])
        ->name('employee.edit.government');
    Route::put('edit/government', [EmployeeEditController::class, 'updateGovernment'])
        ->name('employee.update.government');

});

Route::view('/tutorial', 'tutorial.tutorial')
    ->name('tutorial.tutorial');
Route::view('/tutorial/settings', 'tutorial.tutorial-settings')
    ->name('tutorial.settings');
Route::view('/tutorial/attendance', 'tutorial.tutorial-attendance')
->name('tutorial.attendance');
Route::view('/tutorial/manual-attendance', 'tutorial.tutorial-manual-attendance')
->name('tutorial.manual-attendance');
Route::view('/tutorial/salary', 'tutorial.tutorial-salary')
->name('tutorial.salary');
Route::view('/tutorial/tax', 'tutorial.tutorial-tax')
->name('tutorial.tax');
//Employee Web Stuff
Route::post('/employee/announcement/delete/{id}', [\App\Http\Controllers\EmployeeWeb\AnnouncementController::class, 'deleteAnnouncement'])
    ->name('employee.delete.announcement');

Route::get('employee/settings', [\App\Http\Controllers\EmployeeWeb\SettingsController::class, 'index'])
    ->name('employee_web.settings');

Route::put('employee/update/profile', [\App\Http\Controllers\EmployeeWeb\SettingsController::class, 'updateEmployeeProfile'])
    ->name('employee_web.update.profile');

Route::get('/employee/employee-dashboard', [\App\Http\Controllers\EmployeeWeb\EmployeeDashboard::class, 'index'])
    ->name('web.employee.dashboard');

Route::get('/employee/payroll',[\App\Http\Controllers\EmployeeWeb\PayrollController::class, 'showPayroll'])
    ->name('web.employee.payroll');

Route::get('/employee/announcement/', [\App\Http\Controllers\EmployeeWeb\AnnouncementController::class, 'index'])
->name('employee_web.announcement');

Route::get('/employee/leave-module',[LeaveDashboardController::class,'index'])
->name('employee_web.leaveDashboard');

Route::get('/employee/leave', [LeaveDashboardController::class, 'index'])
    ->name('employee_web.leave');

Route::get('/employee/leave/filter', [LeaveDashboardController::class, 'index'])
    ->name('employee_web.filter.leave');

Route::post('/employee/request/leave', [LeaveDashboardController::class, 'sendLeaveRequest'])
    ->name('employee_web.request.leave');

Route::get('/employee/credit-adjustment',[\App\Http\Controllers\EmployeeWeb\CreditAdjustmentController::class,'index'])
->name('employee_web.adjustment');

Route::post('/employee/request/adjustment/', [\App\Http\Controllers\EmployeeWeb\CreditAdjustmentController::class, 'sendAdjustmentRequest'])
    ->name('employee_web.adjustment.request');

//firebase cloud messaging
Route::get('/test-fcm', function () {
    $message = CloudMessage::fromArray([
        'topic' => 'test',
        'notification' => [
            'title' => 'Autopayroll 🔔',
            'body' => 'Firebase push notifications are working!',
        ],
    ]);

    app('firebase.messaging')->send($message);

    return 'Notification sent';
});

// email otp
Route::post('/forgot-password/send-otp-request', [ForgotPasswordController::class, 'requestOtp'])
->name('send.otp.request');

//forgot password
Route::get('/verify-email-address/', [ForgotPasswordController::class, 'verifyEmailAddress'])
->name('forgot.emailAddress');

Route::post('/email/verify-otp/', [ForgotPasswordController::class, 'verifyOtp'])
    ->name('verify.otp');

Route::get('/email/otp-input', [ForgotPasswordController::class, 'showOtpView'])
    ->name('verify.otp.input');



Route::get('dashboard/view/payslip/{id}', [\App\Http\Controllers\EmployeeWeb\PayrollController::class, 'showPayslip'])
    ->name('employee_web.dashboard.payslip');

Route::get('/settings/profile/change-password', [\App\Http\Controllers\EmployeeWeb\SettingsController::class, 'showChangePassword'])
    ->name('employee_web.settings.changePassword');

Route::post('/settings/profile/change-password/success', [\App\Http\Controllers\EmployeeWeb\SettingsController::class, 'changePassword'])
    ->name('employee_web.settings.changePassword.success');

Route::post('/dashboard/employee_web/attendance/view', [\App\Http\Controllers\EmployeeWeb\EmployeeDashboard::class, 'viewWebAttendance'])
    ->name('employee_web.attendance.view');

