@extends('layout.app')
@push('css')
    <link href="{{ url('/') }}/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
@endpush
@section('title', 'Soạn Email')
@section('content')

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="toolbar" id="kt_toolbar">
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                    class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Các thư đã gửi</h1>
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Thông báo tin tức</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-dark">Quản lý email</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">
                <div class="d-flex flex-column flex-lg-row">

                    @include('layout.slidebar.slidebarMail')

                    {{-- Start email --}}

                    <div class="flex-lg-row-fluid ms-lg-7 ms-xl-10">

                        <div class="card">
                            <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                                <div class="d-flex flex-wrap gap-1">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                        <input class="form-check-input" type="checkbox" data-kt-check="true"
                                            data-kt-check-target="#kt_inbox_listing .form-check-input" value="1" />
                                    </div>
                                </div>
                                <div class="d-flex align-items-center flex-wrap gap-2">
                                    <div class="d-flex align-items-center position-relative">
                                        <span class="svg-icon svg-icon-2 position-absolute ms-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546"
                                                    height="2" rx="1" transform="rotate(45 17.0365 15.1223)"
                                                    fill="currentColor" />
                                                <path
                                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                                    fill="currentColor" />
                                            </svg>
                                        </span>
                                        <input type="text" data-kt-inbox-listing-filter="search"
                                            class="form-control form-control-sm form-control-solid mw-100 min-w-150px min-w-md-200px ps-12"
                                            placeholder="Search Inbox" />
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-hover table-row-dashed fs-6 gy-5 my-0" id="kt_inbox_listing">
                                    <thead class="d-none">
                                        <tr>
                                            <th>Checkbox</th>
                                            <th>Actions</th>
                                            <th>Author</th>
                                            <th>Title</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($list as $item)
                                            <tr>
                                                <td class="ps-9">
                                                    <div
                                                        class="form-check form-check-sm form-check-custom form-check-solid mt-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="{{ $item->id }}" />
                                                    </div>
                                                </td>
                                                <td class="w-75px">
                                                    <span class="fw-bold">{{ $item->admin }}</span>
                                                </td>
                                                <td class="w-110px">
                                                    <span class="string-2 fw-bold">
                                                    @foreach ($item->to as $to)
                                                        {{ $to->name.". " }}
                                                    @endforeach
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="text-dark mb-1">
                                                        <a href="{{ route('admin.notification.email.show-detail', ['id'=>$item->id]) }}" class="text-dark">
                                                            <span class="fw-bolder">{{ $item->subject }}</span>
                                                        </a>
                                                    </div>
                                                </td>
                                                <td class="w-100px text-end fs-7 pe-9">
                                                    <span
                                                        class="fw-bold">{{ $item->created_at->format('H:i d/m/Y') }}</span>
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
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ url('/') }}/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="{{ url('/') }}/assets/plugins/custom/formrepeater/formrepeater.bundle.js"></script>

    <script src="{{ url('/') }}/assets/js/custom/notify/email/listing.js"></script>
@endpush
