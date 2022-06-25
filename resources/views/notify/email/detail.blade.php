@extends('layout.app')
@push('css')
    <link href="{{ url('/') }}/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
@endpush
@section('title', 'Chi tiết Email')
@section('content')

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="toolbar" id="kt_toolbar">
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                    class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Chi tiết Email</h1>
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
                            <div class="card-header align-items-center py-5 gap-5">
                                <div class="d-flex">
                                    <a href="{{ route('admin.notification.email.show-list') }}" class="btn btn-sm btn-icon btn-clear btn-active-light-primary me-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Trở lại">
                                        <span class="svg-icon svg-icon-1 m-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="6" y="11" width="13" height="2" rx="1" fill="currentColor" />
                                                <path d="M8.56569 11.4343L12.75 7.25C13.1642 6.83579 13.1642 6.16421 12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75L5.70711 11.2929C5.31658 11.6834 5.31658 12.3166 5.70711 12.7071L11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25C13.1642 17.8358 13.1642 17.1642 12.75 16.75L8.56569 12.5657C8.25327 12.2533 8.25327 11.7467 8.56569 11.4343Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                    </a>
                                    {{-- <a href="#" class="btn btn-sm btn-icon btn-light btn-active-light-primary me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                        <span class="svg-icon svg-icon-2 m-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" />
                                                <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" />
                                                <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                    </a> --}}
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap gap-2 justify-content-between mb-8">
                                    <div class="d-flex align-items-center flex-wrap gap-2">
                                        <h2 class="fw-bold me-3 my-1">{{$item->subject}}</h2>
                                    </div>
                                </div>
                                <div data-kt-inbox-message="message_wrapper">
                                    <div class="d-flex flex-wrap gap-2 flex-stack cursor-pointer" data-kt-inbox-message="header">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-50 me-4">
                                                <span class="symbol-label" style="background-image:url({{url('')."/assets/media/avatars/".@$admin->avatar}});"></span>
                                            </div>
                                            <div class="pe-5">
                                                <div class="d-flex align-items-center flex-wrap gap-1">
                                                    <a href="#" class="fw-bolder text-dark text-hover-primary">{{$admin->name}}</a>
                                                </div>
                                                <div data-kt-inbox-message="details">
                                                    <span class="text-muted fw-bold">to
                                                        <?php
                                                            for ($i=0; $i < sizeof($item->to) ; $i++)  {
                                                                if($i >0)echo ", ";
                                                                echo $item->to[$i]->name;
                                                            }
                                                        ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center flex-wrap gap-2">
                                            <span class="fw-bold text-muted text-end me-3">{{ $item->created_at->format('H:i, l, d M Y') }}</span>
                                            <div class="d-flex">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="collapse fade show" data-kt-inbox-message="message">
                                        <div class="py-5">
                                            <?php echo $item->content?>
                                        </div>
                                    </div>
                                </div>
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

    <script src="{{ url('/') }}/assets/js/custom/notify/email/reply.js"></script>
@endpush
