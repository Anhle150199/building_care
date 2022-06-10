"use strict";
var KTSubscriptionsExport = (function () {
    var t, e, n, o, i, r, s;
    return {
        init: function () {
            (t = document.querySelector("#kt_export_modal")),
                (s = new bootstrap.Modal(t)),
                (r = document.querySelector("#kt_export_form")),
                (e = r.querySelector("#kt_export_submit")),
                (n = r.querySelector("#kt_export_cancel")),
                (o = t.querySelector("#kt_export_close")),
                (i = FormValidation.formValidation(r, {
                    fields: {
                        format: {
                            validators: {
                                notEmpty: { message: "Hãy chọn định dạng file" },
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
                e.addEventListener("click", function (t) {
                    t.preventDefault(),
                        i &&
                            i.validate().then(function (t) {
                                const format = $("select[name=format]").val();
                                console.log("validated!"),
                                    "Valid" == t
                                        ? (e.setAttribute(
                                              "data-kt-indicator",
                                              "on"
                                          ),
                                          (e.disabled = !0),
                                          setTimeout(function () {
                                              e.removeAttribute(
                                                  "data-kt-indicator"
                                              ),
                                                  Swal.fire({
                                                      text: "Danh sách đã được xuất!",
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
                                                          (s.hide(),
                                                          (e.disabled = !1));
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
                n.addEventListener("click", function (t) {
                    t.preventDefault(),
                        Swal.fire({
                            text: "Are you sure you would like to cancel?",
                            icon: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Yes, cancel it!",
                            cancelButtonText: "No, return",
                            customClass: {
                                confirmButton: "btn btn-primary",
                                cancelButton: "btn btn-active-light",
                            },
                        }).then(function (t) {
                            t.value
                                ? (r.reset(), s.hide())
                                : "cancel" === t.dismiss
                                // &&
                                //   Swal.fire({
                                //       text: "Your form has not been cancelled!.",
                                //       icon: "error",
                                //       buttonsStyling: !1,
                                //       confirmButtonText: "Chấp nhận!",
                                //       customClass: {
                                //           confirmButton: "btn btn-primary",
                                //       },
                                //   });
                        });
                }),
                o.addEventListener("click", function (t) {
                    t.preventDefault(),
                        Swal.fire({
                            text: "Bạn có chắc chắn muốn huỷ không?",
                            icon: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Có",
                            cancelButtonText: "Không",
                            customClass: {
                                confirmButton: "btn btn-primary",
                                cancelButton: "btn btn-active-light",
                            },
                        }).then(function (t) {
                            t.value
                                ? (r.reset(), s.hide())
                                : "cancel" === t.dismiss
                                // &&
                                // Swal.fire({
                                //     text: "Your form has not been cancelled!.",
                                //       icon: "error",
                                //       buttonsStyling: !1,
                                //       confirmButtonText: "Chấp nhận!",
                                //       customClass: {
                                //           confirmButton: "btn btn-primary",
                                //       },
                                //   });
                        });
                })
                // ,
                // (function () {
                //     const t = r.querySelector("[name=date]");
                //     $(t).flatpickr({
                //         altInput: !0,
                //         altFormat: "F j, Y",
                //         dateFormat: "Y-m-d",
                //         mode: "range",
                //     });
                // })()
                ;
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTSubscriptionsExport.init();
});
