@extends('page-customer.layout.guest')
@section('title', "Đăng nhập")
@section('content')
    <!-- Login Wrapper Area -->
    <div class="login-wrapper d-flex align-items-center justify-content-center">
        <div class="custom-container">
            <div class="text-center px-4"><img class="login-intro-img" src="{{url('/')}}/assets/media/logos/logo-2.svg" alt=""></div>
            <!-- Register Form -->
            <div class="register-form mt-4">
                <h6 class="mb-3 text-center">Đăng nhập MegaCare.</h6>
                <form id="form-login" data-action="{{ route('auth-user.login') }}" data-redirect="{{ route('user.home') }}">
                    @csrf
                    <div class="form-group">
                        <input class="form-control" name='email' id="email" type="text" placeholder="Email">
                    </div>
                    <div class="form-group position-relative">
                        <input class="form-control" id="psw-input" type="password" placeholder="Password">
                        <div class="position-absolute" id="password-visibility"><i class="bi bi-eye"></i><i
                                class="bi bi-eye-slash"></i></div>
                    </div>
                    {{-- <button class="btn btn-primary w-100" type="submit"></button> --}}
                    <button type="submit" id="btn_submit" class="btn  btn-primary w-100">
                        <span class="indicator-label">Đăng nhập</span>
                        <span class="indicator-progress" >Đang tải...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>

                </form>
            </div>
            <!-- Login Meta -->
            <div class="login-meta-data text-center"><a class="stretched-link forgot-password d-block mt-3 mb-1"
                    href="{{ route('auth-user.show-forgot-password') }}">Quên mật khẩu?</a>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    $(function(){
        $("#form-login").on('submit', function(e){
            e.preventDefault();
                toggleBtnSubmit();
                let token = $('input[name=_token]').val();
                let email = $('input[name=email]').val();
                let password =$('#psw-input').val();
                if (email == '' || password == '') {
                    Swal.fire({
                        text: "Hãy điền thông tin đầy đủ!",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Chấp nhận!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    })
                    toggleBtnSubmit();
                } else {
                    let data = {
                        _token: token,
                        email: email,
                        password: password
                    }
                    console.log(data);
                    $.ajax({
                        url: $('#form-login').data('action'),
                        data: data,
                        type: 'post',
                        dataType: 'json',
                        success: function(data) {
                            Swal.fire({
                                text: "Thành công!",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Chấp nhận!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            }).then(function(result) {
                                // toggleBtnSubmit();
                                location.href= $('#form-login').data('redirect')
                            });
                        },
                        error: function(data) {
                            console.log(data);
                            errors = data.responseJSON.errors;
                            console.log(errors);
                            let text="Thông tin đăng nhập không chính xác";
                            if(errors.email) text = errors.email;
                            Swal.fire({
                                text: text,
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Chấp nhận!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                },
                            });

                            toggleBtnSubmit();
                        }
                    });
                }
        })
    })
</script>
@endpush
