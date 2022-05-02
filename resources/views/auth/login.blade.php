@extends('layout.guest')

@section('content')
    <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
        <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
            <!--begin::Form-->
            <form class="form w-100" novalidate="novalidate" method="post" id="kt_sign_in_form" data-kt-redirect-url="{{ route('admin.dashboard') }}" action="{{ route('auth.login') }}">
                @csrf
                <div class="text-center mb-10">
                    <h1 class="text-dark mb-3">Đăng nhập Building Care</h1>
                </div>

                <div class="fv-row mb-10">
                    <label class="form-label fs-6 fw-bolder text-dark">Email</label>
                    <input class="form-control form-control-lg form-control-solid" type="text" name="email"
                        autocomplete="off" />
                </div>

                <div class="fv-row mb-10">
                    <div class="d-flex flex-stack mb-2">
                        <label class="form-label fw-bolder text-dark fs-6 mb-0">Mật khẩu</label>
                        <a href="{{ route('auth.forgot-password') }}" class="link-primary fs-6 fw-bolder">Quên mật
                            khẩu?</a>
                    </div>
                    <input class="form-control form-control-lg form-control-solid" type="password" name="password"
                        autocomplete="off" />
                </div>

                <div class="text-center">
                    <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                        <span class="indicator-label">Đăng nhập</span>
                        <span class="indicator-progress">Đang tải...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="assets/js/custom/authentication/sign-in/general.js"></script>
@endpush
