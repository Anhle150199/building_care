<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use App\Models\AccessToken;
use App\Models\Admin;
use App\Models\Customer;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;
    public function showForgotPasswordForm()
    {
        return view('auth.password-reset');
    }

    // public function showNewPasswordForm()
    // {
    //     return view('auth.new-password');
    // }

    public function showCreatePassword($token)
    {
        $token = AccessToken::where('token', $token)->first();
        if ($token->last_used_at != null)
            return abort(404);
        if ((strtotime($token->created_at)+3600) < strtotime(now())) {
            if ($token->tokenable_type == 'admin') {
                $user = Admin::find($token->tokenable_id);
            } else {
                $user = Customer::find($token->tokenable_id);
            }
            return view('auth.resent-mail', ['type' => $token->tokenable_type, 'email' => $user->email, 'name' => $token->name]);
        }
        return view('auth.new-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'token' => 'required|string',
                'password' => 'required|string',
            ]
        );
        if ($validator->fails()) {
            return new JsonResponse(['errors' => $validator->getMessageBag()->toArray()], 406);
        }
        try {
            $token = AccessToken::where('token', $request->token)->first();
            $token->last_used_at = now();
            if ($token == null) {
                return new JsonResponse(['errors' => ['Có lỗi xảy ra']], 406);
            }
            if ($token->tokenable_type == 'admin') {
                $user = Admin::find($token->tokenable_id);
                $user->status = 'activated';
            } else $user = Customer::find($token->tokenable_id);
            $user->password = Hash::make($request->password);
            $user->save();
            $token->save();
        } catch (\Throwable $th) {
            return new JsonResponse(['errors' => ['Có lỗi xảy ra', $request->all()]], 406);
        }
        return new JsonResponse(['success'], 200);
    }
    public function sentToken(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'type' => 'required|string|in:admin,customer',
                'email' => 'required|string',
                'name' => 'required|string',
            ]
        );
        if ($validator->fails()) {
            return new JsonResponse(['errors' => $validator->getMessageBag()->toArray()], 406);
        }

        try {
            if ($request->type == 'admin') {
                $user = Admin::where('email', $request->email)->first();
            } else {
                $user = Customer::where('email', $request->email)->first();
            }
            if ($user == null)
                return new JsonResponse(['errors' => ['Có lỗi xảy ra']], 406);
            $token = AccessToken::createToken($user->id, $request->name, $request->type);
            $link = route('auth.verify-email', ['token' => $token]);
            $mailable = new ResetPassword($link);
            Mail::to($request->email)->send($mailable);
        } catch (\Throwable $th) {
            return new JsonResponse(['errors' => ['Có lỗi xảy ra']], 406);
        }
        return new JsonResponse(['success'], 200);
    }
}
