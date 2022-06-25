@extends('layout.guest')
@section('content')
		<div class="d-flex flex-column flex-root" >
			<div class="d-flex flex-column flex-column-fluid">
				<div class="d-flex flex-column flex-column-fluid text-center p-10 py-lg-15">
					<div class="pt-lg-10 mb-10">
						<h1 class="fw-bolder fs-2qx text-gray-800 mb-7">Liên kết hết hạn</h1>
						<div class="fw-bold fs-3 text-muted mb-15">Liên kết xác thực của bạn đã hết han. Bạn có thể gửi lại yêu cầu để  lấy liên kết mới</div>
						<div class="text-center">
							{{-- <button class="btn btn-primary btn-lg fw-bolder" id="btn-resend" >Gửi lại</button> --}}
                            <button type="button" id="kt_resend_submit" class="btn btn-lg btn-primary fw-bolder me-4">
                                <span class="indicator-label">Gửi lại</span>
                                <span class="indicator-progress">Đang gửi...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                            @csrf
                            <input type="hidden" id="data" data-action="{{route("auth.sent-mail-reset-password")}}" data-type="{{@$type}}" data-email="{{@$email}}" data-name="{{@$name}}">
						</div>
					</div>
					<div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px" style="background-image: url(assets/media/illustrations/sketchy-1/17.png"></div>
				</div>
			</div>
		</div>
@endsection
@push('js')
    <script>
        $(function(){
            $('#kt_resend_submit').click(function(){
                submitButton = document.querySelector('#kt_resend_submit');
                submitButton.setAttribute('data-kt-indicator', 'on');
                submitButton.disabled = true;
                let token =$('input[name=_token]').val();
                let email = $('#data').data('email');
                let action = $('#data').data('action');
                let type = $('#data').data('type');
                let name = $('#data').data('name');

                let data={
                    _token: token,
                    email: email,
                    type: type,
                    name: name
                }
                $.ajax({
                    url: action,
                    type: 'post',
                    data: data,
                    dataType: 'json',
                    success: function(){
                        submitButton.removeAttribute('data-kt-indicator');
                        submitButton.disabled = false;

                        Swal.fire({
                            text: "Đã gửi!",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Chấp nhận!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        })
                    },
                    error: function(data){
                        console.log(data);
                        Swal.fire({
                            text: "Có lỗi xảy ra. Hãy thử lại sau.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                        submitButton.removeAttribute('data-kt-indicator');
                        submitButton.disabled = false;
                    }
                })


            })
        })
    </script>
@endpush
