@extends('layout.app')
@push('css')
    <link href="{{ url('/') }}/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <style>
        #kt_table_departments_filter    {
            display: none;
        }
    </style>
@endpush
@section('title', 'Danh sách thiết bị')
@section('content')

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        {{-- Start page: path page --}}
        <div class="toolbar" id="kt_toolbar">
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack"
            data-route-delete="{{ route('admin.system.equipment.delete') }}"
            data-route-edit = "{{ route('admin.system.equipment.edit') }}"
            data-route-new = "{{ route('admin.system.equipment.new') }}">
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                    class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Danh sách thiết bị</h1>
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
                        <li class="breadcrumb-item text-muted">Danh sách thiết bị</li>
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
                                <input type="text" data-kt-table-filter="search"
                                    class="form-control form-control-solid w-250px ps-14" placeholder="Tìm kiếm" />
                            </div>
                        </div>
                        {{-- Option nâng cao --}}
                        <div class="card-toolbar">
                            <div class="d-flex justify-content-end" data-kt-departments-table-toolbar="base">

                                {{-- Export --}}
                                @include('layout.datatable.btn-export')
                                {{-- Thêm mới --}}
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" id="btn-add-new"
                                    data-bs-target="#kt_modal_add_user">
                                    <span class="svg-icon svg-icon-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                                transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                                        </svg>
                                    </span>
                                    Thêm mới
                                </button>
                            </div>
                            <div></div>
                            {{-- Xoá khi chọn --}}
                            <div class="d-flex justify-content-end align-items-center d-none"
                                data-kt-departments-table-toolbar="selected">
                                <div class="fw-bolder me-5">
                                    Đã chọn
                                    <span class="me-2" data-kt-departments-table-select="selected_count"></span>
                                </div>
                                <button type="button" class="btn btn-danger"
                                    data-kt-departments-table-select="delete_selected">Xoá</button>
                            </div>
                            {{-- Modal Export --}}
                            <div class="modal fade" id="kt_modal_export_users" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered mw-650px">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="fw-bolder">Export danh sách</h2>
                                            <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                                data-kt-departments-modal-action="close">
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
                                                        data-kt-departments-modal-action="cancel">Huỷ</button>
                                                    <button type="submit" class="btn btn-primary"
                                                        data-kt-departments-modal-action="submit">
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
                            {{-- Modal thêm thiết bị --}}
                            <div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered mw-650px">
                                    <div class="modal-content">
                                        {{-- Tiêu đề modal --}}
                                        <div class="modal-header" id="kt_modal_add_user_header">
                                            <h2 class="fw-bolder">Thêm mới</h2>
                                            <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                                data-kt-departments-modal-action="close">
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
                                            {{-- Form thêm moi --}}
                                            <form id="kt_modal_add_department_form" class="form">
                                                @csrf
                                                <div class="d-flex flex-column scroll-y me-n7 pe-7"
                                                    id="kt_modal_add_user_scroll" data-kt-scroll="true"
                                                    data-kt-scroll-activate="{default: false, lg: true}"
                                                    data-kt-scroll-max-height="auto"
                                                    data-kt-scroll-dependencies="#kt_modal_add_user_header"
                                                    data-kt-scroll-wrappers="#kt_modal_add_user_scroll"
                                                    data-kt-scroll-offset="300px">
                                                    <div class="fv-row mb-7">
                                                        <input type="hidden" id="add_department_form_type">
                                                        <input type="hidden" id="add_department_form_id">
                                                        <label class="required fw-bold fs-6 mb-2">Tên thiết bị: </label>
                                                        <input type="text" name="department_name" id="department_name"
                                                            class="form-control form-control-solid mb-3 mb-lg-0"
                                                            placeholder="Nhập tên thiết bị" />
                                                    </div>
                                                </div>
                                                <div class="text-center pt-15">
                                                    <button type="reset" class="btn btn-light me-3"
                                                        data-kt-departments-modal-action="cancel">Huỷ</button>
                                                    <button type="submit" class="btn btn-primary"
                                                        data-kt-departments-modal-action="submit">
                                                        <span class="indicator-label" id="btn-add-modal">Tạo mới</span>
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
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_departments">
                            <thead>
                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="w-10px pe-2">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                            <input class="form-check-input" type="checkbox" data-kt-check="true"
                                                data-kt-check-target="#kt_table_departments .form-check-input" value="1" />
                                        </div>
                                    </th>
                                    {{-- <th></th> --}}
                                    <th class="min-w-125px">Tên thiết bị </th>
                                    {{-- <th></th> --}}
                                    <th class="min-w-125px">Ngày tạo</th>
                                    <th class="text-center min-w-100px">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-bold">
                                @foreach ($equipments as $item)
                                    <tr id="row_{{$item->id}}" data-id="{{$item->id}}">
                                        <td>
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value="{{$item->id}}" />
                                            </div>
                                        </td>
                                        <td>{{ $item->name }} </td>
                                        <td>{{ $item->created_at->format('d M Y, h:i a') }}</td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-light btn-active-light-primary btn-sm btn-icon"
                                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                <span class="svg-icon svg-icon-5 m-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none">
                                                        <rect x="10" y="10" width="4" height="4" rx="2" fill="currentColor">
                                                        </rect>
                                                        <rect x="17" y="10" width="4" height="4" rx="2" fill="currentColor">
                                                        </rect>
                                                        <rect x="3" y="10" width="4" height="4" rx="2" fill="currentColor">
                                                        </rect>
                                                    </svg>
                                                </span>
                                            </a>
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
                                                data-kt-menu="true">
                                                <div class="menu-item px-3">
                                                    <a href="#"
                                                        onclick="showEditModal('{{ $item->id }}', '{{ $item->name }}')"
                                                        class="menu-link px-3">Chỉnh sửa</a>
                                                </div>
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3"
                                                        data-kt-table-filter="delete_row">Xoá</a>
                                                </div>
                                            </div>
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
    <script src="{{ url('/') }}/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="{{ url('/') }}/assets/js/custom/system/equipment/table.js"></script>

    <script src="{{ url('/') }}/assets/js/custom/system/equipment/export.js"></script>
    <script src="{{ url('/') }}/assets/js/custom/system/equipment/add.js"></script>
    <script>
        $(function() {
            $('#btn-add-new').click(function() {
                $('#btn-add-modal').text('Thêm mới');
                $('#add_department_form_type').val('new');
            });

        })

        function showEditModal(id, name) {
            $('#kt_modal_add_user').modal('show');
            $('#add_department_form_type').val('edit');
            $('#add_department_form_id').val(id);
            $('#department_name').val(name);
            $('#btn-add-modal').text('Cập nhật');
        }
    </script>
@endpush
