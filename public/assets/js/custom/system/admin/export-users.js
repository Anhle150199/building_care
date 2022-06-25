"use strict";
var KTModalExportUsers = (function () {
    const t = document.getElementById("kt_modal_export_users"),
        e = t.querySelector("#kt_modal_export_users_form"),
        n = new bootstrap.Modal(t);
    return {
        init: function () {
            !(function () {
                var o = FormValidation.formValidation(e, {
                    fields: {
                        format: {
                            validators: {
                                notEmpty: {
                                    message: "Hãy chọn định dạng file",
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
                i.addEventListener("click", function (t) {
                    t.preventDefault(),
                        o &&
                            o.validate().then(function (t) {
                                const format = $("select[name=format]").val();

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
                                                  Swal.fire({
                                                      text: "Danh sách admins đã được xuất!",
                                                      icon: "success",
                                                      buttonsStyling: !1,
                                                      confirmButtonText:
                                                          "Chấp nhận!",
                                                      customClass: {
                                                          confirmButton:
                                                              "btn btn-primary",
                                                      },
                                                  }).then(function (t) {
                                                      t.isConfirmed &&
                                                          (n.hide(),
                                                          (i.disabled = !1));
                                                          $('.buttons-'+format).click();

                                                  });
                                          }, 2e3))
                                        : Swal.fire({
                                              text: "Xin lỗi, có một số vấn đề cần được khắc phục trước khi xuất.",
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
                        .addEventListener("click", function (t) {
                            t.preventDefault(),
                                Swal.fire({
                                    text: "Bạn có chắc chắn muốn hủy không?",
                                    icon: "warning",
                                    showCancelButton: !0,
                                    buttonsStyling: !1,
                                    confirmButtonText: "Huỷ!",
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
                        .addEventListener("click", function (t) {
                            t.preventDefault(),
                                Swal.fire({
                                    text: "Bạn có chắc chắn muốn hủy không?",
                                    icon: "warning",
                                    showCancelButton: !0,
                                    buttonsStyling: !1,
                                    confirmButtonText: "Huỷ!",
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
    KTModalExportUsers.init();
});
