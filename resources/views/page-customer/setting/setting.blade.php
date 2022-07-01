@extends('page-customer.layout.app')
@section('title', 'Cài đặt')
@section('content')

    <div class="page-content-wrapper py-3">
        <div class="container">
            <div class="card user-info-card mb-3">
                <div class="card-body d-flex align-items-center">
                    <div class="user-profile me-3"><img src="img/bg-img/2.jpg" alt=""><i class="bi bi-pencil"></i>
                        <form action="#">
                            <input class="form-control" type="file">
                        </form>
                    </div>
                    <div class="user-info">
                        <div class="d-flex align-items-center">
                            <span class="mb-1 fw-bold">{{Auth::user()->name}}</span>
                        </div>
                        <span class="mb-0" style="font-size: 13px;">{{Auth::user()->email}}</span>
                    </div>
                </div>
            </div>
            <!-- Setting Card-->
            <div class="card mb-3 shadow-sm">
                <div class="card-body direction-rtl">
                    <p>Tài khoản</p>
                    <div class="single-setting-panel"><a href="{{ route('user.setting.show-profile') }}">
                            <div class="icon-wrapper"><i class="bi bi-person"></i></div>Cập nhật thông tin
                        </a></div>
                    <div class="single-setting-panel"><a href="{{ route('user.setting.show-password') }}">
                            <div class="icon-wrapper bg-info"><i class="bi bi-lock"></i></div>Đổi mật khẩu
                        </a></div>
                    <div class="single-setting-panel btn-logout" ><a href="#">
                            <div class="icon-wrapper bg-danger"><i class="bi bi-box-arrow-right"></i></div>Đăng xuất
                        </a></div>

                </div>
            </div>
        </div>
    </div>

@endsection
