@extends('page-customer.layout.app-detail')
@push('css')
@endpush
@section('back', route('user.home'))
@section('content')

    <div class="page-content-wrapper py-3">

        <div class="container">
            @if (sizeof($list) > 0)
                @foreach ($list as $item)
                    <div class="card timeline-card bg-danger">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="timeline-text mb-2">
                                    <span class="badge mb-2 rounded-pill">Từ: {{date("H:i, d-m-Y", strtotime($item->start_at))}}</span>
                                    <span class="badge mb-2 rounded-pill bg-success">Đến: {{date("H:i, d-m-Y", strtotime($item->end_at))}}</span>
                                    <h6 class="fw-bold">{{$item->title}}</h6>
                                </div>
                            </div>
                            <p class="mb-2">{{$item->description}}</p>
                            <p><i class="bi bi-geo-alt-fill"></i><span class="fw-bold">{{" Toà nhà ".$item->name.": ".$item->location}} </span></p>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="card timeline-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="timeline-text mb-2">
                                <span>Thời gian này không có lịch bảo trì</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
