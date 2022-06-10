<?php

namespace App;

use App\Http\Controllers\Admin\BaseBuildingController;
use App\Http\Controllers\Admin\Building\BuildingController;
use App\Http\Controllers\Admin\Custommer\ApartmentController;
use App\Http\Controllers\Admin\Custommer\CustommerController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Admin\System\AdminController;
use App\Http\Controllers\Admin\System\DepartmentController;
use App\Http\Controllers\Auth\Admin\ForgotPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Admin\LoginController;
use Illuminate\Support\Facades\Auth;


Route::middleware('auth:admin')->name('admin.')->group(function () {
    Route::get('/', [AdminHomeController::class, 'index'])->name('dashboard');
    Route::post('/update-building-active', [BaseBuildingController::class, 'updateBuildingActive'])->name('update_building_active');

    // User manage(for admin login)
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('profile', [UserController::class, 'showProfile'])->name('profile');
    });

    //Building-manage
    Route::prefix('building')->name('building.')->group(function () {
        Route::get('building-list', [BuildingController::class, 'showBuildingList'])->name('building-list');
        Route::get('building-new', [BuildingController::class, 'showNewBuilding'])->name('new');
        Route::post('create', [BuildingController::class, 'create'])->name('create');
        Route::get('update/{id}', [BuildingController::class, 'showUpdate'])->name('show-update');
        Route::put('update', [BuildingController::class, 'update'])->name('update');
        Route::delete('delete', [BuildingController::class, 'delete'])->name('delete');
    });

    // Department and customer Manage
    Route::prefix('customers')->name('customers.')->group(function () {
        Route::get('apartments', [ApartmentController::class, 'showApartmentList'])->name('apartment-list');
        Route::get('apartments/new', [ApartmentController::class, 'showNewApartment'])->name('show-apartment-new');
        Route::post('apartments/create', [ApartmentController::class, 'create'])->name('apartment-create');
        Route::get('apartments/{id}', [ApartmentController::class, 'showUpdate'])->name('show-apartment-update');
        Route::put('apartments/update', [ApartmentController::class, 'update'])->name('apartment-update');
        Route::delete('apartments/delete', [ApartmentController::class, 'delete'])->name('apartment-delete');

        Route::get('customers-list', [CustommerController::class, 'showCustomerList'])->name('customer-list');
    });
    Route::prefix('system')->name('system.')->group(function () {
        Route::prefix('admins')->name('admins.')->group(function (){
            Route::get('/', [AdminController::class, 'showAdminList'])->name('admin-list');
            Route::post('/create', [AdminController::class, 'create'])->name('create');
            Route::put('/update', [AdminController::class, 'update'])->name('update');
            Route::delete('/delete', [AdminController::class, 'delete'])->name('delete');
            Route::put('/update-status', [AdminController::class, 'updateStatus'])->name('updateStatus');
        });

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
