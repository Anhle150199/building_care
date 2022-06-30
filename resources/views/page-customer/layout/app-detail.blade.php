<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Affan - PWA Mobile HTML Template">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#0134d4">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>@yield('title')</title>
    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">
    {{-- Favicon --}}
    <link rel="icon" href="{{ url('/') }}/assets/media/logos/favicon.ico">
    <link rel="apple-touch-icon" href="{{ url('/') }}/customer/img/icons/icon-96x96.png">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ url('/') }}/customer/img/icons/icon-152x152.png">
    <link rel="apple-touch-icon" sizes="167x167" href="{{ url('/') }}/customer/img/icons/icon-167x167.png">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('/') }}/customer/img/icons/icon-180x180.png">
    {{-- CSS Libraries --}}
    <link rel="stylesheet" href="{{ url('/') }}/customer/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/customer/css/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ url('/') }}/customer/css/tiny-slider.css">
    <link rel="stylesheet" href="{{ url('/') }}/customer/css/baguetteBox.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/customer/css/rangeslider.css">
    <link rel="stylesheet" href="{{ url('/') }}/customer/css/vanilla-dataTables.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/customer/css/apexcharts.css">
    {{-- Core Stylesheet --}}
    <link rel="stylesheet" href="{{ url('/') }}/customer/style.css">

    @stack('css')
    <style>
        .indicator-progress {
            display: none;
        }
        .active a i, .footer-nav ul li.active a span{
            color:red;
        }
        .footer-nav ul li a span, .footer-nav ul li a i{
            color:#8480ae !important;
        }
        .swal2-popup { font-size: 11px !important; }

    </style>
    <!-- Web App Manifest -->
    {{-- <link rel="manifest" href="{{url('/')}}/customer/manifest.json"> --}}
    @laravelPWA

</head>

<body>
    <div id="preloader">
        <div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
    </div>
    {{-- Internet Connection Status --}}
    <div class="internet-connection-status" id="internetStatus"></div>
    @include("page-customer.layout.haeder-detail")
    @yield('content')

    {{-- @include('page-customer.layout.navbar') --}}
    {{-- All JavaScript Files --}}
    <script src="{{ url('/') }}/js/jquery-3.6.0.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ url('/') }}/customer/js/bootstrap.bundle.min.js"></script>
    <script src="{{ url('/') }}/customer/js/slideToggle.min.js"></script>
    <script src="{{ url('/') }}/customer/js/internet-status.js"></script>
    <script src="{{ url('/') }}/customer/js/tiny-slider.js"></script>
    <script src="{{ url('/') }}/customer/js/baguetteBox.min.js"></script>
    {{-- <script src="{{url('/')}}/customer/js/countdown.js"></script> --}}
    <script src="{{ url('/') }}/customer/js/rangeslider.min.js"></script>
    <script src="{{ url('/') }}/customer/js/vanilla-dataTables.min.js"></script>
    <script src="{{ url('/') }}/customer/js/index.js"></script>
    <script src="{{ url('/') }}/customer/js/magic-grid.min.js"></script>
    <script src="{{ url('/') }}/customer/js/dark-rtl.js"></script>
    <script src="{{ url('/') }}/customer/js/active.js"></script>
    @stack('js')
    {{-- PWA --}}
    {{-- <script src="{{url('/')}}/customer/js/pwa.js"></script> --}}
    <script>
        function toggleBtnSubmit() {
            $('.indicator-label').toggle()
            $('.indicator-progress').toggle()
            $('#btn_submit').prop('disabled', function(i, v) {
                return !v;
            });
        }
    </script>
</body>

</html>
