<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Faker\Extension\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    use AuthenticatesUsers;
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => ['required', 'string', 'exists:admins,email'],
                'password' => ['required', 'string', 'min:8']
            ]
        );

        if ($validator->fails()) {
            return new JsonResponse(['errors' => $validator->getMessageBag()->toArray()], 406);
        }

        // Check login quá nhiều lần
        if (
            method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);
            $this->sendLockoutResponse($request);
            return new JsonResponse(['errors' => ['email' => 'Bạn đã đăng nhập quá nhiều lần.']], 406);
        }

        // Check tài khoản
        $credentials = $request->only(['email', 'password']);
        // array_push($credentials, ['status'=>'activated']);
        // if ($this->attemptLogin($request)) {
        if (Auth::guard('admin')->attempt(['email'=>$request->email, 'password'=>$request->password, 'status'=> 'activated'])) {

            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            $request->session()->regenerate();

            $this->clearLoginAttempts($request);

            if ($response = $this->authenticated($request, $this->guard()->user())) {
                return $response;
            }

            return new JsonResponse([], 200);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return new JsonResponse(['errors' => ['email' => 'Email hoặc mật khẩu không chính xác.']], 406);

        // return $this->sendFailedLoginResponse($request);
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    // public function __construct()
    // {
    //     $this->middleware('guest', ['except'=>['logout']]);
    // }

    public function logout(Request $request){
        $this->guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }
        return redirect()->route('auth.form-login');
    }


    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    // }
}
