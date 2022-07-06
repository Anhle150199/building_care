<!DOCTYPE html>
<html lang="en">

<head>
    <base href="">
    <title>{{ config('app.name') }} | @yield('title')</title>
    <meta charset="utf-8" />
    <link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
    <link rel="shortcut icon" href="{{ url('/') }}/assets/media/logos/favicon.ico" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    @stack('css')
    <link href="{{ url('/') }}/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('/') }}/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />

    <!-- PWA  -->
    {{-- <meta name="theme-color" content="#6777ef"/>
    <link rel="apple-touch-icon" href="{{ asset('logo-3.png') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}"> --}}
    @laravelPWA

</head>

<body id="kt_body"
    class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed"
    style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            @include('layout.slidebar.slidebar')
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                @include('layout.slidebar.header')
                @yield('content')
                {{-- <div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
                    <div
                        class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
                        <div class="text-dark order-2 order-md-1">
                            <span class="text-muted fw-bold me-1">{{ now()->format('Y') }}©</span>
                            <a href="https://keenthemes.com" target="_blank"
                                class="text-gray-800 text-hover-primary">{{ config('app.name') }} </a>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    </div>
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <span class="svg-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)"
                    fill="currentColor" />
                <path
                    d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
                    fill="currentColor" />
            </svg>
        </span>
    </div>
    <script>
        var hostUrl = "assets/";
    </script>
    <script src="{{ url('/') }}/assets/plugins/global/plugins.bundle.js"></script>
    <script src="{{ url('/') }}/assets/js/scripts.bundle.js"></script>

    @stack('js')
    <script>
        $(function() {
            @isset($menu)
                @foreach ($menu as $item)
                    $("#{{ $item }}").addClass(" show active");
                @endforeach
            @endisset

            $('select[name=building_active]').on('change',function () {
                let url = $('select[name=building_active]').data('submit');
                let id = $('select[name=building_active]').val();
                let token = $('input[name=_token]').val();
                console.log(token);
                $.ajax({
                    url: url,
                    type: 'post',
                    data:{
                        _token: token,
                        id: id
                    },
                    dataType: 'json',
                    success: function(){
                        location.reload();
                    }
                })
            })
        })
    </script>
    {{-- <script src="{{ asset('/sw.js') }}"></script>
    <script>
        if (!navigator.serviceWorker.controller) {
            navigator.serviceWorker.register("/sw.js").then(function (reg) {
                console.log("Service worker has been registered for scope: " + reg.scope);
            });
        }
    </script> --}}
    <style>
        .dt-buttons, #kt_table_users_filter{
            display: none;
        }
        .string-2 {
            overflow: hidden;
            line-height: 24px;
            -webkit-line-clamp: 2;
            /* height: 45px; */
            display: -webkit-box;
            /* width: 136px; */
            -webkit-box-orient: vertical;
        }
    </style>
</body>

</html>
