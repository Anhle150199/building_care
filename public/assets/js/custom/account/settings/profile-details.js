"use strict";
var KTAccountSettingsProfileDetails = (function () {
    var form, validation;

    return {
        init: function () {
            var mesageNotEmpty = "Trường này không được để trống.";

            (form = document.getElementById("kt_account_profile_details_form")),
            (validation = FormValidation.formValidation(form, {
                fields: {
                    name: {
                        validators: {
                            notEmpty: {
                                message: mesageNotEmpty,
                            },
                        },
                    },
                    department: {
                        validators: {
                            notEmpty: {
                                message: mesageNotEmpty,
                            },
                        },
                    },
                    position: {
                        validators: {
                            notEmpty: {
                                message: mesageNotEmpty,
                            },
                        },
                    },
                    avatar:{
                        validators: {
                            file: {
                                extension: 'jpeg,jpg,png',
                                type: 'image/jpeg,image/png',
                                maxSize: 2097152,
                                message: 'Chấp nhận các file ảnh nhỏ hơn 2Mb có đuôi jpg, jpeg, png.',
                            },
                        },
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row",
                        eleInvalidClass: "",
                        eleValidClass: "",
                    }),
                },
            }))
            $("#kt_account_profile_details_submit").on("click", function (e) {
                e.preventDefault();
                validation.validate().then(function (status) {
                    if (status == 'Valid') {
                        let avatar = $('input[name=avatar')[0].files[0];
                        let department = $('select[name=department]').val();
                        let position = $('input[name=position]').val();
                        let name = $('input[name=name]').val();
                        let token = $('input[name=_token]').val();

                        let data = new FormData();
                        if(avatar != undefined){
                            data.append('avatar', avatar);
                        }
                        data.append('department_id', department);
                        data.append('position', position);
                        data.append('name', name);
                        for (const value of data.values()) {
                            console.log(value);
                        }
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': token
                            }
                         });
                        $.ajax({
                            url: $(form).data('action'),
                            type: 'post',
                            data: data,
                            enctype: 'multipart/form-data',
                            processData: false,  // tell jQuery not to process the data
                            contentType: false,   // tell jQuery not to set contentType
                            success: function(data){
                                console.log(data);
                                swal.fire({
                                    text: "Thành công",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Châp nhận!",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-light-primary"
                                    }
                                });
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


                    } else {
                        swal.fire({
                            html: "Vi phạm điều kiện.<br/> Hãy xem lại.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Chấp nhận!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-light-primary"
                            }
                        });
                    }
                });

            })

        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTAccountSettingsProfileDetails.init();
});
