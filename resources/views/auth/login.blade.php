@extends('layout.guest')

@section('content')
    <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">

        <!--begin::Wrapper-->
        <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
            <!--begin::Form-->
            <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form"
                data-kt-redirect-url="../../demo1/dist/index.html" action="#">
                <!--begin::Heading-->
                <div class="text-center mb-10">
                    <!--begin::Title-->
                    <h1 class="text-dark mb-3">Đăng nhập Building Care</h1>
                    <!--end::Title-->
                </div>
                <div class="fv-row mb-10">
                    <label class="form-label fs-6 fw-bolder text-dark">Email</label>

                    <input class="form-control form-control-lg form-control-solid" type="text" name="email"
                        autocomplete="off" />
                </div>
                <div class="fv-row mb-10">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-stack mb-2">
                        <label class="form-label fw-bolder text-dark fs-6 mb-0">Mật khẩu</label>
                        <a href="../../demo1/dist/authentication/layouts/dark/password-reset.html"
                            class="link-primary fs-6 fw-bolder">Quên mật khẩu ?</a>
                    </div>
                    <!--end::Wrapper-->
                    <!--begin::Input-->
                    <input class="form-control form-control-lg form-control-solid" type="password" name="password"
                        autocomplete="off" />
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--begin::Actions-->
                <div class="text-center">
                    <!--begin::Submit button-->
                    <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                        <span class="indicator-label">Đăng nhập</span>
                        <span class="indicator-progress">Đang tải...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!--end::Submit button-->
                </div>
                <!--end::Actions-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Wrapper-->
    </div>
@endsection

@push('js')
    <script src="assets/js/custom/authentication/sign-in/general.js"></script>
@endpush
