"use strict";

var KTAppEcommerceSaveProduct = (function () {
    const messageNotEmpty = "Trường này không được để trống";
    const messageInteger = "Giá trị không phải là một số lớn hơn 0.";

    return {
        init: function () {
            var o, a;
                (() => {
                    let e;
                    const t = document.getElementById(
                            "kt_ecommerce_add_product_form"
                        ),
                        o = document.getElementById(
                            "kt_ecommerce_add_product_submit"
                        );
                    (e = FormValidation.formValidation(t, {
                        fields: {
                            name: {
                                validators: {
                                    notEmpty: {
                                        message: messageNotEmpty,
                                    },
                                },
                            },
                            customer_code: {
                                validators: {
                                    notEmpty: {
                                        message: messageNotEmpty,
                                    },
                                    regexp: {
                                        regexp: /^\d{10,12}$/i,
                                        message: 'Giá trị không hợp lệ.',
                                    },
                                },
                            },
                            phone: {
                                validators: {
                                    regexp: {
                                        regexp: /^\d{10,11}$/i,
                                        message: 'Giá trị không hợp lệ.',
                                    },
                                },
                            },
                            email: {
                                validators: {
                                    notEmpty: {
                                        message: messageNotEmpty,
                                    },
                                    emailAddress: {
                                        message: "Giá trị không hợp lệ.",
                                    },
                                },
                            },
                            status: {
                                validators: {
                                    notEmpty: {
                                        message: messageNotEmpty,
                                    },
                                },
                            },
                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger(),
                            bootstrap: new FormValidation.plugins.Bootstrap5({
                                rowSelector: ".fv-row",
                                eleInvalidClass: "",
                                eleValidClass: "",
                            }),
                        },
                    })),
                    o.addEventListener("click", (a) => {
                        a.preventDefault(),
                            e && e.validate().then(function (e) {
                                console.log("validated!"),
                                    "Valid" == e
                                        ? (o.setAttribute("data-kt-indicator","on"),
                                            (o.disabled = !0),
                                            setTimeout(() => {
                                                let token = $('input[name=_token]').val();
                                                let ok = true;
                                                let id = $(t).data('id');
                                                let name = $('input[name=name]').val();
                                                let customer_code = $('input[name=customer_code]').val();
                                                let birthday = $('input[name=birthday]').val();
                                                let status = $('select[name=status]').val();
                                                let apartment = $('#apartment_select').val();
                                                let email = $('input[name=email]').val();
                                                let phone = $('input[name=phone]').val();
                                                let isOwner=0;
                                                if($('#owner_check:checkbox:checked').length>0){
                                                    isOwner =1;
                                                }

                                                if (status == 'leave') {
                                                    apartment = null;
                                                } else if(apartment == ""){
                                                    let check = FormValidation.formValidation(t, {
                                                        fields: {
                                                            apartment: {
                                                                validators: {
                                                                    notEmpty: {
                                                                        message: messageNotEmpty,
                                                                    },
                                                                },
                                                            },
                                                        },
                                                        plugins: {
                                                            trigger: new FormValidation.plugins.Trigger(),
                                                            bootstrap: new FormValidation.plugins.Bootstrap5({
                                                                rowSelector: ".fv-row",
                                                                eleInvalidClass: "",
                                                                eleValidClass: "",
                                                            }),
                                                        },
                                                    });
                                                    check.validate();
                                                    o.removeAttribute("data-kt-indicator"),o.disabled = !1,
                                                    Swal.fire({
                                                        html: "Xin lỗi,có một số vấn đề cần phải giải quyết trước khi gửi. <br/>Hãy thử lại sau.",
                                                        icon: "error",
                                                        buttonsStyling: !1,
                                                        confirmButtonText:
                                                            "Chấp nhận",
                                                        customClass: {
                                                            confirmButton:"btn btn-primary",
                                                        },
                                                    });
                                                    ok = false;
                                                }
                                                if(ok == true){

                                                    let data ={
                                                        _token: token,
                                                        id: id,
                                                        name: name,
                                                        customer_code:customer_code,
                                                        birthday: birthday,
                                                        email: email,
                                                        phone: phone,
                                                        status: status,
                                                        apartment_id: apartment,
                                                        isOwner: isOwner,
                                                    };
                                                    console.log(data);
                                                    $.ajax({
                                                        url: $(t).data('action'),
                                                        type: $(t).data('method'),
                                                        data: data,
                                                        dataType: 'json',
                                                        success: function (response) {
                                                        console.log(response);
                                                        o.removeAttribute(
                                                            "data-kt-indicator"
                                                        ),
                                                            Swal.fire({
                                                                text: "Đã xong!",
                                                                icon: "success",
                                                                buttonsStyling: !1,
                                                                confirmButtonText: "Chấp nhận!",
                                                                customClass: {
                                                                    confirmButton: "btn btn-primary",
                                                                },
                                                            }).then(function (e) {
                                                                e.isConfirmed &&
                                                                    ((o.disabled = !1),
                                                                    (window.location =
                                                                        t.getAttribute(
                                                                            "data-kt-redirect"
                                                                        )));
                                                            });
                                                        },
                                                        error: function (response) {
                                                            let messageErr = (mess)=>{return `<div class="fv-plugins-message-container invalid-feedback"><div data-field="address" data-validator="notEmpty">${mess}</div></div>`}
                                                            const errors = response.responseJSON.errors;
                                                            console.log(errors);
                                                            if(errors.customer_code){
                                                                $('input[name=customer_code]').parent().append(messageErr(errors.customer_code))
                                                            }
                                                            if(errors.email){
                                                                $('input[name=email]').parent().append(messageErr(errors.email))
                                                            }
                                                            setTimeout(() => {
                                                                $('.invalid-feedback').remove();
                                                            }, 7000);
                                                            o.removeAttribute(
                                                                "data-kt-indicator"
                                                            ),o.disabled = !1,
                                                            Swal.fire({
                                                                html: "Xin lỗi,có một số vấn đề cần phải giải quyết trước khi gửi. <br/>Hãy thử lại sau.",
                                                                icon: "error",
                                                                buttonsStyling: !1,
                                                                confirmButtonText:
                                                                    "Chấp nhận",
                                                                customClass: {
                                                                    confirmButton:
                                                                        "btn btn-primary",
                                                                },
                                                            });
                                                        }
                                                    });
                                                }

                                                }, 0)
                                            )
                                            : Swal.fire({
                                                    html: "Xin lỗi,có một số vấn đề cần phải giải quyết trước khi gửi. <br/>Hãy thử lại sau.",
                                                    icon: "error",
                                                    buttonsStyling: !1,
                                                    confirmButtonText:
                                                        "Chấp nhận",
                                                    customClass: {
                                                        confirmButton:
                                                            "btn btn-primary",
                                                    },
                                                });
                                });
                    });
                })();
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTAppEcommerceSaveProduct.init();
});
