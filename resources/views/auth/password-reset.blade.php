@extends('layout.guest')
@section('content')
    <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
        <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
            <form class="form w-100" novalidate="novalidate" id="kt_password_reset_form">
                <div class="text-center mb-10">
                    <h1 class="text-dark mb-3">Quên mật khẩu ?</h1>

                    <div class="text-gray-400 fw-bold fs-4">Nhập email đã đăng ký của bạn để lấy lại mật khẩu.</div>
                </div>
                <div class="fv-row mb-10">
                    <label class="form-label fw-bolder text-gray-900 fs-6">Email</label>
                    <input class="form-control form-control-solid" type="email" placeholder="" name="email"
                        autocomplete="off" />
                </div>
                <div class="d-flex flex-wrap justify-content-center pb-lg-0">
                    <button type="button" id="kt_password_reset_submit" class="btn btn-lg btn-primary fw-bolder me-4">
                        <span class="indicator-label">Tiếp tục</span>
                        <span class="indicator-progress">Đang tải...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <a href="{{ route('admin.auth.form-login') }}"
                        class="btn btn-lg btn-light-primary fw-bolder">Hủy</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="assets/js/custom/authentication/password-reset/password-reset.js"></script>
@endpush
