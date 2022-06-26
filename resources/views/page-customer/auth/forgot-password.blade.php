@extends('page-customer.layout.guest')
@section('title', 'Quên mật khẩu')
@push('css')
@endpush
@section('content')
    <div class="login-back-button"><a href="{{ route('auth-user.form-login') }}">
            <svg class="bi bi-arrow-left-short" width="32" height="32" viewBox="0 0 16 16" fill="currentColor"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z">
                </path>
            </svg></a></div>
    <!-- Login Wrapper Area -->
    <div class="login-wrapper d-flex align-items-center justify-content-center">
        <div class="custom-container">
            <div class="text-center px-4"><img class="login-intro-img"
                    src="{{ url('/') }}/assets/media/logos/logo-2.svg" alt=""></div>
            <!-- Register Form -->
            <div class="register-form mt-4">
                <form data-action="{{ route('auth.sent-mail-reset-password') }}" id="kt_password_reset_form">
                    @csrf
                    <div class="form-group text-start mb-3">
                        <input class="form-control" type="text" placeholder="Địa chỉ email" name='email'>
                    </div>
                    <button type="submit" id="btn_submit" class="btn  btn-primary w-100">
                        <span class="indicator-label">Đặt lại mật khẩu</span>
                        <span class="indicator-progress">Đang tải...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(function() {
            $("#kt_password_reset_form").on('submit', function(e) {
                e.preventDefault();
                toggleBtnSubmit();
                let token = $('input[name=_token]').val();
                let email = $('input[name=email]').val();
                if (email == '') {
                    Swal.fire({
                        text: "Email không được để trống!",
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
                        type: 'customer',
                        name: "reset-password"
                    }

                    $.ajax({
                        url: $('#kt_password_reset_form').data('action'),
                        data: data,
                        type: 'post',
                        dataType: 'json',
                        success: function(data) {
                            Swal.fire({
                                text: "Đã gửi!",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Chấp nhận!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            }).then(function(result) {
                                toggleBtnSubmit();
                            });
                        },
                        error: function(data) {
                            // console.log(data);
                            errors = data.responseJSON.errors;
                            // console.log(errors);
                            let text;
                            if(errors.unique){
                                text = "Email không tồn tại.";
                            }else{
                                text = "Có lỗi xảy ra. Hãy thử lại sau.";
                            }
                            Swal.fire({
                                text: text,
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Chấp nhận!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });

                            toggleBtnSubmit();
                        }
                    });
                }
            })
        })
    </script>
@endpush
