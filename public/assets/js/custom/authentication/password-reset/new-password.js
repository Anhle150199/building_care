"use strict";

// Class Definition
var KTPasswordResetNewPassword = function() {
    // Elements
    var form;
    var submitButton;
    var validator;
    var passwordMeter;

    var handleForm = function(e) {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validator = FormValidation.formValidation(
			form,
			{
				fields: {
                    'password': {
                        validators: {
                            notEmpty: {
                                message: 'Trường này không được để trống'
                            },
                            callback: {
                                message: 'Mật khẩu chưa đủ mạnh',
                                callback: function(input) {
                                    if (input.value.length > 0) {
                                        return validatePassword();
                                    }
                                }
                            }
                        }
                    },
                    'confirm-password': {
                        validators: {
                            notEmpty: {
                                message: 'Trường này không được để trống'
                            },
                            identical: {
                                compare: function() {
                                    return form.querySelector('[name="password"]').value;
                                },
                                message: 'Mật khẩu không khớp'
                            }
                        }
                    },
                    // 'toc': {
                    //     validators: {
                    //         notEmpty: {
                    //             message: 'You must accept the terms and conditions'
                    //         }
                    //     }
                    // }
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger({
                        event: {
                            password: false
                        }
                    }),
					bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
				}
			}
		);

        submitButton.addEventListener('click', function (e) {
            e.preventDefault();

            validator.revalidateField('password');

            validator.validate().then(function(status) {
		        if (status == 'Valid') {
                    submitButton.setAttribute('data-kt-indicator', 'on');

                    submitButton.disabled = true;

                    let tokenMidle = $('input[name=_token]').val();
                    let token = $('#kt_new_password_form').data('token');
                    let url = $('#kt_new_password_form').data('action');
                    let password = $('#password').val();
                    let data = {
                        _token: tokenMidle,
                        token: token,
                        password: password,
                    }
                    $.ajax({
                        url:  url,
                        type:'post',
                        data: data,
                        dataType: 'json',
                        success: function(data){
                            submitButton.removeAttribute('data-kt-indicator');
                            submitButton.disabled = false;

                            Swal.fire({
                                text: "Thành công!",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Chấp nhận!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            }).then(function (result) {
                                if (result.isConfirmed) {
                                    form.querySelector('[name="password"]').value= "";
                                    form.querySelector('[name="confirm-password"]').value= "";
                                    passwordMeter.reset();  // reset password meter
                                    //form.submit();
                                    location.href=$('#kt_new_password_form').data('redirect');
                                }
                            });
                        },
                        error: function(data){
                            console.log(data);
                            Swal.fire({
                                text: "Có lỗi xảy ra. Hãy thử lại sau.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Chấp nhận!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                            submitButton.removeAttribute('data-kt-indicator');
                            submitButton.disabled = false;

                        }
                    })
                } else {
                    Swal.fire({
                        text: "Có lỗi xảy ra. Hãy thử lại sau.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Chấp nhận!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
		    });
        });

        form.querySelector('input[name="password"]').addEventListener('input', function() {
            if (this.value.length > 0) {
                validator.updateFieldStatus('password', 'NotValidated');
            }
        });
    }

    var validatePassword = function() {
        return  (passwordMeter.getScore() === 100);
    }

    // Public Functions
    return {
        // public functions
        init: function() {
            form = document.querySelector('#kt_new_password_form');
            submitButton = document.querySelector('#kt_new_password_submit');
            passwordMeter = KTPasswordMeter.getInstance(form.querySelector('[data-kt-password-meter="true"]'));

            handleForm();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    KTPasswordResetNewPassword.init();
});
