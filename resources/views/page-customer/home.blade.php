@extends('page-customer.layout.app')
@section('title', 'Trang chủ')
@section('content')

    <div class="page-content-wrapper">
        {{-- Alert chào mừng, nhắc nhở cài app --}}
        <div class="toast toast-autohide custom-toast-1 toast-success home-page-toast" role="alert" aria-live="assertive"
            aria-atomic="true" data-bs-delay="7000" data-bs-autohide="true">
            <div class="toast-body">
                <svg class="bi bi-bookmark-check text-white" width="30" height="30" viewBox="0 0 16 16"
                    fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z">
                    </path>
                    <path fill-rule="evenodd"
                        d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z">
                    </path>
                </svg>
                <div class="toast-text ms-3 me-2">
                    <p class="mb-1 text-white">Welcome to Affan!</p><small class="d-block">Click the "Add to Home Screen"
                        button &amp; enjoy it like an app.</small>
                </div>
            </div>
            <button class="btn btn-close btn-close-white position-absolute p-1" type="button" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
        {{-- Slide dầu trang --}}
        {{-- <div class="tiny-slider-one-wrapper">
            <div class="tiny-slider-one">
                <!-- Single Hero Slide -->
                <div>
                    <div class="single-hero-slide bg-overlay" style="background-image: url('img/bg-img/31.jpg')">
                        <div class="h-100 d-flex align-items-center text-center">
                            <div class="container">
                                <h3 class="text-white mb-1">Build with Bootstrap 5</h3>
                                <p class="text-white mb-4">Build fast, responsive sites with Bootstrap.</p><a
                                    class="btn btn-creative btn-warning" href="#">Buy Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="pt-3"></div>
        <div class="container direction-rtl">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-4">
                            <div class="feature-card mx-auto text-center">
                                <div class="card mx-auto bg-gray">
                                    {{-- <img src="img/demo-img/pwa.png" alt=""> --}}
                                    <i class="bi bi-calendar2-event-fill text-danger "></i>
                                </div>
                                <p class="mb-0">Lịch bảo trì</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="feature-card mx-auto text-center">
                                <div class="card mx-auto bg-gray">
                                    {{-- <img src="img/demo-img/bootstrap.png" alt=""> --}}
                                    <i class="bi bi-bicycle text-danger"></i>
                                </div>
                                <p class="mb-0">Phương tiện</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="feature-card mx-auto text-center">
                                <div class="card mx-auto bg-gray">
                                    {{-- <img src="img/demo-img/js.png" alt=""> --}}
                                    <i class="bi bi-chat-right-dots text-danger"></i>

                                </div>
                                <p class="mb-0">Hỗ trợ</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pb-3"></div>
        <div class="container">
            <h2>Thông báo, tin tức</h2>
            <div class="row g-3 justify-content-center">
                @foreach ($list as $item)
                <div class="col-12 col-md-8 col-lg-7 col-xl-6">
                    <div class="card shadow-sm blog-list-card">
                        <div class="">
                            <img class="card-img-top" src="{{ url('/') }}/images/{{$item->image}}" alt="Card image cap">

                            <div class="p-3">
                                <div class="d-flex justify-content-between ">
                                    @if ($item->category == 'notify')
                                        <span class="badge bg-primary rounded-pill mb-2 d-inline-block">Thông báo</span>
                                    @else
                                        <span class="badge bg-primary rounded-pill mb-2 d-inline-block">Tin tức</span>
                                    @endif
                                    <span class="badge bg-danger rounded-pill mb-2 d-inline-block">{{date("H:i, d M Y", strtotime($item->created_at))}}</span>
                                </div>
                                <a class="blog-title d-block text-dark mb-2" href="{{ route('user.notify-detail', ['title'=>$item->title, 'id'=>$item->id]) }}">{{$item->title}}</a>
                                <a class="btn btn-primary btn-sm" href="{{ route('user.notify-detail', ['title'=>$item->title, 'id'=>$item->id]) }}">Đọc thêm</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-7 col-xl-6">
                    <div class="card mt-3">
                        <div class="card-body p-3">
                            <nav aria-label="Page navigation example">
                            {{ $list->links("page-customer.layout.paginate") }}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
