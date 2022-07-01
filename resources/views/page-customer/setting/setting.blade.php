@extends('page-customer.layout.app')
@section('title', 'Cài đặt')
@push('css')
@endpush
@section('content')

    <div class="page-content-wrapper py-3">
        <div class="container">
            <div class="card user-info-card mb-3">
                <div class="card-body d-flex align-items-center">
                    <div class="user-profile me-3" >
                        @if (Auth::user()->avatar == null)
                        <img class="avatar" src="{{url('/')}}/customer/img/bg-img/2.jpg" id="img-preview">
                        @else
                        <img class="avatar" src="{{url('/')}}/images/avatar-user/{{Auth::user()->avatar}}" id="img-preview">
                        @endif
                        <i class="bi bi-pencil" id="btn-img"></i>
                        <form id="form-avatar" data-action="{{ route('user.setting.update-avatar') }}">
                            <input id="input-img" class="form-control" type="file" accept="image/*">
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

@push('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(function(){
        $("#btn-img").on('click',()=>{
            $('#input-img').click();
        });
        $('.avatar').each(function(e){
            $(this).height($(this).width());
        })

    })
    $('#input-img').change((e)=>{
        e.preventDefault();
        let token = $('input[name=_token]').val();
        let src = URL.createObjectURL(e.target.files[0]);
        let file = e.target.files[0];
        let data = new FormData();
        data.append('avatar', file);
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': token}
        });

        $.ajax({
            url: $('#form-avatar').data('action'),
            type: 'post',
            data: data,
            enctype: 'multipart/form-data',
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
            success: function(data){
                $(".avatar").attr("src", src);
                $('.avatar').each(function(e){
                    $(this).height($(this).width());
                })
            },
            error: function(data){
                console.log(data);
                swal.fire({
                    html: "Đã xảy ra lỗi.<br/> Thử lại sau.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Chấp nhận!",
                    customClass: {
                        confirmButton: "btn fw-bold btn-light-primary"
                    }
                });
            }
        })

    })
</script>
@endpush
