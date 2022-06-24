"use strict";

// Class definition
var KTAccountSettingsSigninMethods = function () {
    var messNotEmpty = "Trường này không được để trống."

    // Private functions
    var initSettings = function () {

        // UI elements
        var signInMainEl = document.getElementById('kt_signin_email');
        var signInEditEl = document.getElementById('kt_signin_email_edit');
        var passwordMainEl = document.getElementById('kt_signin_password');
        var passwordEditEl = document.getElementById('kt_signin_password_edit');

        // button elements
        var signInChangeEmail = document.getElementById('kt_signin_email_button');
        var signInCancelEmail = document.getElementById('kt_signin_cancel');
        var passwordChange = document.getElementById('kt_signin_password_button');
        var passwordCancel = document.getElementById('kt_password_cancel');

        // toggle UI
        signInChangeEmail.querySelector('button').addEventListener('click', function () {
            toggleChangeEmail();
        });

        signInCancelEmail.addEventListener('click', function () {
            toggleChangeEmail();
        });

        passwordChange.querySelector('button').addEventListener('click', function () {
            toggleChangePassword();
        });

        passwordCancel.addEventListener('click', function () {
            toggleChangePassword();
        });

        var toggleChangeEmail = function () {
            signInMainEl.classList.toggle('d-none');
            signInChangeEmail.classList.toggle('d-none');
            signInEditEl.classList.toggle('d-none');
        }

        var toggleChangePassword = function () {
            passwordMainEl.classList.toggle('d-none');
            passwordChange.classList.toggle('d-none');
            passwordEditEl.classList.toggle('d-none');
        }
    }

    var handleChangeEmail = function (e) {
        var validation;
        // form elements
        var signInForm = document.getElementById('kt_signin_change_email');

        validation = FormValidation.formValidation(
            signInForm,
            {
                fields: {
                    emailaddress: {
                        validators: {
                            notEmpty: {
                                message: messNotEmpty
                            },
                            emailAddress: {
                                message: 'Email sai định dạng'
                            }
                        }
                    },

                    confirmemailpassword: {
                        validators: {
                            notEmpty: {
                                message: messNotEmpty
                            }
                        }
                    }
                },

                plugins: { //Learn more: https://formvalidation.io/guide/plugins
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row'
                    })
                }
            }
        );

        signInForm.querySelector('#kt_signin_submit').addEventListener('click', function (e) {
            e.preventDefault();
            console.log('click');

            validation.validate().then(function (status) {
                if (status == 'Valid') {
                    let token = $('input[name=_token]').val();
                    let email = $('#emailaddress').val();
                    let password = $('#confirmemailpassword').val()
                    let data = {
                        _token : token,
                        email: email,
                        password: password
                    }
                    $.ajax({
                        url: $("#kt_signin_change_email").data('action'),
                        data: data,
                        type: 'post',
                        dataType: 'json',
                        success: function(){
                            swal.fire({
                                text: "Thành công",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Chấp nhận!",
                                customClass: {
                                    confirmButton: "btn font-weight-bold btn-light-primary"
                                }
                            }).then(function(){
                                signInForm.reset();
                                validation.resetForm();
                            });
                        },
                        error: function(data){
                            console.log(data);
                            let errors = data.responseJSON.errors;
                            console.log(errors);
                            if(errors.email){
                                swal.fire({
                                    text: "Email bị trùng!",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Chấp nhận!",
                                    customClass: {
                                        confirmButton: "btn font-weight-bold btn-light-primary"
                                    }
                                });
                            }else if (errors.password) {
                                swal.fire({
                                    text: "Mật khẩu không đúng.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Chấp nhận!",
                                    customClass: {
                                        confirmButton: "btn font-weight-bold btn-light-primary"
                                    }
                                });
                            }
                        }
                    })

                } else {
                    swal.fire({
                        text: "Có lỗi xảy ra. Hãy thử lại sau.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn font-weight-bold btn-light-primary"
                        }
                    });
                }
            });
        });
    }

    var handleChangePassword = function (e) {
        var validation;

        // form elements
        var passwordForm = document.getElementById('kt_signin_change_password');

        validation = FormValidation.formValidation(
            passwordForm,
            {
                fields: {
                    currentpassword: {
                        validators: {
                            notEmpty: {
                                message: messNotEmpty
                            }
                        }
                    },

                    newpassword: {
                        validators: {
                            notEmpty: {
                                message: messNotEmpty
                            }
                        }
                    },

                    confirmpassword: {
                        validators: {
                            notEmpty: {
                                message: messNotEmpty
                            },
                            identical: {
                                compare: function() {
                                    return passwordForm.querySelector('[name="newpassword"]').value;
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

        passwordForm.querySelector('#kt_password_submit').addEventListener('click', function (e) {
            e.preventDefault();
            console.log('click');

            validation.validate().then(function (status) {
                if (status == 'Valid') {
                    let currentpassword = $("#currentpassword").val();
                    let newpassword = $("#newpassword").val();
                    let confirmpassword = $("#confirmpassword").val();
                    let token = $('input[name=_token]').val();

                    let data = {
                        _token: token,
                        currentpassword: currentpassword,
                        newpassword: newpassword,
                        confirmpassword: confirmpassword
                    }
                    $.ajax({
                        url: $("#kt_signin_change_password").data('action'),
                        type: 'post',
                        data: data,
                        typeData: 'json',
                        success: function(){
                            swal.fire({
                                text: "Thành công",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Chấp nhận!",
                                customClass: {
                                    confirmButton: "btn font-weight-bold btn-light-primary"
                                }
                            }).then(function(){
                                passwordForm.reset();
                                validation.resetForm(); // Reset formvalidation --- more info: https://formvalidation.io/guide/api/reset-form/
                            });
                        },
                        error: function(data){
                            console.log(data);
                            let errors = data.responseJSON.errors;
                            console.log(errors);
                            if(errors.currentpassword){
                                swal.fire({
                                    text: "Mật khẩu không đúng.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Chấp nhận!",
                                    customClass: {
                                        confirmButton: "btn font-weight-bold btn-light-primary"
                                    }
                                });
                            } else{
                                swal.fire({
                                    text: "Có lỗi xảy ra. Hãy thử lại sau.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn font-weight-bold btn-light-primary"
                                    }
                                });
                            }
                        }
                    });

                } else {
                    swal.fire({
                        text: "Có lỗi xảy ra. Hãy thử lại sau.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn font-weight-bold btn-light-primary"
                        }
                    });
                }
            });
        });
    }

    // Public methods
    return {
        init: function () {
            initSettings();
            handleChangeEmail();
            handleChangePassword();
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    KTAccountSettingsSigninMethods.init();
});
