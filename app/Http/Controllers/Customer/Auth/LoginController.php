<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class LoginController extends Controller
{
    use AuthenticatesUsers;
        public function __construct()
        {
            $this->middleware('guest:user')->except('logout');
        }

    public function showLoginForm()
    {
        return view('page-customer.auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => ['required', 'string', 'exists:customers,email'],
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
        // if (
        //     method_exists($this, 'hasTooManyLoginAttempts') &&
        //     $this->hasTooManyLoginAttempts($request)
        // ) {
        //     $this->fireLockoutEvent($request);
        //     $this->sendLockoutResponse($request);
        //     return new JsonResponse(['errors' => ['email' => 'Bạn đã đăng nhập quá nhiều lần.']], 406);
        // }

        // Check tài khoản
        $credentials = $request->only(['email', 'password']);
        // array_push($credentials, ['status'=>'activated']);
        // if ($this->attemptLogin($request)) {
        if (Auth::guard('user')->attempt(['email'=>$request->email, 'password'=>$request->password], true)) {

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
    protected $redirectTo = '/';

    public function logout(Request $request){
        // if()
        Auth::guard('user')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }
        return redirect()->route('auth-user.form-login');
    }

}
