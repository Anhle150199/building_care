@extends('layout.app')
@push('css')
<link href="{{url('/')}}/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Toolbar-->
        <div class="toolbar" id="kt_toolbar">
            <!--begin::Container-->
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <!--begin::Page title-->

            </div>
            <!--end::Container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container-xxl">
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                    class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <!--begin::Title-->
                    <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Thông tin tài khoản
                    </h1>
                    <!--end::Title-->
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <!--end::Separator-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Trang chủ</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Tài khoản</li>
                        <!--end::Item-->
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>

                <!--begin::Basic info-->
                <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                        data-bs-target="#kt_account_profile_details" aria-expanded="true"
                        aria-controls="kt_account_profile_details">
                        <!--begin::Card title-->
                        <div class="card-title m-0">
                            <h3 class="fw-bolder m-0">Thông tin chi tiết</h3>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--begin::Card header-->
                    <!--begin::Content-->
                    <div id="kt_account_settings_profile_details" class="collapse show">
                        <!--begin::Form-->
                        <form id="kt_account_profile_details_form" class="form fv-plugins-bootstrap5 fv-plugins-framework"
                            novalidate="novalidate">
                            <!--begin::Card body-->
                            <div class="card-body border-top p-9">
                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-bold fs-6">Avatar</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <!--begin::Image input-->
                                        <div class="image-input image-input-outline" data-kt-image-input="true"
                                            style="background-image: url('assets/media/svg/avatars/blank.svg')">
                                            <!--begin::Preview existing avatar-->
                                            <div class="image-input-wrapper w-125px h-125px"
                                                style="background-image: url(assets/media/avatars/300-1.jpg)">
                                            </div>
                                            <!--end::Preview existing avatar-->
                                            <!--begin::Label-->
                                            <label
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="change" data-bs-toggle="tooltip" title=""
                                                data-bs-original-title="Change avatar">
                                                <i class="bi bi-pencil-fill fs-7"></i>
                                                <!--begin::Inputs-->
                                                <input type="file" name="avatar" accept=".png, .jpg, .jpeg">
                                                <input type="hidden" name="avatar_remove">
                                                <!--end::Inputs-->
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Cancel-->
                                            <span
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title=""
                                                data-bs-original-title="Cancel avatar">
                                                <i class="bi bi-x fs-2"></i>
                                            </span>
                                            <!--end::Cancel-->
                                            <!--begin::Remove-->
                                            <span
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="remove" data-bs-toggle="tooltip" title=""
                                                data-bs-original-title="Remove avatar">
                                                <i class="bi bi-x fs-2"></i>
                                            </span>
                                            <!--end::Remove-->
                                        </div>
                                        <!--end::Image input-->
                                        <!--begin::Hint-->
                                        <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                        <!--end::Hint-->
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Ho
                                        ten</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <input type="text" name="fname"
                                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                            placeholder="Nhap ho ten" value="{{Auth::user()->name}}">
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
                                <div class="row mb-6">
                                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Phòng ban</label>
                                    <div class="col-lg-8 fv-row">
                                        <input type="text" name="department"
                                            class="form-control form-control-lg form-control-solid" value="">
                                    </div>
                                </div>
                                <div class="row mb-6">
                                    <label class="col-lg-4 col-form-label  fw-bold fs-6">Chức vụ</label>
                                    <div class="col-lg-8 fv-row">
                                        <input type="text" name="position"
                                            class="form-control form-control-lg form-control-solid"
                                             value="">
                                    </div>
                                </div>
                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-bold fs-6">
                                        <span class="">Số điện thoại</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <input type="tel" name="phone"
                                            class="form-control form-control-lg form-control-solid"
                                            placeholder="Số điện thoại" value="">
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Card body-->
                            <!--begin::Actions-->
                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Thay đổi</button>
                            </div>
                            <!--end::Actions-->
                            <input type="hidden">
                            <div></div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Basic info-->
                <!--begin::Sign-in Method-->
                <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                        data-bs-target="#kt_account_signin_method">
                        <div class="card-title m-0">
                            <h3 class="fw-bolder m-0">Phương thức đăng nhập</h3>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Content-->
                    <div id="kt_account_settings_signin_method" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">
                            <!--begin::Email Address-->
                            <div class="d-flex flex-wrap align-items-center">
                                <!--begin::Label-->
                                <div id="kt_signin_email" class="">
                                    <div class="fs-6 fw-bolder mb-1">Địa chỉ Email</div>
                                    <div class="fw-bold text-gray-600">{{Auth::user()->email}}</div>
                                </div>
                                <!--end::Label-->
                                <!--begin::Edit-->
                                <div id="kt_signin_email_edit" class="flex-row-fluid d-none">
                                    <!--begin::Form-->
                                    <form id="kt_signin_change_email"
                                        class="form fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
                                        <div class="row mb-6">
                                            <div class="col-lg-6 mb-4 mb-lg-0">
                                                <div class="fv-row mb-0 fv-plugins-icon-container">
                                                    <label for="emailaddress" class="form-label fs-6 fw-bolder mb-3">Nhập địa chỉ email mới</label>
                                                    <input type="email"
                                                        class="form-control form-control-lg form-control-solid"
                                                        id="emailaddress" placeholder="Địa chỉ email" name="emailaddress"
                                                        value="{{Auth::user()->email}}">
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
                                    <!--end::Form-->
                                </div>
                                <!--end::Edit-->
                                <!--begin::Action-->
                                <div id="kt_signin_email_button" class="ms-auto">
                                    <button class="btn btn-light btn-active-light-primary">Thay đổi Email</button>
                                </div>
                                <!--end::Action-->
                            </div>
                            <!--end::Email Address-->
                            <!--begin::Separator-->
                            <div class="separator separator-dashed my-6"></div>
                            <!--end::Separator-->
                            <!--begin::Password-->
                            <div class="d-flex flex-wrap align-items-center mb-10">
                                <!--begin::Label-->
                                <div id="kt_signin_password">
                                    <div class="fs-6 fw-bolder mb-1">Mật khẩu</div>
                                    <div class="fw-bold text-gray-600">************</div>
                                </div>
                                <!--end::Label-->
                                <!--begin::Edit-->
                                <div id="kt_signin_password_edit" class="flex-row-fluid d-none">
                                    <!--begin::Form-->
                                    <form id="kt_signin_change_password"
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
                                        <div class="form-text mb-5">Password must be at least 8 character
                                            and contain symbols</div>
                                        <div class="d-flex">
                                            <button id="kt_password_submit" type="button"
                                                class="btn btn-primary me-2 px-6">Cập nhật mật khẩu</button>
                                            <button id="kt_password_cancel" type="button"
                                                class="btn btn-color-gray-400 btn-active-light-primary px-6">Huỷ</button>
                                        </div>
                                        <div></div>
                                    </form>
                                    <!--end::Form-->
                                </div>
                                <!--end::Edit-->
                                <!--begin::Action-->
                                <div id="kt_signin_password_button" class="ms-auto">
                                    <button class="btn btn-light btn-active-light-primary">Thay đổi mật khẩu</button>
                                </div>
                                <!--end::Action-->
                            </div>
                            <!--end::Password-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Sign-in Method-->

                <!--end::Notifications-->
                <!--begin::Deactivate Account-->
                <div class="card">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                        data-bs-target="#kt_account_deactivate" aria-expanded="true" aria-controls="kt_account_deactivate">
                        <div class="card-title m-0">
                            <h3 class="fw-bolder m-0">Deactivate Account</h3>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Content-->
                    <div id="kt_account_settings_deactivate" class="collapse show">
                        <!--begin::Form-->
                        <form id="kt_account_deactivate_form" class="form fv-plugins-bootstrap5 fv-plugins-framework"
                            novalidate="novalidate">
                            <!--begin::Card body-->
                            <div class="card-body border-top p-9">

                            </div>
                            <!--end::Card body-->
                            <!--begin::Card footer-->
                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                <button id="kt_account_deactivate_account_submit" type="submit"
                                    class="btn btn-danger fw-bold">Deactivate Account</button>
                            </div>
                            <!--end::Card footer-->
                            <input type="hidden">
                            <div></div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Deactivate Account-->
                <!--begin::Modals-->
                <!--begin::Modal - Two-factor authentication-->
                <div class="modal fade" id="kt_modal_two_factor_authentication" tabindex="-1" aria-hidden="true">
                    <!--begin::Modal header-->
                    <div class="modal-dialog modal-dialog-centered mw-650px">
                        <!--begin::Modal content-->
                        <div class="modal-content">
                            <!--begin::Modal header-->
                            <div class="modal-header flex-stack">
                                <!--begin::Title-->
                                <h2>Choose An Authentication Method</h2>
                                <!--end::Title-->
                                <!--begin::Close-->
                                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                    <span class="svg-icon svg-icon-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none">
                                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                                transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                            <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                                transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </div>
                                <!--end::Close-->
                            </div>
                            <!--begin::Modal header-->
                            <!--begin::Modal body-->
                            <div class="modal-body scroll-y pt-10 pb-15 px-lg-17">
                                <!--begin::Options-->
                                <div data-kt-element="options">
                                    <!--begin::Notice-->
                                    <p class="text-muted fs-5 fw-bold mb-10">In addition to your username
                                        and password, you’ll have to enter a code (delivered via app or SMS)
                                        to log into your account.</p>
                                    <!--end::Notice-->
                                    <!--begin::Wrapper-->
                                    <div class="pb-10">
                                        <!--begin::Option-->
                                        <input type="radio" class="btn-check" name="auth_option" value="apps"
                                            checked="checked" id="kt_modal_two_factor_authentication_option_1">
                                        <label
                                            class="btn btn-outline btn-outline-dashed btn-outline-default p-7 d-flex align-items-center mb-5"
                                            for="kt_modal_two_factor_authentication_option_1">
                                            <!--begin::Svg Icon | path: icons/duotune/coding/cod001.svg-->
                                            <span class="svg-icon svg-icon-4x me-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3"
                                                        d="M22.1 11.5V12.6C22.1 13.2 21.7 13.6 21.2 13.7L19.9 13.9C19.7 14.7 19.4 15.5 18.9 16.2L19.7 17.2999C20 17.6999 20 18.3999 19.6 18.7999L18.8 19.6C18.4 20 17.8 20 17.3 19.7L16.2 18.9C15.5 19.3 14.7 19.7 13.9 19.9L13.7 21.2C13.6 21.7 13.1 22.1 12.6 22.1H11.5C10.9 22.1 10.5 21.7 10.4 21.2L10.2 19.9C9.4 19.7 8.6 19.4 7.9 18.9L6.8 19.7C6.4 20 5.7 20 5.3 19.6L4.5 18.7999C4.1 18.3999 4.1 17.7999 4.4 17.2999L5.2 16.2C4.8 15.5 4.4 14.7 4.2 13.9L2.9 13.7C2.4 13.6 2 13.1 2 12.6V11.5C2 10.9 2.4 10.5 2.9 10.4L4.2 10.2C4.4 9.39995 4.7 8.60002 5.2 7.90002L4.4 6.79993C4.1 6.39993 4.1 5.69993 4.5 5.29993L5.3 4.5C5.7 4.1 6.3 4.10002 6.8 4.40002L7.9 5.19995C8.6 4.79995 9.4 4.39995 10.2 4.19995L10.4 2.90002C10.5 2.40002 11 2 11.5 2H12.6C13.2 2 13.6 2.40002 13.7 2.90002L13.9 4.19995C14.7 4.39995 15.5 4.69995 16.2 5.19995L17.3 4.40002C17.7 4.10002 18.4 4.1 18.8 4.5L19.6 5.29993C20 5.69993 20 6.29993 19.7 6.79993L18.9 7.90002C19.3 8.60002 19.7 9.39995 19.9 10.2L21.2 10.4C21.7 10.5 22.1 11 22.1 11.5ZM12.1 8.59998C10.2 8.59998 8.6 10.2 8.6 12.1C8.6 14 10.2 15.6 12.1 15.6C14 15.6 15.6 14 15.6 12.1C15.6 10.2 14 8.59998 12.1 8.59998Z"
                                                        fill="currentColor"></path>
                                                    <path
                                                        d="M17.1 12.1C17.1 14.9 14.9 17.1 12.1 17.1C9.30001 17.1 7.10001 14.9 7.10001 12.1C7.10001 9.29998 9.30001 7.09998 12.1 7.09998C14.9 7.09998 17.1 9.29998 17.1 12.1ZM12.1 10.1C11 10.1 10.1 11 10.1 12.1C10.1 13.2 11 14.1 12.1 14.1C13.2 14.1 14.1 13.2 14.1 12.1C14.1 11 13.2 10.1 12.1 10.1Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <span class="d-block fw-bold text-start">
                                                <span class="text-dark fw-bolder d-block fs-3">Authenticator
                                                    Apps</span>
                                                <span class="text-muted fw-bold fs-6">Get codes from an app
                                                    like Google Authenticator, Microsoft Authenticator,
                                                    Authy or 1Password.</span>
                                            </span>
                                        </label>
                                        <!--end::Option-->
                                        <!--begin::Option-->
                                        <input type="radio" class="btn-check" name="auth_option" value="sms"
                                            id="kt_modal_two_factor_authentication_option_2">
                                        <label
                                            class="btn btn-outline btn-outline-dashed btn-outline-default p-7 d-flex align-items-center"
                                            for="kt_modal_two_factor_authentication_option_2">
                                            <!--begin::Svg Icon | path: icons/duotune/communication/com003.svg-->
                                            <span class="svg-icon svg-icon-4x me-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3"
                                                        d="M2 4V16C2 16.6 2.4 17 3 17H13L16.6 20.6C17.1 21.1 18 20.8 18 20V17H21C21.6 17 22 16.6 22 16V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4Z"
                                                        fill="currentColor"></path>
                                                    <path
                                                        d="M18 9H6C5.4 9 5 8.6 5 8C5 7.4 5.4 7 6 7H18C18.6 7 19 7.4 19 8C19 8.6 18.6 9 18 9ZM16 12C16 11.4 15.6 11 15 11H6C5.4 11 5 11.4 5 12C5 12.6 5.4 13 6 13H15C15.6 13 16 12.6 16 12Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <span class="d-block fw-bold text-start">
                                                <span class="text-dark fw-bolder d-block fs-3">SMS</span>
                                                <span class="text-muted fw-bold fs-6">We will send a code
                                                    via SMS if you need to use your backup login
                                                    method.</span>
                                            </span>
                                        </label>
                                        <!--end::Option-->
                                    </div>
                                    <!--end::Options-->
                                    <!--begin::Action-->
                                    <button class="btn btn-primary w-100"
                                        data-kt-element="options-select">Continue</button>
                                    <!--end::Action-->
                                </div>
                                <!--end::Options-->
                                <!--begin::Apps-->
                                <div class="d-none" data-kt-element="apps">
                                    <!--begin::Heading-->
                                    <h3 class="text-dark fw-bolder mb-7">Authenticator Apps</h3>
                                    <!--end::Heading-->
                                    <!--begin::Description-->
                                    <div class="text-gray-500 fw-bold fs-6 mb-10">Using an authenticator app
                                        like
                                        <a href="https://support.google.com/accounts/answer/1066447?hl=en"
                                            target="_blank">Google Authenticator</a>,
                                        <a href="https://www.microsoft.com/en-us/account/authenticator"
                                            target="_blank">Microsoft Authenticator</a>,
                                        <a href="https://authy.com/download/" target="_blank">Authy</a>, or
                                        <a href="https://support.1password.com/one-time-passwords/"
                                            target="_blank">1Password</a>, scan the QR code. It will
                                        generate a 6 digit code for you to enter below.
                                        <!--begin::QR code image-->
                                        <div class="pt-5 text-center">
                                            <img src="assets/media/misc/qr.png" alt="" class="mw-150px">
                                        </div>
                                        <!--end::QR code image-->
                                    </div>
                                    <!--end::Description-->
                                    <!--begin::Notice-->
                                    <div
                                        class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-10 p-6">
                                        <!--begin::Icon-->
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
                                        <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10"
                                                    fill="currentColor"></rect>
                                                <rect x="11" y="14" width="7" height="2" rx="1"
                                                    transform="rotate(-90 11 14)" fill="currentColor"></rect>
                                                <rect x="11" y="17" width="2" height="2" rx="1"
                                                    transform="rotate(-90 11 17)" fill="currentColor"></rect>
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <!--end::Icon-->
                                        <!--begin::Wrapper-->
                                        <div class="d-flex flex-stack flex-grow-1">
                                            <!--begin::Content-->
                                            <div class="fw-bold">
                                                <div class="fs-6 text-gray-700">If you having trouble using
                                                    the QR code, select manual entry on your app, and enter
                                                    your username and the code:
                                                    <div class="fw-bolder text-dark pt-2">
                                                        KBSS3QDAAFUMCBY63YCKI5WSSVACUMPN</div>
                                                </div>
                                            </div>
                                            <!--end::Content-->
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
                                    <!--end::Notice-->
                                    <!--begin::Form-->
                                    <form data-kt-element="apps-form"
                                        class="form fv-plugins-bootstrap5 fv-plugins-framework" action="#">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row fv-plugins-icon-container">
                                            <input type="text" class="form-control form-control-lg form-control-solid"
                                                placeholder="Enter authentication code" name="code">
                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Actions-->
                                        <div class="d-flex flex-center">
                                            <button type="reset" data-kt-element="apps-cancel"
                                                class="btn btn-light me-3">Cancel</button>
                                            <button type="submit" data-kt-element="apps-submit" class="btn btn-primary">
                                                <span class="indicator-label">Submit</span>
                                                <span class="indicator-progress">Please wait...
                                                    <span
                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
                                        </div>
                                        <!--end::Actions-->
                                        <div></div>
                                    </form>
                                    <!--end::Form-->
                                </div>
                                <!--end::Options-->
                                <!--begin::SMS-->
                                <div class="d-none" data-kt-element="sms">
                                    <!--begin::Heading-->
                                    <h3 class="text-dark fw-bolder fs-3 mb-5">SMS: Verify Your Mobile Number
                                    </h3>
                                    <!--end::Heading-->
                                    <!--begin::Notice-->
                                    <div class="text-muted fw-bold mb-10">Enter your mobile phone number
                                        with country code and we will send you a verification code upon
                                        request.</div>
                                    <!--end::Notice-->
                                    <!--begin::Form-->
                                    <form data-kt-element="sms-form"
                                        class="form fv-plugins-bootstrap5 fv-plugins-framework" action="#">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row fv-plugins-icon-container">
                                            <input type="text" class="form-control form-control-lg form-control-solid"
                                                placeholder="Mobile number with country code..." name="mobile">
                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Actions-->
                                        <div class="d-flex flex-center">
                                            <button type="reset" data-kt-element="sms-cancel"
                                                class="btn btn-light me-3">Cancel</button>
                                            <button type="submit" data-kt-element="sms-submit" class="btn btn-primary">
                                                <span class="indicator-label">Submit</span>
                                                <span class="indicator-progress">Please wait...
                                                    <span
                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
                                        </div>
                                        <!--end::Actions-->
                                        <div></div>
                                    </form>
                                    <!--end::Form-->
                                </div>
                                <!--end::SMS-->
                            </div>
                            <!--begin::Modal body-->
                        </div>
                        <!--end::Modal content-->
                    </div>
                    <!--end::Modal header-->
                </div>
                <!--end::Modal - Two-factor authentication-->
                <!--end::Modals-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>
