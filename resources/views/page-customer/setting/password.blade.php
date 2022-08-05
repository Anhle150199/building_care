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
                    <form id="form-update" data-action="{{ route('user.setting.update-password') }}"
                        data-redirect="{{ route('user.setting.show') }}">
                        @csrf
                        <div class="form-group mb-3 fv-row">
                            <label class="form-label" for="password_current">Mật khẩu hiện tại</label>
                            <input class="form-control" id="password_current" name="password_current" type="password">
                        </div>
                        <div class="form-group mb-3 fv-row">
                            <label class="form-label" for="password">Mật khẩu mới</label>
                            <input class="form-control" id="password" name="password" type="password">
                        </div>
                        <div class="form-group mb-3 fv-row">
                            <label class="form-label" for="password_confirmation">Xác nhận mật khẩu</label>
                            <input class="form-control" id="password_confirmation" name="password_confirmation" type="password">
                        </div>
                        <button type="submit" id="btn_submit" class="btn btn-danger w-100">
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
            var passwordForm = document.getElementById('form-update');
            var messNotEmpty="Trường này không được bỏ trống."
            validator = FormValidation.formValidation(
                passwordForm,
                {
                    fields: {
                        password_current: {
                            validators: {
                                notEmpty: {
                                    message: messNotEmpty
                                }
                            }
                        },

                        password: {
                            validators: {
                                notEmpty: {
                                    message: messNotEmpty
                                }
                            }
                        },

                        password_confirmation: {
                            validators: {
                                notEmpty: {
                                    message: messNotEmpty
                                },
                                identical: {
                                    compare: function() {
                                        return passwordForm.querySelector('[name="password"]').value;
                                    },
                                    message: 'Mật khẩu xác nhận không khớp'
                                }
                            }
                        },
                    },

                    plugins: { //Learn more: https://formvalidation.io/guide/plugins
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

                    if (status == 'Valid' ) {
                        let token = $('input[name=_token]').val();
                        let password_current = $("#password_current").val();
                        let password = $("#password").val();
                        let password_confirmation = $("#password_confirmation").val();

                        toggleBtnSubmit();
                        let data = {
                            _token: token,
                            password_current: password_current,
                            password: password,
                            password_confirmation: password_confirmation,
                        }

                        $.ajax({
                            url: $('form').data('action'),
                            type: 'put',
                            data: data,
                            typeData: 'json',
                            success: function() {
                                showToast('success');
                                setTimeout(() => {
                                    location.href = $('form').data('redirect')
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
