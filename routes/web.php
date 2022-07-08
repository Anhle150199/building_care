<?php

namespace App;

use App\Http\Controllers\Admin\Auth\ConfirmPasswordController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Customer\Auth\ForgotPasswordController as AuthForgotPasswordController;
use App\Http\Controllers\Customer\Auth\LoginController as AuthLoginController;
use App\Http\Controllers\Customer\Home\HomeController as HomeHomeController;
use App\Http\Controllers\Customer\MaintenanceController;
use App\Http\Controllers\Customer\Setting\SettingController;
use App\Http\Controllers\Customer\SupportController;
use App\Http\Controllers\Customer\VehicleController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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

foreach(config('constants.urls') as $url) {
    Route::get('/'. $url, function(){
        return redirect()->route('user.home');
    });
}

Route::get('xxx', [HomeHomeController::class, 'pushNotification'])->name('xxx');
// Route::get('yyy', function (Request $req)
// {
//     dd($req->cars);
//     return view('test');
// })->name('yyy');

Route::namespace('Admin\Auth')->name('auth.')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('form-login');
    Route::post('login', [LoginController::class, 'login'])->name('login');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('forgot-password');
    Route::get('new-password', [ForgotPasswordController::class, 'showNewPasswordForm'])->name('new-password');
    Route::get('users/verify/{token}', [ForgotPasswordController::class, 'showCreatePassword'])->name('verify-email');

    Route::post('reset-password',[ForgotPasswordController::class, 'resetPassword'])->name('reset-password');
    Route::post('sent-mail-reset',[ForgotPasswordController::class, 'sentToken'])->name('sent-mail-reset-password');
});

Route::prefix('user')->name('auth-user.')->group(function(){
    Route::get('login', [AuthLoginController::class, 'showLoginForm'])->name('form-login');
    Route::post('login', [AuthLoginController::class, 'login'])->name('login');
    Route::post('logout', [AuthLoginController::class, 'logout'])->name('logout');

    Route::get('forgot-pasword', [AuthForgotPasswordController::class, 'showForgotPasswordForm'])->name('show-forgot-password');

});

Route::middleware('auth:user')->name('user.')->group(function () {
    Route::get('home', [HomeHomeController::class, 'showHome'])->name("home");
    Route::get('notify/{id}-{title}', [HomeHomeController::class, 'showNotifyDetail'])->name("notify-detail");
    // Route::get('notify', [HomeHomeController::class, 'notification'])->name("notify");

    Route::patch('update-token', [HomeHomeController::class, 'updateDeviceKey'])->name('update-token');

    Route::get('vehicle', [VehicleController::class, 'show'])->name('show-vehicle');
    Route::get('vehicle/register', [VehicleController::class, 'showForm'])->name('show-vehicle-register');
    Route::post('vehicle/create', [VehicleController::class, 'create'])->name('vehicle-create');
    Route::delete('vehicle/delete', [VehicleController::class, 'delete'])->name('delete-vehicle');

    Route::get('maintenance', [MaintenanceController::class, 'show'])->name('maintenance');

    Route::prefix('support')->name('support.')->group(function(){
        Route::get('/', [SupportController::class, 'showList'])->name('show-list');
        Route::get('/detail/#{id}', [SupportController::class, 'showDetail'])->name('show-detail');
        Route::post('create', [SupportController::class, 'create'])->name('create');
        Route::get('detail-{id}', [SupportController::class, 'showDetail'])->name("show-detail");
        Route::post("reply", [SupportController::class, 'reply'])->name("reply");
    });

    Route::prefix('setting')->name('setting.')->group(function(){
        Route::get('/', [SettingController::class, 'show'])->name('show');
        Route::get('/profile', [SettingController::class, 'showProfile'])->name('show-profile');
        Route::put('/profile-update', [SettingController::class, 'updateProfile'])->name('update-profile');
        Route::get('/password', [SettingController::class, 'showPasswordChange'])->name('show-password');
        Route::put('/password-update', [SettingController::class, 'updatePassword'])->name('update-password');

        Route::post('/avatar-update', [SettingController::class, 'updateAvatar'])->name('update-avatar');
    });
});

