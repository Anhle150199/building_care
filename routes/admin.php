<?php

namespace App;

use App\Http\Controllers\Auth\Admin\ForgotPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Admin\LoginController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;


Route::middleware('auth:admin')->name('admin.')->group(function (){
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');
});


