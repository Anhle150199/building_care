@extends('layout.app')
@push('css')
    <link href="{{ url('/') }}/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet"
        type="text/css" />
@endpush
@section('title', 'Danh sách tài khoản admin')
@section('content')

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        {{-- Start page: path page --}}
        <div class="toolbar" id="kt_toolbar">
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                    class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Danh sách tài khoản admin</h1>
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Quản lý tài khoản</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Admins</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">
                <div class="card">
                    <div class="card-header border-0 pt-6">
                        {{-- tìm kiếm --}}
                        <div class="card-title">
                            <div class="d-flex align-items-center position-relative my-1">
                                <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                            transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                        <path
                                            d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <input type="text" data-kt-user-table-filter="search"
                                    class="form-control form-control-solid w-250px ps-14" placeholder="Tìm kiếm" />
                            </div>
                        </div>
                        {{-- Option nâng cao --}}
                        <div class="card-toolbar">
                            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                {{-- Bộ lọc --}}
                                <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click"
                                    data-kt-menu-placement="bottom-end">
                                    <span class="svg-icon svg-icon-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none">
                                            <path
                                                d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>Bộ lọc</button>
                                <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                                    <div class="px-7 py-5">
                                        <div class="fs-5 text-dark fw-bolder">Tuỳ chọn</div>
                                    </div>
                                    <div class="separator border-gray-200"></div>
                                    <div class="px-7 py-5" data-kt-user-table-filter="form">
                                        {{-- Quyền --}}
                                        <div class="mb-10">
                                            <label class="form-label fs-6 fw-bold">Quyền:</label>
                                            <select class="form-select form-select-solid fw-bolder" data-kt-select2="true"
                                                data-placeholder="Select option" data-allow-clear="true"
                                                data-kt-user-table-filter="role" data-hide-search="true">
                                                <option></option>
                                                <option value="super_admin">Super Admin</option>
                                                <option value="admin">Admin</option>
                                            </select>
                                        </div>
                                        {{-- Phòng ban --}}
                                        <div class="mb-10">
                                            <label class="form-label fs-6 fw-bold">Phòng ban:</label>
                                            <select class="form-select form-select-solid fw-bolder" data-kt-select2="true"
                                                data-placeholder="Select option" data-allow-clear="true"
                                                data-kt-user-table-filter="two-step" data-hide-search="true">
                                                <option></option>
                                                <option value="Enabled">Phòng tài chính</option>
                                                <option value="Enabled">Phòng kinh doanh</option>
                                                <option value="Enabled">Phòng kỹ thuật</option>
                                            </select>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="reset"
                                                class="btn btn-light btn-active-light-primary fw-bold me-2 px-6"
                                                data-kt-menu-dismiss="true" data-kt-user-table-filter="reset">Đặt
                                                lại</button>
                                            <button type="submit" class="btn btn-primary fw-bold px-6"
                                                data-kt-menu-dismiss="true" data-kt-user-table-filter="filter">Áp
                                                dụng</button>
                                        </div>
                                    </div>
                                </div>
                                {{-- Export --}}
                                <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_export_users">
                                    <span class="svg-icon svg-icon-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none">
                                            <rect opacity="0.3" x="12.75" y="4.25" width="12" height="2" rx="1"
                                                transform="rotate(90 12.75 4.25)" fill="currentColor" />
                                            <path
                                                d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z"
                                                fill="currentColor" />
                                            <path
                                                d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z"
                                                fill="#C4C4C4" />
                                        </svg>
                                    </span>
                                    Export
                                </button>
                                {{-- Thêm tài khoản --}}
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_add_user">
                                    <span class="svg-icon svg-icon-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                                transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                                        </svg>
                                    </span>
                                    Tạo tài khoản
                                </button>
                            </div>
                            {{-- Xoá khi chọn --}}
                            <div class="d-flex justify-content-end align-items-center d-none"
                                data-kt-user-table-toolbar="selected">
                                <div class="fw-bolder me-5">
                                    Đã chọn
                                    <span class="me-2" data-kt-user-table-select="selected_count"></span>
                                </div>
                                <button type="button" class="btn btn-danger" data-kt-user-table-select="delete_selected">Xoá
                                    tài khoản</button>
                            </div>
                            {{-- Modal Export --}}
                            <div class="modal fade" id="kt_modal_export_users" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered mw-650px">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="fw-bolder">Export danh sách</h2>
                                            <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                                data-kt-users-modal-action="close">
                                                <span class="svg-icon svg-icon-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none">
                                                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                                            transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                                        <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                                            transform="rotate(45 7.41422 6)" fill="currentColor" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                            <form id="kt_modal_export_users_form" class="form" action="#">
                                                <div class="fv-row mb-10">
                                                    <label class="fs-6 fw-bold form-label mb-2">Chọn phòng ban:</label>
                                                    <select name="role" data-control="select2"
                                                        data-placeholder="Select a role" data-hide-search="true"
                                                        class="form-select form-select-solid fw-bolder">
                                                        <option>Tất cả</option>
                                                        <option value="Enabled">Phòng tài chính</option>
                                                        <option value="Enabled">Phòng kinh doanh</option>
                                                        <option value="Enabled">Phòng kỹ thuật</option>
                                                    </select>
                                                </div>
                                                <div class="fv-row mb-10">
                                                    <label class="required fs-6 fw-bold form-label mb-2">Chọn định
                                                        dạng:</label>
                                                    <select name="format" data-control="select2"
                                                        data-placeholder="Select a format" data-hide-search="true"
                                                        class="form-select form-select-solid fw-bolder">
                                                        <option></option>
                                                        <option value="excel">Excel</option>
                                                        <option value="pdf">PDF</option>
                                                        <option value="cvs">CVS</option>
                                                    </select>
                                                </div>
                                                <div class="text-center">
                                                    <button type="reset" class="btn btn-light me-3"
                                                        data-kt-users-modal-action="cancel">Huỷ</button>
                                                    <button type="submit" class="btn btn-primary"
                                                        data-kt-users-modal-action="submit">
                                                        <span class="indicator-label">Xuất</span>
                                                        <span class="indicator-progress">Đang xử lý...
                                                            <span
                                                                class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Modal thêm tài khoản --}}
                            <div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered mw-650px">
                                    <div class="modal-content">
                                        {{-- Tiêu đề modal --}}
                                        <div class="modal-header" id="kt_modal_add_user_header">
                                            <h2 class="fw-bolder">Thêm tài khoản</h2>
                                            <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                                data-kt-users-modal-action="close">
                                                <span class="svg-icon svg-icon-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none">
                                                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                                            transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                                        <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                                            transform="rotate(45 7.41422 6)" fill="currentColor" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                            {{-- Form thêm tài khoản --}}
                                            <form id="kt_modal_add_user_form" class="form" action="#">
                                                <div class="d-flex flex-column scroll-y me-n7 pe-7"
                                                    id="kt_modal_add_user_scroll" data-kt-scroll="true"
                                                    data-kt-scroll-activate="{default: false, lg: true}"
                                                    data-kt-scroll-max-height="auto"
                                                    data-kt-scroll-dependencies="#kt_modal_add_user_header"
                                                    data-kt-scroll-wrappers="#kt_modal_add_user_scroll"
                                                    data-kt-scroll-offset="300px">
                                                    {{-- Họ tên --}}
                                                    <div class="fv-row mb-7">
                                                        <label class="required fw-bold fs-6 mb-2">Họ tên</label>
                                                        <input type="text" name="user_name"
                                                            class="form-control form-control-solid mb-3 mb-lg-0"
                                                            placeholder="Nhập họ tên" />
                                                    </div>
                                                    {{-- Email --}}
                                                    <div class="fv-row mb-7">
                                                        <label class="required fw-bold fs-6 mb-2">Email</label>
                                                        <input type="email" name="user_email"
                                                            class="form-control form-control-solid mb-3 mb-lg-0"
                                                            placeholder="example@domain.com" value="smith@kpmg.com" />
                                                    </div>
                                                    {{-- Phòng ban --}}
                                                    <div class="fv-row mb-7">
                                                        <label class="required fw-bold fs-6 mb-2">Chọn phòng ban:</label>
                                                        <select name="department" data-control="select2"
                                                            data-placeholder="Chọn phòng ban" data-hide-search="true"
                                                            class="form-select form-select-solid fw-bolder">
                                                            <option></option>
                                                            <option value="Enabled">Phòng tài chính</option>
                                                            <option value="Enabled">Phòng kinh doanh</option>
                                                            <option value="Enabled">Phòng kỹ thuật</option>
                                                        </select>
                                                    </div>
                                                    {{-- Chức vụ --}}
                                                    <div class="fv-row mb-7">
                                                        <label class="required fw-bold fs-6 mb-2">Chức vụ</label>
                                                        <input type="email" name="user_email"
                                                            class="form-control form-control-solid mb-3 mb-lg-0"
                                                            placeholder="Nhập chức vụ" />
                                                    </div>
                                                    {{-- Quyền --}}
                                                    <div class="mb-7">
                                                        <label class="required fw-bold fs-6 mb-5">Quyền</label>
                                                        <div class="d-flex fv-row">
                                                            <div class="form-check form-check-custom form-check-solid">
                                                                <input class="form-check-input me-3" name="user_role"
                                                                    type="radio" value="0"
                                                                    id="kt_modal_update_role_option_0" checked='checked' />
                                                                <label class="form-check-label"
                                                                    for="kt_modal_update_role_option_0">
                                                                    <div class="fw-bolder text-gray-800">Super admin
                                                                    </div>
                                                                    <div class="text-gray-600">Tài khoản có quyền cao nhất.
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class='separator separator-dashed my-5'></div>
                                                        <div class="d-flex fv-row">
                                                            <div class="form-check form-check-custom form-check-solid">
                                                                <input class="form-check-input me-3" name="user_role"
                                                                    type="radio" value="1"
                                                                    id="kt_modal_update_role_option_1" />
                                                                <label class="form-check-label"
                                                                    for="kt_modal_update_role_option_1">
                                                                    <div class="fw-bolder text-gray-800">Admin</div>
                                                                    <div class="text-gray-600">Tài khoản dành cho nhân
                                                                        viên các phòng ban</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class='separator separator-dashed my-5'></div>
                                                    </div>
                                                </div>
                                                <div class="text-center pt-15">
                                                    <button type="reset" class="btn btn-light me-3"
                                                        data-kt-users-modal-action="cancel">Huỷ</button>
                                                    <button type="submit" class="btn btn-primary"
                                                        data-kt-users-modal-action="submit">
                                                        <span class="indicator-label">Tạo mới</span>
                                                        <span class="indicator-progress">Đang xử lý...
                                                            <span
                                                                class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Bảng danh sách --}}
                    <div class="card-body py-4">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
                            <thead>
                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="w-10px pe-2">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                            <input class="form-check-input" type="checkbox" data-kt-check="true"
                                                data-kt-check-target="#kt_table_users .form-check-input" value="1" />
                                        </div>
                                    </th>
                                    <th class="min-w-125px">Tài khoản</th>
                                    <th class="min-w-125px">Quyền</th>
                                    <th class="min-w-125px">Phòng ban</th>
                                    <th class="min-w-125px">Chức vụ</th>
                                    <th class="min-w-125px">Ngày tạo</th>
                                    <th class="text-center min-w-100px">Hành động</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-bold">
                                <tr>
                                    <td>
                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="1" />
                                        </div>
                                    </td>
                                    <td class="d-flex align-items-center">
                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                            <a href="../../demo1/dist/apps/user-management/users/view.html">
                                                <div class="symbol-label">
                                                    <img src="{{ url('/') }}/assets/media/avatars/300-6.jpg"
                                                        alt="Emma Smith" class="w-100" />
                                                </div>
                                            </a>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <a href="../../demo1/dist/apps/user-management/users/view.html"
                                                class="text-gray-800 text-hover-primary mb-1">Emma Smith</a>
                                            <span>smith@kpmg.com</span>
                                        </div>
                                    </td>
                                    <td>Super Admin</td>
                                    <td>
                                        Phòng Tài chính </td>
                                    <td>Nhân viên</td>
                                    <td>25 Jul 2022, 6:05 pm</td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-light btn-active-light-primary btn-sm btn-icon"
                                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            <span class="svg-icon svg-icon-5 m-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <rect x="10" y="10" width="4" height="4" rx="2" fill="currentColor"></rect>
                                                    <rect x="17" y="10" width="4" height="4" rx="2" fill="currentColor"></rect>
                                                    <rect x="3" y="10" width="4" height="4" rx="2" fill="currentColor"></rect>
                                                </svg>
                                            </span>
                                        </a>
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
                                            data-kt-menu="true">
                                            <div class="menu-item px-3">
                                                <a href="../../demo1/dist/apps/user-management/users/view.html"
                                                    class="menu-link px-3">Chỉnh sửa</a>
                                            </div>
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3"
                                                    data-kt-users-table-filter="delete_row">Xoá</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="1" />
                                        </div>
                                    </td>
                                    <td class="d-flex align-items-center">
                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                            <a href="../../demo1/dist/apps/user-management/users/view.html">
                                                <div class="symbol-label fs-3 bg-light-danger text-danger">M</div>
                                            </a>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <a href="../../demo1/dist/apps/user-management/users/view.html"
                                                class="text-gray-800 text-hover-primary mb-1">Melody Macy</a>
                                            <span>melody@altbox.com</span>
                                        </div>
                                    </td>
                                    <td>Admin</td>
                                    <td> Phòng nhân sự </td>
                                    <td> Nhân viên </td>
                                    <td>21 Feb 2022, 10:30 am</td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-light btn-active-light-primary btn-sm btn-icon"
                                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            <span class="svg-icon svg-icon-5 m-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <rect x="10" y="10" width="4" height="4" rx="2" fill="currentColor"></rect>
                                                    <rect x="17" y="10" width="4" height="4" rx="2" fill="currentColor"></rect>
                                                    <rect x="3" y="10" width="4" height="4" rx="2" fill="currentColor"></rect>
                                                </svg>
                                            </span>
                                        </a>
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
                                            data-kt-menu="true">
                                            <div class="menu-item px-3">
                                                <a href="../../demo1/dist/apps/user-management/users/view.html"
                                                    class="menu-link px-3">Edit</a>
                                            </div>
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3"
                                                    data-kt-users-table-filter="delete_row">Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ url('/') }}/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="{{ url('/') }}/assets/js/custom/apps/user-management/users/list/table.js"></script>
    <script src="{{ url('/') }}/assets/js/custom/apps/user-management/users/list/export-users.js"></script>
    <script src="{{ url('/') }}/assets/js/custom/apps/user-management/users/list/add.js"></script>
    {{-- <script src="{{ url('/') }}/assets/js/widgets.bundle.js"></script>
    <script src="{{ url('/') }}/assets/js/custom/widgets.js"></script>
    <script src="{{ url('/') }}/assets/js/custom/apps/chat/chat.js"></script>
    <script src="{{ url('/') }}/assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <script src="{{ url('/') }}/assets/js/custom/utilities/modals/create-app.js"></script>
    <script src="{{ url('/') }}/assets/js/custom/utilities/modals/users-search.js"></script> --}}
@endpush
