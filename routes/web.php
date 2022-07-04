<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceScanController;
use App\Http\Controllers\Auth\LoginOptionController;
use App\Http\Controllers\CheckInCheckOutController;
use App\Http\Controllers\CompanySettingController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MyAttendanceController;
use App\Http\Controllers\MyPayRollController;
use App\Http\Controllers\MyProjectController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PayRollController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
 */

Route::get('/login-option', [LoginOptionController::class, 'loginOption'])->name('login-option');
Route::get('/checkin-checkout', [CheckInCheckOutController::class, 'checkInCheckOut'])->name('checkin-checkout');
Route::post('/checkin-checkout/store', [CheckInCheckOutController::class, 'checkInCheckOutStore'])->name('checkin-checkout.store');

Auth::routes(['register' => false]);

Route::middleware('auth')->group(function () {
    Route::get('/', [PageController::class, 'home'])->name('home');

    Route::resource('/employee', EmployeeController::class);
    Route::get('/employee/datatable/ssd', [EmployeeController::class, 'ssd']);

    Route::resource('/department', DepartmentController::class);
    Route::get('/department/datatable/ssd', [DepartmentController::class, 'ssd']);

    Route::resource('/role', RoleController::class);
    Route::get('/role/datatable/ssd', [RoleController::class, 'ssd']);

    Route::resource('/permission', PermissionController::class);
    Route::get('/permission/datatable/ssd', [PermissionController::class, 'ssd']);

    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');

    Route::resource('company-setting', CompanySettingController::class)->only('edit', 'update', 'show');

    Route::resource('/attendance', AttendanceController::class)->except('show');
    Route::get('/attendance/datatable/ssd', [AttendanceController::class, 'ssd']);
    Route::get('/attendance/overview', [AttendanceController::class, 'overview'])->name('attendance.overview');
    Route::get('/attendance/overview-table/', [AttendanceController::class, 'overviewTable'])->name('attendance.overview-table');

    Route::get('/attendance-scan', [AttendanceScanController::class, 'scan'])->name('attendance-scan');
    Route::post('/attendance-scan/scan-store', [AttendanceScanController::class, 'scanStore'])->name('attendance-scan.store');
    Route::get('/myattendance/datatable/ssd', [MyAttendanceController::class, 'ssd']);
    Route::get('/myattendance/overview-table', [MyAttendanceController::class, 'myAttendanceOverviewTable']);

    Route::resource('/salary', SalaryController::class);
    Route::get('/salary/datatable/ssd', [SalaryController::class, 'ssd']);

    Route::get('/payroll', [PayRollController::class, 'payroll'])->name('payroll.overview');
    Route::get('/payroll/overview-table/', [PayRollController::class, 'payrollTable'])->name('payroll.overview-table');
    Route::get('/mypayroll/overview-table', [MyPayRollController::class, 'myPayRollTable']);

    Route::resource('/project', ProjectController::class);
    Route::get('/project/datatable/ssd', [ProjectController::class, 'ssd']);

    Route::get('/myproject', [MyProjectController::class, 'project'])->name('my-project');
    Route::get('/myproject/{id}', [MyProjectController::class, 'show'])->name('my-project.show');
    Route::get('/myproject/datatable/ssd', [MyProjectController::class, 'ssd']);

    Route::resource('/task', TaskController::class);
    Route::get('/tasks-data', [TaskController::class, 'taskData']);
});
