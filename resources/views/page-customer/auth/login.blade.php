@extends('page-customer.layout.guest')

@section('content')
    <!-- Login Wrapper Area -->
    <div class="login-wrapper d-flex align-items-center justify-content-center">
        <div class="custom-container">
            <div class="text-center px-4"><img class="login-intro-img" src="{{url('/')}}/assets/media/logos/logo-2.svg" alt=""></div>
            <!-- Register Form -->
            <div class="register-form mt-4">
                <h6 class="mb-3 text-center">Đăng nhập MegaCare.</h6>
                <form action="page-home.html">
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Email">
                    </div>
                    <div class="form-group position-relative">
                        <input class="form-control" id="psw-input" type="password" placeholder="Enter Password">
                        <div class="position-absolute" id="password-visibility"><i class="bi bi-eye"></i><i
                                class="bi bi-eye-slash"></i></div>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Đăng nhập</button>
                </form>
            </div>
            <!-- Login Meta -->
            <div class="login-meta-data text-center"><a class="stretched-link forgot-password d-block mt-3 mb-1"
                    href="{{ route('auth-user.show-forgot-password') }}">Quên mật khẩu?</a>
            </div>
        </div>
    </div>
@endsection
