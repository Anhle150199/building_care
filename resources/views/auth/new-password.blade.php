@extends('layout.guest')
@section('content')

    <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
        <div class="w-lg-550px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
            <form class="form w-100" novalidate="novalidate" id="kt_new_password_form" data-token={{@$token}} data-action="{{ route('auth.reset-password')}}" data-redirect="{{ route('auth.login') }}">
                @csrf
                <div class="text-center mb-10">
                    <h1 class="text-dark mb-3">Mật khẩu mới</h1>
                    <div class="text-gray-400 fw-bold fs-4">Bạn đã có mật khẩu mới?
                        <a href="{{ route('auth.form-login') }}"
                            class="link-primary fw-bolder">Đăng nhập</a>
                    </div>
                </div>
                <div class="mb-10 fv-row" data-kt-password-meter="true">
                    <div class="mb-1">
                        <label class="form-label fw-bolder text-dark fs-6">Mật khẩu</label>

                        <div class="position-relative mb-3">
                            <input class="form-control form-control-lg form-control-solid" type="password" id="password" placeholder=""
                                name="password" autocomplete="off" />
                            <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                data-kt-password-meter-control="visibility">
                                <i class="bi bi-eye-slash fs-2"></i>
                                <i class="bi bi-eye fs-2 d-none"></i>
                            </span>
                        </div>
                        <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                        </div>
                    </div>
                    <div class="text-muted">Sử dụng 8 ký tự trở lên với sự kết hợp của các chữ cái, số và ký hiệu.</div>
                </div>
                <div class="fv-row mb-10">
                    <label class="form-label fw-bolder text-dark fs-6">Nhập lại mật khẩu</label>
                    <input class="form-control form-control-lg form-control-solid" type="password" placeholder=""
                        name="confirm-password" autocomplete="off" />
                </div>

                <div class="text-center">
                    <button type="button" id="kt_new_password_submit" class="btn btn-lg btn-primary fw-bolder">
                        <span class="indicator-label">Tiếp tục</span>
                        <span class="indicator-progress">Đang tải...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="assets/js/custom/authentication/password-reset/new-password.js"></script>
@endpush
