@extends('layout.app')
@push('css')
    <link href="{{ url('/') }}/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <style>
        .footer-reply {
            position: fixed;
            width: 100%;
            background-color: #ffffff;
            bottom: 0;
            z-index: 1000;
        }
    </style>
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
                    <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Chi tiết</h1>

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

        {{-- body --}}
        <div class="card h-100" id="kt_drawer_chat_messenger">
            <div class="card-header d-flex align-items-center py-2 gap-5" id="kt_drawer_chat_messenger_header">

                <div class="d-flex flex-wrap gap-2 w-100 justify-content-between align-items-center">
                    <div class="d-flex align-items-center flex-wrap gap-2" style="max-width: 80%">
                        <h2 class="fw-bold me-3 my-1">{{ $feedback->title }}</h2>
                    </div>
                    <div class="d-flex">
                        @if ($feedback->status == 'processing')

                            @isset($admin)
                                @if ($admin->id == Auth::user()->id)
                                    <form action="{{ route('admin.support.close') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="feedback" value="{{ $feedback->id }}">
                                        <button type="submit" class="btn btn-success btn-active-light-primary me-2"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Đóng hỗ trợ">
                                            <i class="bi bi-bookmark-check fs-2"></i>
                                            Đóng
                                        </button>
                                    </form>
                                @endif
                            @endisset()
                        @elseif($feedback->status == 'request')
                            <form action="{{ route('admin.support.accept-request') }}" method="post">
                                @csrf
                                <input type="hidden" name="feedback" value="{{ $feedback->id }}">
                                <button type="submit" class="btn btn-primary btn-active-light-primary me-2"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Xử lý hỗ trợ này">
                                    <i class="bi bi-bookmark-plus fs-2"></i>
                                    Xử lý
                                </button>
                            </form>
                        @else
                            <button type="button" class="btn btn-light btn-active-light-primary me-2"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="hỗ trợ đã được xử lý">
                                <i class="bi bi-bookmark-check fs-2"></i>
                                Đã đóng
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body h-2px" id="kt_mess_body" style="overflow: auto">
                <div data-kt-inbox-message="message_wrapper">
                    <div class="d-flex flex-wrap gap-2 flex-stack cursor-pointer" data-kt-inbox-message="header">
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-50 me-4">
                                <span class="symbol-label"
                                    style="background-image:url({{ url('/') }}/images/avatar-user/{{ str_replace(' ', '%20', $user->avatar) }});"></span>
                            </div>
                            <div class="pe-5">
                                <div class="d-flex align-items-center flex-wrap gap-1">
                                    <a href="#"
                                        class="fw-bolder text-dark text-hover-primary">{{ $user->name }}</a>
                                </div>
                                <div data-kt-inbox-message="details">
                                    <span class="text-muted fw-bold">đến Phòng {{ $department->name }}</span>
                                    <a href="#" class="me-1" data-kt-menu-trigger="click"
                                        data-kt-menu-placement="bottom-start">
                                        <span class="svg-icon svg-icon-5 m-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <path
                                                    d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                    fill="currentColor" />
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                                <div class="text-muted fw-bold mw-450px string-2 d-none" data-kt-inbox-message="preview">
                                    <?php echo $feedback->content; ?></div>
                            </div>
                        </div>
                        <div class="d-flex align-items-ce
                        nter flex-wrap gap-2">
                            <span
                                class="fw-bold text-muted text-end me-3">{{ $feedback->created_at->format('H:s d-m-Y') }}</span>
                        </div>
                    </div>
                    <div class="collapse fade show" data-kt-inbox-message="message">
                        <div class="py-5">
                            <?php echo $feedback->content; ?>
                        </div>
                        <div class="d-flex flex-wrap align-items-center">
                            <?php $images = json_decode($feedback->image); ?>
                            {{-- @if (sizeof($images)) --}}
                                @foreach ($images as $img)
                                    <a href="{{ url('/images/feedback/') . '/' . $img }}" class="p-2 m-1 border rounded"
                                        target="_blank" rel="noopener noreferrer"> {{ $img }}</a>
                                @endforeach
                            {{-- @endif --}}
                        </div>
                    </div>
                </div>
                <div class="separator my-6"></div>
                @foreach ($reply as $item)

                <div data-kt-inbox-message="message_wrapper">
                    <div class="d-flex flex-wrap gap-2 flex-stack cursor-pointer" data-kt-inbox-message="header">
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-50 me-4">
                                @if($item->user_type == 1)
                                <span class="symbol-label" style="background-image:url({{ url('/') }}/images/avatar-user/{{ str_replace(' ', '%20', $user->avatar) }});"></span>
                                @else
                                <span class="symbol-label" style="background-image:url({{ url('/') }}/assets/media/avatars/{{ str_replace(' ', '%20', $admin->avatar) }});"></span>
                                @endif
                            </div>
                            <div class="pe-5">
                                <div class="d-flex align-items-center flex-wrap gap-1">
                                    @if($item->user_type == 1)
                                    <a href="#" class="fw-bolder text-dark text-hover-primary">{{ $user->name }}</a>
                                    @else
                                    <a href="#" class="fw-bolder text-dark text-hover-primary">{{ $admin->name }}</a>
                                    @endif
                                </div>

                                <div data-kt-inbox-message="details">
                                    @if($item->user_type == 1)
                                    <span class="text-muted fw-bold">đến Phòng {{ $department->name }}</span>
                                        <a href="#" class="me-1" data-kt-menu-trigger="click"
                                            data-kt-menu-placement="bottom-start">
                                            <span class="svg-icon svg-icon-5 m-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path
                                                        d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </span>
                                        </a>
                                    @endif
                                </div>
                                <div class="text-muted fw-bold mw-450px string-2 d-none" data-kt-inbox-message="preview">
                                    <?php echo $item->content; ?></div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <span class="fw-bold text-muted text-end me-3">{{ $item->created_at->format('H:s d-m-Y') }}</span>
                        </div>
                    </div>
                    <div class="collapse fade show" data-kt-inbox-message="message">
                        <div class="py-5">
                            <?php echo $item->content; ?>
                        </div>
                        <div class="d-flex flex-wrap align-items-center">
                            <?php $images = json_decode($item->image); ?>
                                @foreach ($images as $img)
                                    <a href="{{ url('/images/feedback/') . '/' . $img }}" class="p-2 m-1 border rounded"
                                        target="_blank" rel="noopener noreferrer"> {{ $img }}</a>
                                @endforeach
                        </div>
                    </div>
                </div>
                <div class="separator my-6"></div>
                @endforeach
            </div>
            @isset($admin)
                @if ($admin->id == Auth::user()->id && $feedback->status == 'processing')
                    <div class="card-footer p-1" id="kt_drawer_chat_messenger_footer">
                        <div id="show-upload" class="w-100 p-2 mx-2 d-flex flex-wrap">
                        </div>
                        <form id="kt_inbox_reply_form" class="w-100" data-action="{{ route('admin.support.reply') }}" >
                            <div class=" d-flex justify-content-center align-items-center">
                                <span class="btn btn-icon btn-sm btn-clean btn-active-light-primary mx-5"
                                    id="btn-image" data-kt-inbox-form="dropzone_upload">
                                    <span class="svg-icon svg-icon-2 m-0">
                                        <i class="bi bi-images" style="font-size: 25px"></i>
                                    </span>
                                </span>
                                <div class="w-75">
                                    <input type="hidden" name="feecback_id" id="feecback_id" value="{{$feedback->id}}">
                                    <input type="file" multiple id="input-image" hidden accept="image/*">
                                    <textarea class="form-control" id="content"></textarea>
                                </div>
                                <div class="btn-group mx-4">
                                    <button id="btn_submit" class="btn btn-primary fs-bold px-6" data-kt-inbox-form="send">
                                        <span class="indicator-label">Gửi</span>
                                        <span class="indicator-progress">Đang gửi...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            @endisset()
        </div>
    </div>

@endsection
@push('js')
    <script src="{{ url('/') }}/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="{{ url('/') }}/assets/js/custom/support/reply.js"></script>
    <style>
        #kt_table_filter {
            display: none;
        }
    </style>
@endpush
