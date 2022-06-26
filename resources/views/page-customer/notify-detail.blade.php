@extends('page-customer.layout.app')
@section('title', 'Trang chủ')
@section('content')

    <div class="page-content-wrapper">
        <div class="container">
            <div class="pt-3 d-block"></div>
            <div class="blog-details-post-thumbnail position-relative">
                <img class="w-100 rounded-lg" src="{{ url('/') }}/images/{{ $item->image }}"
                    alt="">
            </div>
        </div>
        <div class="blog-description py-3">
            <div class="container">
                @if ($item->category == 'notify')
                <span class="badge bg-primary mb-2 d-inline-block">Thông báo</span>
            @else
                <span class="badge bg-primary mb-2 d-inline-block">Tin tức</span>
            @endif

                <h3 class="mb-3">{{$item->title}}</h3>
                <div class="d-flex align-items-center mb-4">
                    <a class="badge-avater" href="#">
                        <img class="img-circle" src="{{url('/')}}/assets/media/avatars/{{$admin->avatar}}" alt="">
                    </a>
                    <span class="ms-2">{{$admin->name}}</span>
                </div>
                <?php echo $item->content?>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $('p span').removeAttr("style");
        $('p').addClass("fz-14");
    </script>
@endpush
