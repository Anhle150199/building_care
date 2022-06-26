<div class="footer-nav-area" id="footerNav">
    <div class="container px-0">
        <div class="footer-nav position-relative">
            <ul class="h-100 d-flex align-items-center justify-content-between ps-0">
                <li class="active"><a href="{{ route('user.home') }}">
                        <i class="bi bi-house display-6 @if ($menu == 'home') text-danger @endif"></i>
                        {{-- <span>Trang chủ</span> --}}
                    </a>
                </li>
                <li><a href="pages.html">
                        <i class="bi bi-megaphone display-6 @if ($menu == 'notify') text-danger @endif"></i>
                        {{-- <span>Thông báo</span> --}}
                    </a></li>
                <li><a href="page-chat-users.html">
                        <i class="bi bi-chat-right-dots display-6 @if ($menu == 'chat') text-danger @endif"></i>
                        {{-- <span>Chat</span> --}}
                    </a></li>
                <li><a href="settings.html">
                        <i class="bi bi-gear display-6 @if ($menu == 'seting') text-danger @endif"></i>
                        {{-- <span>Settings</span> --}}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
