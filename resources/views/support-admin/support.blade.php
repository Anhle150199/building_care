@extends('layout.app')
@push('css')
    <link href="{{ url('/') }}/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
@endpush
@section('title', 'Hỗ trợ, góp ý')
@section('content')

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        {{-- Header --}}
        <div class="toolbar" id="kt_toolbar" data-route-delete="{{ route('admin.customers.customer-delete') }}">
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                    class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Hỗ trợ, góp ý</h1>

                    <span class="h-20px border-gray-300 border-start mx-4"></span>

                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">

                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Hỗ trợ, góp ý</li>
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
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                            rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
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
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.3" x="12.75" y="4.25" width="12" height="2"
                                                rx="1" transform="rotate(90 12.75 4.25)" fill="currentColor" />
                                            <path
                                                d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z"
                                                fill="currentColor" />
                                            <path
                                                d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z"
                                                fill="#C4C4C4" />
                                        </svg>
                                    </span>Export
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table">
                            <thead>
                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-100px">Tiêu đề</th>
                                    <th class="min-w-75px">Bộ phận</th>
                                    <th class="min-w-100px">Người gửi</th>
                                    <th class="min-w-100px">Trạng thái</th>
                                    <th class="text-center min-w-70px">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-bold">
                                @foreach ($list as $item)
                                    <tr data-id={{ $item->id }} id="row_{{ $item->id }}">
                                        <td>
                                            <a href="#"
                                                class="text-gray-800 text-hover-primary mb-1">{{ $item->title }}</a>
                                        </td>
                                        <td>
                                            <span class=" fw-bold  d-block fs-7">{{ $item->department }}</span>
                                        </td>
                                        <td>
                                            <span class=" fw-bold  d-block fs-7">{{ $item->customer }}</span>
                                            <span
                                                class="text-muted fw-bold text-muted d-block fs-7">{{ $item->created_at->format('H:s d-m-Y') }}</span>
                                        </td>
                                        <td>
                                            @if ($item->status == 'request')
                                                <div class="badge badge-light-danger">Chưa xử lý</div>
                                            @elseif($item->status == 'processing')
                                                <span class=" fw-bold  d-block fs-7">{{$item->admin_name}} </span>
                                                <div class="badge badge-light-primary">Đang xử lý</div>
                                            @elseif($item->status == 'processed')
                                                <span class=" fw-bold  d-block fs-7">{{$item->admin_name}} </span>
                                                <div class="badge badge-light-success">Đã xử lý</div>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="#"
                                                class="btn btn-light btn-active-light-primary btn-sm btn-icon"
                                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                <span class="svg-icon svg-icon-5 m-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none">
                                                        <rect x="10" y="10" width="4"
                                                            height="4" rx="2" fill="currentColor"></rect>
                                                        <rect x="17" y="10" width="4"
                                                            height="4" rx="2" fill="currentColor"></rect>
                                                        <rect x="3" y="10" width="4"
                                                            height="4" rx="2" fill="currentColor"></rect>
                                                    </svg>
                                                </span>
                                            </a>
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-4"
                                                data-kt-menu="true">
                                                <div class="menu-item px-3">
                                                    <a href="#"
                                                        class="menu-link px-3">Xử lý</a>
                                                </div>
                                                <div class="menu-item px-3">
                                                    <a href="#"
                                                        class="menu-link px-3">Chi tiết</a>
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
                                <div id="kt_export_close" class="btn btn-icon btn-sm btn-active-icon-primary">
                                    <span class="svg-icon svg-icon-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="6" y="17.3137" width="16"
                                                height="2" rx="1" transform="rotate(-45 6 17.3137)"
                                                fill="currentColor" />
                                            <rect x="7.41422" y="6" width="16" height="2"
                                                rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
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
    <script src="{{ url('/') }}/assets/js/custom/support/list.js"></script>
    <style>
        #kt_table_filter {
            display: none;
        }
    </style>
@endpush
