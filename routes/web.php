<?php

namespace App;

use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\HomeController;
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
        return redirect()->route('admin.dashboard');
    });
}

Route::namespace('Auth\Admin')->name('auth.')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('form-login');
    Route::post('login', [LoginController::class, 'login'])->name('login');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('forgot-password');
    Route::get('new-password', [ForgotPasswordController::class, 'showNewPasswordForm'])->name('new-password');
});


