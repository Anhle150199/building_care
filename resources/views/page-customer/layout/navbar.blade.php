<div class="footer-nav-area" id="footerNav">
    <div class="container px-0">
        <div class="footer-nav position-relative">
            <ul class="h-100 d-flex align-items-center justify-content-between ps-0">
                <li @if (@$menu == 'home') class="active" @endif><a href="{{ route('user.home') }}">
                        <i class="bi bi-house-fill lead "></i>
                        <span>Trang chủ</span>
                    </a>
                </li>
                <li @if (@$menu == 'notify') class="active" @endif><a href="pages.html">
                        <i class="bi bi-megaphone-fill lead"></i>
                        <span>Thông báo</span>
                    </a></li>
                <li @if (@$menu == 'support') class="active" @endif><a href="{{ route('user.support.show-list') }}">
                        <i class="bi bi-chat-right-dots-fill lead"></i>
                        <span>Hỗ trợ</span>
                    </a></li>
                <li @if (@$menu == 'setting') class="active" @endif><a href="{{ route('user.setting.show') }}">
                        <i class="bi bi-gear-fill lead "></i>
                        <span>Cài đặt</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
