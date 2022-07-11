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
            @if($item->category =="feedback")
            <i class="bi bi-chat-dots mt-0"></i>
            @elseif($item->category =="notify_event")
            <i class="bi bi-bell"></i>
            @elseif($item->category == "maintenance")
            <i class="bi bi-calendar2-event"></i>
            @elseif($item->category == "vehicle")
            <i class="bi bi-bicycle"></i>
            @endif
            <div class="alert-text w-75">
              <h6 class="text-truncate">{{$item->title}}</h6><span class="text-truncate">{{$item->body}}</span>
            </div>
          </div>
        </a>
        @endforeach
      </div>
    </div>
  </div>

@endsection
