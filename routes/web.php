<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes(['register' => false]);

Route::middleware('auth')->group(function() {
    Route::get('/', [PageController::class, 'home'])->name('home');

    Route::resource('/employee', EmployeeController::class);
    Route::get('/employee/datatable/ssd',[EmployeeController::class,'ssd']);

    Route::resource('/department', DepartmentController::class);
    Route::get('/department/datatable/ssd', [DepartmentController::class, 'ssd']);

    Route::resource('/role', RoleController::class);
    Route::get('/role/datatable/ssd', [RoleController::class, 'ssd']);

    Route::resource('/permission', PermissionController::class);
    Route::get('/permission/datatable/ssd', [PermissionController::class, 'ssd']);

    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');

});
