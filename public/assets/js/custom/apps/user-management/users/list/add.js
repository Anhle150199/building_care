"use strict";
var KTUsersAddUser = (function () {
    const t = document.getElementById("kt_modal_add_user"),
        e = t.querySelector("#kt_modal_add_user_form"),
        n = new bootstrap.Modal(t);
    return {
        init: function () {
            (() => {
                var o = FormValidation.formValidation(e, {
                    fields: {
                        user_name: {
                            validators: {
                                notEmpty: { message: "Họ tên là bắt buộc " },
                            },
                        },
                        user_email: {
                            validators: {
                                notEmpty: {
                                    message: "Địa chỉ Email là bắt buộc",
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
                const i = t.querySelector(
                    '[data-kt-users-modal-action="submit"]'
                );
                i.addEventListener("click", (t) => {
                    t.preventDefault(),
                        o &&
                            o.validate().then(function (t) {
                                console.log("validated!"),
                                    "Valid" == t
                                        ? (i.setAttribute(
                                              "data-kt-indicator",
                                              "on"
                                          ),
                                          (i.disabled = !0),
                                          setTimeout(function () {
                                              i.removeAttribute(
                                                  "data-kt-indicator"
                                              ),
                                                  (i.disabled = !1),
                                                  Swal.fire({
                                                      text: "Tạo tài khoản thành công!",
                                                      icon: "success",
                                                      buttonsStyling: !1,
                                                      confirmButtonText:
                                                          "Chấp nhận!",
                                                      customClass: {
                                                          confirmButton:
                                                              "btn btn-primary",
                                                      },
                                                  }).then(function (t) {
                                                      t.isConfirmed && n.hide();
                                                  });
                                          }, 2e3))
                                        : Swal.fire({
                                              text: "Xin lỗi, có một vài vấn đề cần được khắc phục trước khi gửi.",
                                              icon: "error",
                                              buttonsStyling: !1,
                                              confirmButtonText: "Chấp nhận!",
                                              customClass: {
                                                  confirmButton:
                                                      "btn btn-primary",
                                              },
                                          });
                            });
                }),
                    t
                        .querySelector('[data-kt-users-modal-action="cancel"]')
                        .addEventListener("click", (t) => {
                            t.preventDefault(),
                                Swal.fire({
                                    text: "Bạn có chắc chắn muốn hủy không ?",
                                    icon: "warning",
                                    showCancelButton: !0,
                                    buttonsStyling: !1,
                                    confirmButtonText: "Huỷ",
                                    cancelButtonText: "Trở lại",
                                    customClass: {
                                        confirmButton: "btn btn-primary",
                                        cancelButton: "btn btn-active-light",
                                    },
                                }).then(function (t) {
                                    t.value
                                        ? (e.reset(), n.hide())
                                        : "cancel" === t.dismiss &&
                                          Swal.fire({
                                              text: "Tiếp tục chỉnh sửa!.",
                                              icon: "error",
                                              buttonsStyling: !1,
                                              confirmButtonText: "Chấp nhận!",
                                              customClass: {
                                                  confirmButton:
                                                      "btn btn-primary",
                                              },
                                          });
                                });
                        }),
                    t
                        .querySelector('[data-kt-users-modal-action="close"]')
                        .addEventListener("click", (t) => {
                            t.preventDefault(),
                                Swal.fire({
                                    text: "Bạn có chắc chắn muốn hủy không?",
                                    icon: "warning",
                                    showCancelButton: !0,
                                    buttonsStyling: !1,
                                    confirmButtonText: "Huỷ",
                                    cancelButtonText: "Trở lại",
                                    customClass: {
                                        confirmButton: "btn btn-primary",
                                        cancelButton: "btn btn-active-light",
                                    },
                                }).then(function (t) {
                                    t.value
                                        ? (e.reset(), n.hide())
                                        : "cancel" === t.dismiss &&
                                          Swal.fire({
                                              text: "Tiếp tục chỉnh sửa!.",
                                              icon: "error",
                                              buttonsStyling: !1,
                                              confirmButtonText: "Chấp nhận!",
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
    KTUsersAddUser.init();
});
