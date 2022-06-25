@extends('layout.app')
@push('css')
<link href="{{url('/')}}/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
@endpush
@section('title', 'Thông tin tài khoản')

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="toolbar" id="kt_toolbar">
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            </div>
        </div>
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                    class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Thông tin tài khoản
                    </h1>
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Tài khoản</li>
                    </ul>
                </div>

                <div class="card mb-5 mb-xl-10">
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                        data-bs-target="#kt_account_profile_details" aria-expanded="true"
                        aria-controls="kt_account_profile_details">
                        <div class="card-title m-0">
                            <h3 class="fw-bolder m-0">Thông tin chi tiết</h3>
                        </div>
                    </div>
                    <div id="kt_account_settings_profile_details" class="collapse show">
                        <form id="kt_account_profile_details_form" data-action="{{ route('admin.users.profile-detail', ['id'=>1]) }}" class="form fv-plugins-bootstrap5 fv-plugins-framework"
                            novalidate="novalidate">
                            <div class="card-body border-top p-9">
                                <div class="row mb-6">
                                    <label class="col-lg-4 col-form-label fw-bold fs-6">Avatar</label>
                                    <div class="col-lg-8 fv-row">
                                        <div class="image-input image-input-outline" data-kt-image-input="true"
                                            style="background-image: url('{{url('/')}}/assets/media/svg/avatars/blank.svg')">
                                            <div class="image-input-wrapper w-125px h-125px"
                                                style="background-image: url({{url('')."/assets/media/avatars/".Auth::user()->avatar}})">
                                            </div>
                                            <label
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="change" data-bs-toggle="tooltip" title=""
                                                data-bs-original-title="Change avatar">
                                                <i class="bi bi-pencil-fill fs-7"></i>
                                                <input type="file" name="avatar" accept=".png, .jpg, .jpeg">
                                                <input type="hidden" name="avatar_remove">
                                            </label>
                                            <span
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title=""
                                                data-bs-original-title="Cancel avatar">
                                                <i class="bi bi-x fs-2"></i>
                                            </span>
                                            <span
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="remove" data-bs-toggle="tooltip" title=""
                                                data-bs-original-title="Remove avatar">
                                                <i class="bi bi-x fs-2"></i>
                                            </span>
                                        </div>
                                        <div class="form-text">Chấp nhận đuôi: png, jpg, jpeg.</div>
                                     </div>
                                </div>
                                <div class="row mb-6">
                                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Họ tên</label>
                                    <div class="col-lg-8 fv-row">
                                        <input type="text" name="name"
                                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                            placeholder="Nhap ho ten" value="{{Auth::user()->name}}">
                                    </div>
                                </div>
                                <div class="row mb-6">
                                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Bộ phận</label>
                                    <div class="col-lg-8 fv-row">
                                        <select name="department" data-control="select2" id="department"
                                            data-placeholder="Chọn bộ phận" data-hide-search="true"
                                            class="form-select form-select-solid fw-bolder">
                                            <option></option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}" @if($department->id == Auth::user()->department_id) selected @endif data-name="{{ $department->name }}">{{ $department->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-6">
                                    <label class="col-lg-4 col-form-label  fw-bold fs-6">Chức vụ</label>
                                    <div class="col-lg-8 fv-row">
                                        <input type="text" name="position"
                                            class="form-control form-control-lg form-control-solid"
                                             value="{{Auth::user()->position}}">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Lưu</button>
                            </div>
                            <input type="hidden">
                            <div></div>
                        </form>
                    </div>
                </div>
                {{--  --}}
                <div class="card mb-5 mb-xl-10">
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                        data-bs-target="#kt_account_signin_method">
                        <div class="card-title m-0">
                            <h3 class="fw-bolder m-0">Phương thức đăng nhập</h3>
                        </div>
                    </div>
                    <div id="kt_account_settings_signin_method" class="collapse show">
                        <div class="card-body border-top p-9">
                            <div class="d-flex flex-wrap align-items-center">
                                <div id="kt_signin_email" class="">
                                    <div class="fs-6 fw-bolder mb-1">Địa chỉ Email</div>
                                    <div class="fw-bold text-gray-600">{{Auth::user()->email}}</div>
                                </div>
                                <div id="kt_signin_email_edit" class="flex-row-fluid d-none">
                                    <form id="kt_signin_change_email" data-action="{{ route('admin.users.update-email') }}"
                                        class="form fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
                                        <div class="row mb-6">
                                            <div class="col-lg-6 mb-4 mb-lg-0">
                                                <div class="fv-row mb-0 fv-plugins-icon-container">
                                                    <label for="emailaddress" class="form-label fs-6 fw-bolder mb-3">Nhập địa chỉ email mới</label>
                                                    <input type="email"
                                                        class="form-control form-control-lg form-control-solid"
                                                        id="emailaddress" placeholder="Địa chỉ email" name="emailaddress"
                                                        value="">
                                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="fv-row mb-0 fv-plugins-icon-container">
                                                    <label for="confirmemailpassword"
                                                        class="form-label fs-6 fw-bolder mb-3">Xác thực mật khẩu</label>
                                                    <input type="password"
                                                        class="form-control form-control-lg form-control-solid"
                                                        name="confirmemailpassword" id="confirmemailpassword">
                                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex">
                                            <button id="kt_signin_submit" type="button"
                                                class="btn btn-primary me-2 px-6">Cập nhật</button>
                                            <button id="kt_signin_cancel" type="button"
                                                class="btn btn-color-gray-400 btn-active-light-primary px-6">Huỷ</button>
                                        </div>
                                        <div></div>
                                    </form>
                                </div>
                                <div id="kt_signin_email_button" class="ms-auto">
                                    <button class="btn btn-light btn-active-light-primary">Thay đổi Email</button>
                                </div>
                            </div>
                            <div class="separator separator-dashed my-6"></div>
                            <div class="d-flex flex-wrap align-items-center mb-10">
                                <div id="kt_signin_password">
                                    <div class="fs-6 fw-bolder mb-1">Mật khẩu</div>
                                    <div class="fw-bold text-gray-600">************</div>
                                </div>
                                <div id="kt_signin_password_edit" class="flex-row-fluid d-none">
                                    <form id="kt_signin_change_password" data-action="{{ route('admin.users.update-password') }}"
                                        class="form fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
                                        <div class="row mb-1">
                                            <div class="col-lg-4">
                                                <div class="fv-row mb-0 fv-plugins-icon-container">
                                                    <label for="currentpassword"
                                                        class="form-label fs-6 fw-bolder mb-3">Mật khẩu hiện tại</label>
                                                    <input type="password"
                                                        class="form-control form-control-lg form-control-solid"
                                                        name="currentpassword" id="currentpassword">
                                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="fv-row mb-0 fv-plugins-icon-container">
                                                    <label for="newpassword" class="form-label fs-6 fw-bolder mb-3">Mật khẩu mới</label>
                                                    <input type="password"
                                                        class="form-control form-control-lg form-control-solid"
                                                        name="newpassword" id="newpassword">
                                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="fv-row mb-0 fv-plugins-icon-container">
                                                    <label for="confirmpassword"
                                                        class="form-label fs-6 fw-bolder mb-3">Xác nhận mật khẩu</label>
                                                    <input type="password"
                                                        class="form-control form-control-lg form-control-solid"
                                                        name="confirmpassword" id="confirmpassword">
                                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex">
                                            <button id="kt_password_submit" type="button"
                                                class="btn btn-primary me-2 px-6">Cập nhật mật khẩu</button>
                                            <button id="kt_password_cancel" type="button"
                                                class="btn btn-color-gray-400 btn-active-light-primary px-6">Huỷ</button>
                                        </div>
                                        <div></div>
                                    </form>
                                </div>
                                <div id="kt_signin_password_button" class="ms-auto">
                                    <button class="btn btn-light btn-active-light-primary">Thay đổi mật khẩu</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="card">
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                        data-bs-target="#kt_account_deactivate" aria-expanded="true" aria-controls="kt_account_deactivate">
                        <div class="card-title m-0">
                            <h3 class="fw-bolder m-0">Deactivate Account</h3>
                        </div>
                    </div>
                    <div id="kt_account_settings_deactivate" class="collapse show">
                        <form id="kt_account_deactivate_form" class="form fv-plugins-bootstrap5 fv-plugins-framework"
                            novalidate="novalidate">
                            <div class="card-body border-top p-9">

                            </div>
                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                <button id="kt_account_deactivate_account_submit" type="submit"
                                    class="btn btn-danger fw-bold">Deactivate Account</button>
                            </div>
                            <input type="hidden">
                            <div></div>
                        </form>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
@endsection

@push('js')
	{{-- <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script> --}}
    <script src="{{ url('/') }}/assets/plugins/custom/formrepeater/formrepeater.bundle.js"></script>
	<script src="{{url('/')}}/assets/js/custom/account/settings/profile-details.js"></script>
	<script src="{{url('/')}}/assets/js/custom/account/settings/signin-methods.js"></script>
	{{-- <script src="{{url('/')}}/assets/js/custom/account/settings/deactivate-account.js"></script> --}}
@endpush
