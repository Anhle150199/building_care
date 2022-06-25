"use strict";

// Class Definition
var KTPasswordResetGeneral = function() {
    // Elements
    var form;
    var submitButton;
	var validator;

    var handleForm = function(e) {
        validator = FormValidation.formValidation(
			form,
			{
				fields: {
					'email': {
                        validators: {
							notEmpty: {
								message: 'Email không được để trống'
							},
                            emailAddress: {
								message: 'Email không đúng định dạng'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
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

            validator.validate().then(function (status) {
                if (status == 'Valid') {
                    submitButton.setAttribute('data-kt-indicator', 'on');
                    submitButton.disabled = true;
                    let token =$('input[name=_token]').val();
                    let email =$('input[name=email]').val();

                    let data={
                        _token: token,
                        email: email,
                        type: 'admin',
                        name: "reset-password"
                    }
                    $.ajax({
                        url: $('#kt_password_reset_form').data('action'),
                        data: data,
                        type: 'post',
                        dataType: 'json',
                        success: function(data){
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
                            }).then(function (result) {
                                if (result.isConfirmed) {
                                    form.querySelector('[name="email"]').value= "";
                                    //form.submit();
                                }
                            });
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
                    });
                } else {
                    Swal.fire({
                        text: "Có lỗi xảy ra. Hãy thử lại sau.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            });
		});
    }

    // Public Functions
    return {
        // public functions
        init: function() {
            form = document.querySelector('#kt_password_reset_form');
            submitButton = document.querySelector('#kt_password_reset_submit');

            handleForm();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    KTPasswordResetGeneral.init();
});
