"use strict";

var KTAppEcommerceSaveProduct = (function () {
    const messageNotEmpty = "Trường này không được để trống";
    const messageInteger = "Giá trị không phải là một số lớn hơn 0.";
    return {
        init: function () {
            var o, a;
            [
                "#kt_ecommerce_add_product_description"
            ].forEach((e) => {
                let t = document.querySelector(e);
                t &&
                    (t = new Quill(e, {
                        modules: {
                            toolbar: [
                                [{ header: [1, 2, !1] }],
                                ["bold", "italic", "underline"],
                                [ "code-block"],
                            ],
                        },
                        placeholder: "Viết mô tả cho căn hộ...",
                        theme: "snow",
                    }));

            }),
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
                            product_name: {
                                validators: {
                                    notEmpty: {
                                        message: messageNotEmpty,
                                    },
                                },
                            },
                            apartment_code: {
                                validators: {
                                    notEmpty: {
                                        message: messageNotEmpty,
                                    },
                                },
                            },
                            floor: {
                                validators: {
                                    notEmpty: { message: messageNotEmpty },
                                    integer: { message:messageInteger},
                                    between: {
                                        min: 1,
                                        max: $('input[name=floor]').data('floor'),
                                        message: 'Số tầng phải lớn hơn 0 và nhở hơn '+$('input[name=floor]').data('floor'),
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
                    console.log('bat dau lang nghe');
                        o.addEventListener("click", (a) => {
                            console.log('nghe duoc');
                            a.preventDefault(),
                                e &&
                                    e.validate().then(function (e) {
                                        console.log("validated!"),
                                            "Valid" == e
                                                ? (o.setAttribute(
                                                      "data-kt-indicator","on"
                                                  ),
                                                  (o.disabled = !0),
                                                  setTimeout(() => {
                                                    let quill = new Quill("#kt_ecommerce_add_product_description", {});
                                                    let token = $('input[name=_token]').val();
                                                    let ok = true;
                                                    let id = $(t).data('id');
                                                    let name = $('input[name=product_name]').val();
                                                    let apartment_code = $('input[name=apartment_code]').val();
                                                    let building_id = $('input[name=building]').data('id');
                                                    let status = $('select[name=status]').val();
                                                    let owner_id = $('select[name=owner]').val();
                                                    let floor = $('input[name=floor]').val();
                                                    let description = quill.root.innerHTML;
                                                    if (status == 'empty') {
                                                        owner_id = null;
                                                    } else if(owner_id == ""){
                                                        let check = FormValidation.formValidation(t, {
                                                            fields: {
                                                                owner: {
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
                                                                confirmButton:
                                                                    "btn btn-primary",
                                                            },
                                                        });
                                                        ok = false;
                                                    }
                                                    if(ok == true){

                                                        let data ={
                                                            _token: token,
                                                            id: id,
                                                            name: name,
                                                            apartment_code:apartment_code,
                                                            building_id: building_id,
                                                            owner_id: owner_id,
                                                            description: description,
                                                            status: status,
                                                            floor: floor,
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
                                                                if(errors.apartment_code){
                                                                    $('input[name=apartment_code]').parent().append(messageErr(errors.apartment_code))
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
