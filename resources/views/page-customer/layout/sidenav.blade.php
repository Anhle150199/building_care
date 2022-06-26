<div class="offcanvas offcanvas-start" id="affanOffcanvas" data-bs-scroll="true" tabindex="-1"
    aria-labelledby="affanOffcanvsLabel">
    <button class="btn-close btn-close-white text-reset" type="button" data-bs-dismiss="offcanvas"
        aria-label="Close"></button>
    <div class="offcanvas-body p-0">
        <!-- Side Nav Wrapper -->
        <div class="sidenav-wrapper">
            <!-- Sidenav Profile -->
            <div class="sidenav-profile bg-gradient">
                <div class="sidenav-style1"></div>
                <!-- User Thumbnail -->
                <div class="user-profile"><img src="img/bg-img/2.jpg" alt=""></div>
                <!-- User Info -->
                <div class="user-info">
                    <h6 class="user-name mb-0">{{Auth::user()->name}}</h6><span>{{Auth::user()->email}}</span>
                </div>
            </div>
            <!-- Sidenav Nav -->
            <ul class="sidenav-nav ps-0">
                <li><a href="{{ route('user.home') }}"><i class="bi bi-house-door"></i>Trang chủ</a></li>
                {{-- <li><a href="elements.html"><i class="bi bi-folder2-open"></i>Elements<span
                            class="badge bg-danger rounded-pill ms-2">220+</span></a></li> --}}
                <li><a href="pages.html"><i class="bi bi-collection"></i>Thông báo, tin tức</a></li>
                <li><a href="#"><i class="bi bi-bar-chart-steps"></i>Khác</a>
                    <ul>
                        <li><a href="page-shop-grid.html">Đăng ký phương tiện</a></li>
                        <li><a href="page-shop-details.html">Lịch bảo trì</a></li>
                        <li><a href="page-shop-list.html">Gửi góp ý</a></li>
                    </ul>
                </li>
                <li><a href="settings.html"><i class="bi bi-gear"></i>Cài đặt</a></li>
                <li>
                    <div class="night-mode-nav"><i class="bi bi-moon"></i>Chế độ ban đêm
                        <div class="form-check form-switch">
                            <input class="form-check-input form-check-success" id="darkSwitch" type="checkbox">
                        </div>
                    </div>
                </li>
                <li><a href="page-login.html"><i class="bi bi-box-arrow-right"></i>Đăng xuất</a></li>
            </ul>
        </div>
    </div>
</div>
