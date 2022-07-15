@extends('page-customer.layout.app')
@section('title', 'Thông báo')
@push('css')
    <style>
    </style>
@endpush
@section('content')

<div class="page-content-wrapper py-3">
    <div class="notification-area">
      <div class="container" id="body_list_push_notification">
        @foreach ( $notification as $item )

        <a href="{{$item->click_action}}">
          <div class="alert unread custom-alert-3 alert-primary" role="alert">
            @if($item->category =="support")
            <i class="bi bi-chat-dots mt-0"></i>
            @elseif($item->category =="notify_event")
            <i class="bi bi-bell"></i>
            @elseif($item->category == "maintenance")
            <i class="bi bi-calendar2-event"></i>
            @elseif($item->category == "vehicle")
            <i class="bi bi-bicycle"></i>
            @endif
            <div class="alert-text w-75">
                <h6 class="text-truncate" style="font-size:14px;">{{$item->title}}</h6>
                <span class="text-truncate" style="font-size:14px;"><?php echo $item->body;?></span>
                <small class="text-muted">{{$item->created_at->diffForHumans()}}</small>
            </div>
          </div>
        </a>
        @endforeach
      </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 ">
                <div class="card mt-3">
                    <div class="card-body p-3">
                        <nav aria-label="Page navigation example">
                        {{ $notification->links("page-customer.layout.paginate") }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

  </div>

@endsection
