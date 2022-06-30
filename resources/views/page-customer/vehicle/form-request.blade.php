@extends('page-customer.layout.app-detail')
@push('css')
<link href="{{ url('/') }}/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
{{-- <link href="{{ url('/') }}/assets/css/style.bundle.css" rel="stylesheet" type="text/css" /> --}}
@endpush
@section('back', route('user.show-vehicle'))
@section('content')
    <div class="page-content-wrapper py-3">
        <div class="container">
            <div class="card user-data-card">
                <div class="card-body">
                    <form id="form-request" data-action="{{ route('user.vehicle-create') }}"
                        data-redirect="{{ route('user.show-vehicle') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="form-label" for="apartment">Căn hộ</label>
                            <select class="form-select" id="apartment" name="apartment">
                                @foreach ($list as $item)
                                    <option value="{{ $item->id }}">
                                        {{ 'Căn hộ ' . $item->name . '  (' . $item->apartment_code . ')' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="category">Loai phương tiện</label>
                            <select class="form-select" id="category" name="category">
                                <option value="motorbike">Xe máy</option>
                                <option value="car">Ô tô</option>
                                <option value="electric_motorbike">Xe điện</option>
                            </select>
                        </div>
                        <div class="form-group mb-3 fv-row">
                            <label class="form-label" for="model">Model/Mẫu xe</label>
                            <input class="form-control" id="model" name="model" type="text"
                                placeholder="Honda Wave Alpha 110">
                        </div>
                        <div class="form-group mb-3 fv-row">
                            <label class="form-label" for="number">Biển số xe</label>
                            <input class="form-control" id="number" type="text" name="number" placeholder="30A66666">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="description">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" cols="30" rows="10"
                                placeholder="Mô tả về đặc điểm của xe như màu sắc, phân khối,..."></textarea>
                        </div>
                        <button type="submit" id="btn_submit" class="btn  btn-danger w-100">
                            <span class="indicator-label">Gửi yêu cầu</span>
                            <span class="indicator-progress">Đang gửi...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
<script src="{{ url('/') }}/assets/plugins/global/plugins.bundle.js"></script>
{{-- <script src="{{ url('/') }}/assets/js/scripts.bundle.js"></script> --}}

{{-- <script src="{{ url('/') }}/assets/plugins/custom/formrepeater/formrepeater.bundle.js"></script> --}}
<script>
    var form = document.querySelector('#form-request');
    var validator = FormValidation.formValidation(
        form, {
            fields: {
                'model': {
                    validators: {
                        notEmpty: {
                            message: 'Trường này không được để trống'
                        },
                    }
                },
                'number': {
                    validators: {
                        notEmpty: {
                            message: 'Trường này không được để trống'
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: '.fv-row'
                })
            }
        }
    );

    $('#btn_submit').click(function(e) {
        e.preventDefault();
        validator.validate().then(function(status) {
            if (status == 'Valid') {
                toggleBtnSubmit();
                let token = $('input[name=_token]').val();
                let apartment = $("#apartment").val();
                let category = $("#category").val();
                let model = $("#model").val();
                let number = $("#number").val();
                let description = $('#description').val();

                let data = {
                    _token: token,
                    apartment_id: apartment,
                    category: category,
                    model: model,
                    license_plate_number: number,
                    description: description
                }

                $.ajax({
                    url: $('form').data('action'),
                    type: 'post',
                    data: data,
                    typeData: 'json',
                    success: function() {
                        Swal.fire({
                            text: 'Thành công!',
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonColor: '#ea4c62',
                            confirmButtonText: 'Chấp nhận',
                            width: "80%"
                        }).then(function(result) {
                            if (result.isConfirmed) {
                                location.href=$('form').data('redirect')
                            }
                        });
                    },
                    error: function() {
                        Swal.fire({
                            text: 'Có lỗi xảy ra. Thử lại sau!',
                            icon: 'error',
                            confirmButtonColor: '#ea4c62',
                            confirmButtonText: 'Chấp nhận',
                            width: "80%"
                        })
                    }
                })
            } else{
                Swal.fire({
                    text: 'Có lỗi xảy ra. Hãy xem lại biểu mẫu!',
                    icon: 'error',
                    confirmButtonColor: "#ea4c62",
                    confirmButtonText: 'Chấp nhận',
                    width: "80%"
                })
            }
        })

    })
</script>
@endpush
