<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Admin\LoginController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function () {

    Route::namespace('Auth\Admin')->name('auth.')->group(function () {
        Route::get('login', [LoginController::class,'showLoginForm'])->name('form');
        Route::post('login', 'LoginController@login')->name('login');
        Route::get('logout', 'LoginController@logout')->name('logout');
    });
});
