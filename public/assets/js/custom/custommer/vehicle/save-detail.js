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
                            apartment: {
                                validators: {
                                    notEmpty: {
                                        message: messageNotEmpty,
                                    },
                                },
                            },
                            category: {
                                validators: {
                                    notEmpty: {
                                        message: messageNotEmpty,
                                    },
                                },
                            },
                            model: {
                                validators: {
                                    notEmpty: {
                                        message: messageNotEmpty,
                                    },
                                },
                            },
                            license_plate_number: {
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
                                    "Valid" == e ? (
                                        o.setAttribute("data-kt-indicator","on"),
                                        (o.disabled = !0),
                                        setTimeout(() => {
                                            let quill = new Quill("#kt_ecommerce_add_product_description", {});
                                            let token = $('input[name=_token]').val();
                                            let ok = true;
                                            let id = $(t).data('id');
                                            let apartment_id = $('select[name=apartment]').val();
                                            let category = $('select[name=category]').val();
                                            let model = $('input[name=model]').val();
                                            let license_plate_number = $('input[name=license_plate_number]').val();

                                            let description = quill.root.innerHTML;

                                            if(ok == true){

                                                let data ={
                                                    _token: token,
                                                    id: id,
                                                    apartment_id: apartment_id,
                                                    category:category,
                                                    model: model,
                                                    license_plate_number: license_plate_number,
                                                    description: description,
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
                                                        if(errors.apartment_id){
                                                            $('select[name=apartment]').parent().append(messageErr(errors.apartment_id))
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