@endsection

@push('js')
	<!--begin::Page Vendors Javascript(used by this page)-->
	<script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
	<!--end::Page Vendors Javascript-->
	<!--begin::Page Custom Javascript(used by this page)-->
	<script src="{{url('/')}}/assets/js/custom/account/settings/signin-methods.js"></script>
	<script src="{{url('/')}}/assets/js/custom/account/settings/profile-details.js"></script>
	<script src="{{url('/')}}/assets/js/custom/account/settings/deactivate-account.js"></script>
	<script src="{{url('/')}}/assets/js/widgets.bundle.js"></script>
	<script src="{{url('/')}}/assets/js/custom/widgets.js"></script>
	<script src="{{url('/')}}/assets/js/custom/apps/chat/chat.js"></script>
	<script src="{{url('/')}}/assets/js/custom/utilities/modals/upgrade-plan.js"></script>
	<script src="{{url('/')}}/assets/js/custom/utilities/modals/create-app.js"></script>
	<script src="{{url('/')}}/assets/js/custom/utilities/modals/offer-a-deal/type.js"></script>
	<script src="{{url('/')}}/assets/js/custom/utilities/modals/offer-a-deal/details.js"></script>
	<script src="{{url('/')}}/assets/js/custom/utilities/modals/offer-a-deal/finance.js"></script>
	<script src="{{url('/')}}/assets/js/custom/utilities/modals/offer-a-deal/complete.js"></script>
	<script src="{{url('/')}}/assets/js/custom/utilities/modals/offer-a-deal/main.js"></script>
	<script src="{{url('/')}}/assets/js/custom/utilities/modals/two-factor-authentication.js"></script>
	<script src="{{url('/')}}/assets/js/custom/utilities/modals/users-search.js"></script>
	<!--end::Page Custom Javascript-->

@endpush
