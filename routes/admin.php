<?php

namespace App;

use App\Http\Controllers\Admin\CustommerController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Admin\System\AdminController;
use App\Http\Controllers\Admin\System\DepartmentController;
use App\Http\Controllers\Auth\Admin\ForgotPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Admin\LoginController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;


Route::middleware('auth:admin')->name('admin.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('profile', [UserController::class, 'showProfile'])->name('profile');
    });
    Route::prefix('customers')->name('customers.')->group(function () {
        Route::get('customers-list', [CustommerController::class, 'showCustomerList'])->name('customer-list');
    });
    Route::prefix('system')->name('system.')->group(function () {
        Route::get('admins', [AdminController::class, 'showAdminList'])->name('admin-list');
        Route::prefix('departments')->name('department.')->group(function ()
        {
            Route::get('/all', [DepartmentController::class, 'getAll']);
            Route::get('/', [DepartmentController::class, 'showDepartmentList'])->name('list');
            Route::post('/new', [DepartmentController::class, 'createDepartment'])->name('new');
            Route::put('/edit', [DepartmentController::class, 'updateDepartment'])->name('edit');
            Route::delete('/delete', [DepartmentController::class, 'deleteDepartment'])->name('delete');
        });

    });
});
