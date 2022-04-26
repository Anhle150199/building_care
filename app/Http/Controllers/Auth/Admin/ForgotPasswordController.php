<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('auth.password-reset');
    }

    public function showNewPasswordForm(Request $request)
    {
        return view('auth.new-password');
    }
}
