<?php

namespace App;

use App\Http\Controllers\Admin\Auth\ConfirmPasswordController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Customer\Auth\ForgotPasswordController as AuthForgotPasswordController;
use App\Http\Controllers\Customer\Auth\LoginController as AuthLoginController;
use App\Http\Controllers\Customer\Home\HomeController as HomeHomeController;
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

// Route::get('xxx', function ()
// {
//     return view('test');
// })->name('xxx');
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

    Route::get('forgot-pasword', [AuthForgotPasswordController::class, 'showForgotPasswordForm'])->name('show-forgot-password');

});

Route::middleware('auth:user')->name('user.')->group(function () {
    Route::get('home', [HomeHomeController::class, 'showHome'])->name("home");
});

