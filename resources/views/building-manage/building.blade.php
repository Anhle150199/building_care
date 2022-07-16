@extends('layout.app')
@push('css')
    <link href="{{ url('/') }}/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet"
        type="text/css" />
@endpush
@section('title', 'Danh sách toà nhà')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        {{-- Header --}}
        <div class="toolbar" id="kt_toolbar" data-route-delete="{{route('admin.building.delete')}}">
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                    class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Danh sách toà nhà</h1>

                    <span class="h-20px border-gray-300 border-start mx-4"></span>

                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">

                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}"
                                class="text-muted text-hover-primary">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Quản lý toà nhà</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-dark">Danh sách toà nhà</li>
                    </ul>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                </div>
            </div>
        </div>
        {{-- Body List --}}
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">
                <div class="card">
                    <div class="card-header border-0 pt-6">
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
                        <div class="card-toolbar">
                            <div class="d-flex justify-content-end" data-kt-table-toolbar="base">

                                {{-- Export --}}
                                <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal"
                                    data-bs-target="#kt_export_modal">
                                    <span class="svg-icon svg-icon-2">
                                        <i class="bi bi-download"></i>
                                    </span>Export
                                </button>

                                {{-- Thêm mới --}}
                                <a href="{{ route('admin.building.new') }}" class="btn btn-primary">
                                    <span class="svg-icon svg-icon-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                                transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                                        </svg>
                                    </span>
                                    Thêm mới
                                </a>
                            </div>
                            <div class="d-flex justify-content-end align-items-center d-none"
                                data-kt-table-toolbar="selected">
                                <div class="fw-bolder me-5">Đã chọn
                                    <span class="me-2" data-kt-table-select="selected_count"></span>
                                </div>
                                <button type="button" class="btn btn-danger"
                                    data-kt-table-select="delete_selected">Xoá</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table">
                            <thead>
                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="w-10px pe-2">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                            <input class="form-check-input" type="checkbox" data-kt-check="true"
                                                data-kt-check-target="#kt_table .form-check-input"
                                                value="1" />
                                        </div>
                                    </th>
                                    <th class="min-w-125px">Tên toà nhà</th>
                                    <th class="min-w-125px">Trạng thái</th>
                                    <th class="min-w-125px">Địa chỉ</th>
                                    <th class="min-w-125px">Căn hộ</th>
                                    <th class="min-w-125px">Ngày tạo</th>
                                    <th class="text-center min-w-70px">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-bold">
                                @foreach ($building as $item )
                                <tr data-id={{$item->id}} id="row_{{$item->id}}">
                                    <td>
                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="{{$item->id}}" />
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.building.show-update', ['id'=>$item->id]) }}"
                                            class="text-gray-800 text-hover-primary mb-1">{{$item->name}}</a>
                                    </td>
                                    <td>
                                        @if ($item->status == 'active')
                                        <div class="badge badge-light-success">Kích hoạt</div>
                                        @elseif ($item->status == 'lock')
                                        <div class="badge badge-light-danger">Khoá</div>
                                        @elseif ($item->status == 'prepare')
                                        <div class="badge badge-light-warning">Chuẩn bị</div>
                                        @endif
                                    </td>
                                    <td>
                                        {{$item->address}}
                                    </td>
                                    <td>{{$item->apartment_active}}/{{$item->apartment_number}}</td>
                                    <td>{{ $item->created_at->format('d M Y, h:i a') }}</td>
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
                                                <a href="{{ route('admin.building.show-update', ['id'=>$item->id]) }}"
                                                    class="menu-link px-3">Chỉnh sửa</a>
                                            </div>
                                            <div class="menu-item px-3">
                                                <a href="#" data-kt-table-filter="delete_row"
                                                    class="menu-link px-3">Xoá</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Modal Export --}}
                <div class="modal fade" id="kt_export_modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered mw-650px">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h2 class="fw-bolder">Export Subscriptions</h2>
                                <div id="kt_export_close"
                                    class="btn btn-icon btn-sm btn-active-icon-primary">
                                    <span class="svg-icon svg-icon-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none">
                                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                                transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                            <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                                transform="rotate(45 7.41422 6)" fill="currentColor" />
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                <form id="kt_export_form" class="form" action="#">
                                    <div class="fv-row mb-10">
                                        <label class="fs-5 fw-bold form-label mb-5">Chọn định dạng:</label>
                                        <select data-control="select2" data-placeholder="Chọn định dạng"
                                            data-hide-search="true" name="format" class="form-select form-select-solid">
                                            <option value="excel">Excel</option>
                                            <option value="pdf">PDF</option>
                                            <option value="csv">CSV</option>
                                        </select>
                                    </div>
                                    <div class="text-center">
                                        <button type="reset" id="kt_export_cancel"
                                            class="btn btn-light me-3">Huỷ</button>
                                        <button type="submit" id="kt_export_submit" class="btn btn-primary">
                                            <span class="indicator-label">Xuất</span>
                                            <span class="indicator-progress">Đang xuất...
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
    </div>
@endsection
@push('js')
    <script src="{{ url('/') }}/assets/plugins/custom/datatables/datatables.bundle.js"></script>

    <script src="{{ url('/') }}/assets/js/custom/building/list/export.js"></script>
    <script src="{{ url('/') }}/assets/js/custom/building/list/list.js"></script>
    <style>
        #kt_table_filter{
            display:none;
        }
    </style>
@endpush
