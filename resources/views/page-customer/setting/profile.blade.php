@extends('page-customer.layout.app-detail')
@push('css')
    <link href="{{ url('/') }}/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
@endpush
@section('back', route('user.setting.show'))
@section('content')
    <div class="page-content-wrapper py-3">
        <div class="container">
            <div class="card user-data-card">
                <div class="card-body">
                    <form id="form-update" data-action="{{ route('user.setting.update-profile') }}"
                        data-redirect="{{ route('user.setting.show') }}">
                        @csrf
                        <div class="form-group mb-3 fv-row">
                            <label class="form-label" for="name">Họ tên</label>
                            <input class="form-control" id="name" name="name" type="text"
                                value="{{ $user->name }}">
                        </div>
                        <div class="form-group mb-3 fv-row">
                            <label class="form-label" for="email">Email</label>
                            <input class="form-control" id="email" name="email" type="email"
                                value="{{ $user->email }}">
                        </div>
                        <div class="form-group mb-3 fv-row">
                            <label class="form-label" for="phone">Số điện thoại</label>
                            <input class="form-control" id="phone" name="phone" type="text"
                                value="{{ $user->phone }}">
                        </div>
                        <div class="form-group mb-3 fv-row">
                            <label class="form-label" for="birthday">Ngày sinh</label>
                            <input class="form-control" id="birthday" name="birthday"
                                value="{{ date('d-m-Y', strtotime($user->birthday)) }}">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="customer_code">Số CMND/CCCD</label>
                            <input class="form-control" id="customer_code" disabled value="{{ $user->customer_code }}">
                        </div>
                        <button type="submit" id="btn_submit" class="btn  btn-danger w-100">
                            <span class="indicator-label">Cập nhật</span>
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
    <script>
        $(function() {
            $("#birthday").daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 1901,
                maxYear: parseInt(moment().format("YYYY"), 10),
                locale: {
                    format: "DD-MM-YYYY"
                }

            }, function(start, end, label) {});
            // action form
            var form = document.querySelector('#form-update');
            var notEmptyMessage = 'Trường này không được để trống';

            var old_name = $("#name").val();
            var old_email = $("#email").val();
            var old_phone = $("#phone").val();
            var old_birthday = $("#birthday").val();
            var old_array = [old_name, old_email, old_phone, old_birthday];

            var validator = FormValidation.formValidation(
                form, {
                    fields: {
                        'name': {
                            validators: {
                                notEmpty: {
                                    message: notEmptyMessage
                                },
                            }
                        },
                        'email': {
                            validators: {
                                notEmpty: {
                                    message: notEmptyMessage
                                }
                            }
                        },
                        'phone': {
                            validators: {
                                regexp: {
                                    regexp: /^\d{10,11}$/i,
                                    message: 'Giá trị không hợp lệ.',
                                },

                            }
                        },
                        'birthday': {
                            validators: {
                                notEmpty: {
                                    message: notEmptyMessage
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
                    let token = $('input[name=_token]').val();
                    let name = $("#name").val();
                    let email = $("#email").val();
                    let phone = $("#phone").val();
                    let birthday = $("#birthday").val();
                    let current_array = [name, email, phone, birthday];
                    if(JSON.stringify(old_array) === JSON.stringify(current_array)){
                        showToast('warning');
                    }
                    else if (status == 'Valid' ) {
                        toggleBtnSubmit();
                        let data = {
                            _token: token,
                            name: name,
                            email: email,
                            phone: phone,
                            birthday: birthday,
                        }

                        $.ajax({
                            url: $('form').data('action'),
                            type: 'put',
                            data: data,
                            typeData: 'json',
                            success: function() {
                                showToast('success');
                                setTimeout(() => {
                                location.href = $('form').data('redirect');
                                }, 50);
                            },
                            error: function(data) {
                                console.log(data);
                                showToast('danger');
                                toggleBtnSubmit();
                            }
                        })
                    } else {
                        showToast('warning');
                    }
                })

            });
        })
    </script>
@endpush
