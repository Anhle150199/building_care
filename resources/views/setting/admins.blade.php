@extends('layout.app')
@push('css')
    <link href="{{ url('/') }}/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet"
        type="text/css" />
@endpush
@section('title', 'Danh sách admins')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        {{-- Start page: path page --}}
        <div class="toolbar" id="kt_toolbar">
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                    class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Danh sách admins</h1>
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Cài đặt hệ thống</li>
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

                                {{-- Export --}}
                                @include('layout.datatable.btn-export')
                                {{-- Thêm mới --}}
                                @if (Auth::user()->role == 'super')
                                    @include('layout.datatable.btn-add-new')
                                @endif
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
                                                    <label class="required fs-6 fw-bold form-label mb-2">Chọn định
                                                        dạng:</label>
                                                    <select name="format" data-control="select2"
                                                        data-placeholder="Select a format" data-hide-search="true"
                                                        class="form-select form-select-solid fw-bolder">
                                                        <option></option>
                                                        <option value="excel">Excel</option>
                                                        <option value="pdf">PDF</option>
                                                        <option value="csv">CSV</option>
                                                    </select>
                                                </div>
                                                <div class="text-center">
                                                    <button type="reset" class="btn btn-light me-3"
                                                        data-kt-users-modal-action="cancel">Huỷ</button>
                                                    <button type="submit" class="btn btn-primary"
                                                        data-kt-users-modal-action="submit">
                                                        <span class="indicator-label">Xuất</span>
                                                        <span class="indicator-progress">
                                                            Đang xử lý...
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
                                            <input type="hidden" value="new" id="add-form-type">
                                            <input type="hidden"  id="id-user-edit">
                                            <form id="kt_modal_add_user_form" class="form" action="#">
                                                @csrf
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
                                                        <input type="text" name="user_name" id="name"
                                                            class="form-control form-control-solid mb-3 mb-lg-0"
                                                            placeholder="Nhập họ tên" />
                                                    </div>
                                                    {{-- Email --}}
                                                    <div class="fv-row mb-7">
                                                        <label class="required fw-bold fs-6 mb-2">Email</label>
                                                        <input type="email" name="user_email" id="email"
                                                            class="form-control form-control-solid mb-3 mb-lg-0"
                                                            placeholder="example@domain.com" />
                                                    </div>
                                                    {{-- Bộ phận --}}
                                                    <div class="fv-row mb-7">
                                                        <label class="required fw-bold fs-6 mb-2">Chọn bộ phận:</label>
                                                        <select name="department" data-control="select2" id="department"
                                                            data-placeholder="Chọn bộ phận" data-hide-search="true"
                                                            class="form-select form-select-solid fw-bolder">
                                                            <option></option>
                                                            @foreach ($departments as $department)
                                                                <option value="{{ $department->id }}" data-name="{{ $department->name }}">{{ $department->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    {{-- Chức vụ --}}
                                                    <div class="fv-row mb-7">
                                                        <label class="required fw-bold fs-6 mb-2">Chức vụ</label>
                                                        <input type="text" name="position" id="position"
                                                            class="form-control form-control-solid mb-3 mb-lg-0"
                                                            placeholder="Nhập chức vụ" />
                                                    </div>
                                                    {{-- Quyền --}}
                                                    <div class="mb-7">
                                                        <label class="required fw-bold fs-6 mb-5">Quyền</label>
                                                        <div class="d-flex fv-row">
                                                            <div class="form-check form-check-custom form-check-solid">
                                                                <input class="form-check-input me-3" name="user_role"
                                                                    type="radio" value="super"
                                                                    id="kt_modal_update_role_option_0" />
                                                                <label class="form-check-label"
                                                                    for="kt_modal_update_role_option_0">
                                                                    <div class="fw-bolder text-gray-800">Super admin</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class='separator separator-dashed my-5'></div>
                                                        <div class="d-flex fv-row">
                                                            <div class="form-check form-check-custom form-check-solid">
                                                                <input class="form-check-input me-3" name="user_role"
                                                                    type="radio" value="admin" checked=true
                                                                    id="kt_modal_update_role_option_1" />
                                                                <label class="form-check-label"
                                                                    for="kt_modal_update_role_option_1">
                                                                    <div class="fw-bolder text-gray-800">Admin</div>
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
                                                        <span class="indicator-label" id="btn-submit-form-create">Thêm
                                                            mới</span>
                                                        <span class="indicator-progress">Đang xử lý...
                                                            <span
                                                                class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                        </span>
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
                                    <th class="min-w-125px">Bộ phận</th>
                                    <th class="min-w-125px">Trạng thái</th>
                                    <th class="min-w-125px">Ngày tạo</th>
                                    <th class="text-center min-w-100px">
                                        @if (Auth::user()->role == 'super')
                                            Thao tác
                                        @endif
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-bold">
                                @foreach ($admins1 as $admin)
                                    <tr id="row_{{ $admin->id }}" data-id="{{ $admin->id }}">
                                        <td>
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox"
                                                    value="{{ $admin->id }}" />
                                            </div>
                                        </td>
                                        <td class="d-flex align-items-center">
                                            <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                <div class="symbol-label">
                                                    <img src="{{ url('/') . '/assets/media/avatars/' . $admin->avatar }}"
                                                        class="w-100" />
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <a href="#" id="name_{{ $admin->id }}"
                                                    class="text-gray-800 text-hover-primary mb-1">{{ $admin->name }}</a>
                                                <span id="email_{{ $admin->id }}">{{ $admin->email }}</span>
                                            </div>
                                        </td>
                                        <td id="role_{{ $admin->id }}">
                                            @if ($admin->role == 'super')
                                                Super Admin
                                            @else
                                                Admin
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span id="department_{{ $admin->id }}"
                                                    class="text-gray-800 text-hover-primary mb-1">{{ $admin->department }}</span>
                                                <span id="position_{{ $admin->id }}">{{ $admin->position }}</span>
                                            </div>
                                        </td>
                                        <td id="status_{{ $admin->id }}">
                                            {{ $admin->status }}
                                            @if($admin->status == "verifying")
                                            <button class="d-block btn btn-sm btn-primary btn-resend" data-email="{{$admin->email}}">
                                                <span class="indicator-label">Gửi lại Email</span>
                                                <span class="indicator-progress">Đang gửi...
                                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>

                                            </button>
                                            @endif
                                        </td>
                                        <td id="time_{{ $admin->id }}">
                                            {{ $admin->created_at->format('d M Y, h:i a') }}</td>
                                        <td class="text-center">
                                            @if (Auth::user()->role == 'super')
                                                <a href="#" class="btn btn-light btn-active-light-primary btn-sm btn-icon"
                                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                    <span class="svg-icon svg-icon-5 m-0">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none">
                                                            <rect x="10" y="10" width="4" height="4" rx="2"
                                                                fill="currentColor"></rect>
                                                            <rect x="17" y="10" width="4" height="4" rx="2"
                                                                fill="currentColor"></rect>
                                                            <rect x="3" y="10" width="4" height="4" rx="2"
                                                                fill="currentColor"></rect>
                                                        </svg>
                                                    </span>
                                                </a>
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
                                                    data-kt-menu="true">
                                                    <div class="menu-item px-3">
                                                        <a class="menu-link px-3 btn-edit"
                                                            onclick="showEditModal('{{ $admin->id }}')">Chỉnh sửa</a>
                                                    </div>
                                                    @if ($admin->status == 'activated' && $admin->id != Auth::user()->id)
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3" onclick="lockAcc('{{$admin->id}}')">Khoá</a>
                                                        </div>
                                                    @endif

                                                    @if ($admin->status == 'lock' && $admin->id != Auth::user()->id)
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3" onclick="activeAcc('{{$admin->id}}')">Kích hoạt</a>
                                                        </div>
                                                    @endif
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3"
                                                            data-kt-users-table-filter="delete_row">Xoá</a>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                                @foreach ($admins2 as $admin)
                                    <tr id="row_{{ $admin->id }}" data-id="{{ $admin->id }}">
                                        <td>
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox"
                                                    value="{{ $admin->id }}" />
                                            </div>
                                        </td>
                                        <td class="d-flex align-items-center">
                                            <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                <div class="symbol-label">
                                                    <img src="{{ url('/') . '/assets/media/avatars/' . $admin->avatar }}"
                                                        class="w-100" />
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <a href="#" id="name_{{ $admin->id }}"
                                                    class="text-gray-800 text-hover-primary mb-1">{{ $admin->name }}</a>
                                                <span id="email_{{ $admin->id }}">{{ $admin->email }}</span>
                                            </div>
                                        </td>
                                        <td id="role_{{ $admin->id }}">
                                            @if ($admin->role == 'super')
                                                Super Admin
                                            @else
                                                Admin
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-gray-800 text-hover-primary mb-1"
                                                    id="department_{{ $admin->id }}">Không có</span>
                                                <span id="position_{{ $admin->id }}">{{ $admin->position }}</span>
                                            </div>
                                        </td>
                                        <td id="status_{{ $admin->id }}">
                                            {{ $admin->status }}
                                            @if($admin->status == "verifying")
                                            <button class="d-block btn btn-sm btn-primary btn-resend" data-email="{{$admin->email}}">
                                                <span class="indicator-label">Gửi lại Email</span>
                                                <span class="indicator-progress">Đang gửi...
                                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>

                                            </button>
                                            @endif
                                        </td>
                                        <td id="time_{{ $admin->id }}">
                                            {{ $admin->created_at->format('d M Y, h:i a') }}</td>
                                        <td class="text-center">
                                            @if (Auth::user()->role == 'super')
                                                <a href="#" class="btn btn-light btn-active-light-primary btn-sm btn-icon"
                                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                    <span class="svg-icon svg-icon-5 m-0">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none">
                                                            <rect x="10" y="10" width="4" height="4" rx="2"
                                                                fill="currentColor"></rect>
                                                            <rect x="17" y="10" width="4" height="4" rx="2"
                                                                fill="currentColor"></rect>
                                                            <rect x="3" y="10" width="4" height="4" rx="2"
                                                                fill="currentColor"></rect>
                                                        </svg>
                                                    </span>
                                                </a>
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
                                                    data-kt-menu="true">
                                                    <div class="menu-item px-3">
                                                        <a onclick="showEditModal('{{ $admin->id }}')"
                                                            class="menu-link px-3 btn-edit">Chỉnh sửa</a>
                                                    </div>
                                                    @if ($admin->status == 'activated' && $admin->id != Auth::user()->id)
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3" onclick="lockAcc('{{$admin->id}}')">Khoá</a>
                                                        </div>
                                                    @endif

                                                    @if ($admin->status == 'lock' && $admin->id != Auth::user()->id)
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3" onclick="activeAcc('{{$admin->id}}')">Kích hoạt</a>
                                                        </div>
                                                    @endif
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3"
                                                            data-kt-users-table-filter="delete_row">Xoá</a>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function reloadDropdown(){
            KTMenu.init();
            KTMenu.updateDropdowns();
            KTMenu.init();
        };
    </script>
    <script src="{{ url('/') }}/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="{{ url('/') }}/assets/js/custom/system/admin/table.js"></script>
    <script src="{{ url('/') }}/assets/js/custom/system/admin/export-users.js"></script>
    <script src="{{ url('/') }}/assets/js/custom/system/admin/add.js"></script>
    <script>
        const token = $('input[name="_token"]').val();
        $(function() {
            $('#btn-create').click(function() {
                $('#btn-submit-form-create').text('Thêm mới');
                $("#add-form-type").val('new')
            });
            $(".btn-resend").on('click', function(e){
                let email = $(this).data('email');
                console.log(email);
                const button = $(this);
                funcResend(email, button);
            })
        })

        function showEditModal(id) {
            $('#id-user-edit').val(id);
            $("#add-form-type").val('edit');
            $('#btn-submit-form-create').text('Chỉnh sửa');
            $("#name").val($('#name_' + id).text());
            $('#email').val($('#email_' + id).text().trim());

            let department = $('#department_' + id).text().trim();
            if (department == "Không có") {
                $('#department').val('');
                $('#select2-department-container').text('Chọn bộ phận');
            } else {
                $('#department option[data-name="' + department + '"]').attr('selected', 'selected');
                $('#select2-department-container').text(department);
            }

            $('#position').val($('#position_' + id).text().trim());
            if ($('#role_' + id).text().trim() == 'Admin') {
                $('#kt_modal_update_role_option_1').prop('checked', true);
            } else {
                $('#kt_modal_update_role_option_0').prop('checked', true);
            }
            $('#kt_modal_add_user').modal('show');
        }
        function lockAcc(id) {
            Swal.fire({
                text: "Bạn có chắc muốn khoá "+$('#name_'+id).text().trim()+"?",
                icon: "warning",
                showCancelButton: !0,
                buttonsStyling: !1,
                confirmButtonText: "Xoá!",
                cancelButtonText: "Huỷ",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-active-light-primary",
                }
            }).then(function (t) {
                ajaxFunc('/admin/system/admins/update-status', 'put', {_token: token, id: id, status: 'lock'})
            })
        }
        function activeAcc(id) {
            Swal.fire({
                text: "Bạn có chắc muốn kích hoạt "+$('#name_'+id).text().trim()+"?",
                icon: "warning",
                showCancelButton: !0,
                buttonsStyling: !1,
                confirmButtonText: "Xoá!",
                cancelButtonText: "Huỷ",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-active-light-primary",
                }
            }).then(function (t) {
                ajaxFunc('/admin/system/admins/update-status', 'put', {_token: token, id: id, status: 'activated'})
            })
        }
        function ajaxFunc(url, type, data) {
            $.ajax({
                url: url,
                type: type,
                data: data,
                dataType: 'json',
                success: function(data){
                    var table = $('#kt_table_users').DataTable();

                    const editRow = table.row('#row_'+data.id).node()
                    table.row('#row_'+data.id).data( [colIndex(data.id), colName(data.id, data.name, data.email, data.avatar), colRole(data.role),colDepartment(data.id, $('#department_'+data.id).text(), data.position),data.status,  $('#time_'+data.id).text(), colEndStatus(data.id, data.status)] ).node()
                    // $($(editRow).find('td')[4]).html(data.status);
                    table.draw();
                    reloadDropdown();
                    Swal.fire({
                        text: "Đã xong!",
                        icon: "success",
                        buttonsStyling: !1,
                        confirmButtonText: "Chấp nhận!",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        },
                    });
                },
                error: function(data){
                    const errors = data.responseJSON;
                    console.log(errors);
                    Swal.fire({
                        text: "Có lỗi xảy ra. Thử lại sau!",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Chấp nhận!",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        },
                    });
                }
            })
        }
        function colEndStatus  (id, status) {
            let func, view;
            if(status == 'lock'){
                func = 'activeAcc';
                view = 'Kích hoạt';
            }
            if(status == 'activated'){
                func = 'lockAcc';
                view = 'Khoá';
            }
            return `<a href="#" class="btn btn-light btn-active-light-primary btn-sm btn-icon" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        <span class="svg-icon svg-icon-5 m-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect x="10" y="10" width="4" height="4" rx="2" fill="currentColor"></rect>
                                <rect x="17" y="10" width="4" height="4" rx="2" fill="currentColor"></rect>
                                <rect x="3" y="10" width="4" height="4" rx="2" fill="currentColor"></rect>
                            </svg>
                        </span>
                    </a>

                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                        <div class="menu-item px-3">
                            <a class="menu-link px-3" onclick= "showEditModal('${id}')">Chỉnh sửa</a>
                        </div>
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" onclick="${func}('${id}')">${view}</a>
                        </div>
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">Xoá</a>
                        </div>
                    </div>`;
        }
        function funcResend(email, submitButton){
            let data={
                _token: '{{csrf_token()}}',
                email: email,
                type: 'admin',
                name: 'verify-email'
            }
            console.log(data);
            // return
            $.ajax({
                url: "{{route("auth.sent-mail-reset-password")}}",
                type: 'post',
                data: data,
                dataType: 'json',
                success: function(){
                    // submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;

                    Swal.fire({
                        text: "Đã gửi!",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Chấp nhận!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    })
                },
                error: function(data){
                    console.log(data);
                    Swal.fire({
                        text: "Có lỗi xảy ra. Hãy thử lại sau.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                    submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;
                }
            })

        }
    </script>
@endpush
