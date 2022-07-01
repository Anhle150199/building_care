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
                <div class="user-profile">
                    @if (Auth::user()->avatar == null)
                        <img class="avatar" src="{{ url('/') }}/customer/img/bg-img/2.jpg" alt="">
                    @else
                        <img class="avatar" src="{{ url('/') }}/images/avatar-user/{{Auth::user()->avatar}}" alt="">
                    @endif
                </div>
                <!-- User Info -->
                <div class="user-info">
                    <h6 class="user-name mb-0">{{ Auth::user()->name }}</h6><span>{{ Auth::user()->email }}</span>
                </div>
            </div>
            <!-- Sidenav Nav -->
            <ul class="sidenav-nav ps-0">
                <li><a href="{{ route('user.home') }}"><i class="bi bi-house-door"></i>Trang chủ</a></li>
                <li><a href="pages.html"><i class="bi bi-calendar2-event-fill"></i>Lịch bảo trì</a></li>
                <li><a href="pages.html"><i class="bi bi-collection"></i>Đăng ký phương tiện</a></li>
                <li><a href="pages.html"><i class="bi bi-collection"></i>Hỗ trợ</a></li>
                <li>
                    <div class="night-mode-nav"><i class="bi bi-bell"></i><label for="notifySwitch">Gửi thông
                            báo</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input form-check-success" id="notifySwitch" type="checkbox">
                        </div>
                    </div>
                </li>
                <li>
                    <div class="night-mode-nav"><i class="bi bi-moon"></i><label for="darkSwitch">Chế độ ban đêm</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input form-check-success" id="darkSwitch" type="checkbox">
                        </div>
                    </div>
                </li>
                <li>
                    <div class="night-mode-nav"><i class="bi bi-arrow-repeat"></i></i><label for="rtlSwitch">RTL
                            Mode</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input form-check-success" id="rtlSwitch" type="checkbox">
                        </div>
                    </div>
                </li>
                <li class="btn-logout"><a href="#"><i class="bi bi-box-arrow-right"></i>Đăng xuất</a></li>
            </ul>
        </div>
    </div>
</div>
