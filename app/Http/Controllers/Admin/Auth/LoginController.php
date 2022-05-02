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

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

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

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
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
        // if ($this->attemptLogin($request)) {
        if (Auth::guard('admin')->attempt($credentials)) {

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


    // public function login(Request $request)
    // {

    //     $validator = Validator::make([
    //         $request->only(['email', 'password']),
    //         [
    //             'email' =>['required', 'string', 'max:255', 'min:5', ]
    //         ]
    //     ]);
    //     // Validate the form data
    //     $this->validate($request, [
    //         'email' => 'required',
    //         'password' => 'required|min:6',
    //     ]);

    //      $email =  $request->email;
    //     // che thong chi cho phep dang nhap bang sdt hoac email.
    //     if( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
    //         // $email = $email . "@phone.dxmb";
    //         if (Auth::guard('backend_public')->attempt([
    //             'mobile' => $email,
    //             'password'       =>$request->password
    //         ],  $request->remember)) {
    //             $token = JWTAuth::fromUser(\Auth::user());
    //             Helper::setToken(\Auth::user()->id,$token);
    //             return redirect()->route('admin.home');
    //         }

    //         // if unsuccessful, then redirect back to the login with the form data
    //         return redirect()->route('admin.auth.form')->withInput($request->all())->withErrors( ['Đăng nhập thất bại! Số điện thoại hoặc mật khẩu không đúng.']);
    //     }

    //     if (Auth::guard('backend_public')->attempt([
    //         'email' => $email,
    //         'password'       =>$request->password
    //     ],  $request->remember)) {
    //         $token = JWTAuth::fromUser(\Auth::user());
    //         Helper::setToken(\Auth::user()->id,$token);
    //         return redirect()->route('admin.home');
    //     }
    //     // if unsuccessful, then redirect back to the login with the form data
    //     return redirect()->route('admin.auth.form')->withInput($request->all())->withErrors( ['Đăng nhập thất bại! Tài khoản đăng nhập (Email/Số điện thoại) hoặc mật khẩu không đúng.']);
    // }

    // public function logout()
    // {
    //     if(Auth::user() && Helper::getToken(Auth::user()->id)){
    //         Helper::delToken(\Auth::user()->id);
    //     }
    //     Auth::guard('backend_public')->logout();
    //     return redirect()->route('admin.auth.login');
    // }


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
