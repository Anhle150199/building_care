"use strict";
var KTSigninGeneral = (function () {
    var t, e, i;
    return {
        init: function () {
            (t = document.querySelector("#kt_sign_in_form")),
                (e = document.querySelector("#kt_sign_in_submit")),
                (i = FormValidation.formValidation(t, {
                    fields: {
                        email: {
                            validators: {
                                notEmpty: {
                                    message: "Địa chỉ email là bắt buộc",
                                },
                                emailAddress: {
                                    message: "Địa chỉ email không hợp lệ",
                                },
                            },
                        },
                        password: {
                            validators: {
                                notEmpty: {
                                    message: "Mật khẩu là bắt buộc",
                                },
                            },
                        },
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: ".fv-row",
                        }),
                    },
                })),
                e.addEventListener("click", function (n) {
                    n.preventDefault(),
                        i.validate().then(function (i) {
                            "Valid" == i
                                ? (e.setAttribute("data-kt-indicator", "on"),
                                  (e.disabled = !0),
                                  $.ajax({
                                      type: 'POST',
                                      url: $('#kt_sign_in_form').attr('action'),
                                      data: {
                                        email: $('input[name=email]').val(),
                                        password: $('input[name=password]').val(),
                                        _token: $('input[name=_token]').val(),
                                    },
                                      dataType: 'JSON',
                                      success: function (data) {
                                        e.removeAttribute("data-kt-indicator"),
                                            (e.disabled = !1),
                                            Swal.fire({
                                                text: "Đăng nhập thành công!",
                                                icon: "success",
                                                buttonsStyling: !1,
                                                confirmButtonText: "Ok, Tiếp tục",
                                                customClass: {
                                                    confirmButton:
                                                        "btn btn-primary",
                                                },
                                            })
                                            .
                                            then(function (e) {
                                                if (e.isConfirmed) {
                                                    (t.querySelector(
                                                        '[name="email"]'
                                                    ).value = ""),
                                                        (t.querySelector(
                                                            '[name="password"]'
                                                        ).value = "");
                                                    var i = t.getAttribute(
                                                        "data-kt-redirect-url"
                                                    );
                                                    i && (location.href = i);
                                                }
                                            });
                                      },
                                      error: function(data){
                                        const errors = data.responseJSON.errors;
                                        Swal.fire({
                                            text: "Xin lỗi, có vài vấn đề cần được giải quyết. Hãy thử lại.",
                                            icon: "error",
                                            buttonsStyling: !1,
                                            confirmButtonText: "Chấp nhận!",
                                            customClass: {
                                                confirmButton: "btn btn-primary",
                                            },
                                        });
                                      }
                                  })
                                  )
                                : Swal.fire({
                                      text: "Xin lỗi, có vài vấn đề cần được giải quyết. Hãy thử lại.",
                                      icon: "error",
                                      buttonsStyling: !1,
                                      confirmButtonText: "Chấp nhận!",
                                      customClass: {
                                          confirmButton: "btn btn-primary",
                                      },
                                  });
                        });
                });
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTSigninGeneral.init();
});
