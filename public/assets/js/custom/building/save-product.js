"use strict";

var KTAppEcommerceSaveProduct = (function () {
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
                        placeholder: "Viết mô tả cho toà nhà...",
                        theme: "snow",
                    }));

            }),
                (() => {
                    const e = document.getElementById(
                            "kt_ecommerce_add_product_status"
                        ),
                        t = document.getElementById(
                            "kt_ecommerce_add_product_status_select"
                        ),
                        o = ["bg-success", "bg-warning", "bg-danger"];
                    $(t).on("change", function (t) {
                        switch (t.target.value) {
                            case "active":
                                e.classList.remove(...o),
                                    e.classList.add("bg-success");

                                break;
                            case "prepare":
                                e.classList.remove(...o),
                                    e.classList.add("bg-warning");

                                break;
                            case "lock":
                                e.classList.remove(...o),
                                    e.classList.add("bg-danger");
                                break;
                        }
                    });
                })(),
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
                                        message: "Tên toà nhà không được để trống.",
                                    },
                                },
                            },
                            building_code: {
                                validators: {
                                    notEmpty: {
                                        message: "Mã toà nhà không được để trống.",
                                    },
                                },
                            },
                            address: {
                                validators: {
                                    notEmpty: {
                                        message: "Địa chỉ không được để trống.",
                                    },
                                },
                            },

                            email: {
                                validators: {
                                    emailAddress: {
                                        message: "Giá trị không hợp lệ.",
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
                            height:{
                                validators: {
                                    integer: { message:"Giá trị không phải là một số lớn hơn 0."},
                                    greaterThan: {
                                        message: 'Giá trị không phải là một số lớn hơn 0.',
                                        min: 1,
                                    },
                                },
                            },
                            floors_number: {
                                validators: {
                                    notEmpty: { message: "Số tầng không được để trống." },
                                    integer: { message:"Giá trị không phải là một số lớn hơn 0."},
                                    greaterThan: {
                                        message: 'Giá trị không phải là một số lớn hơn 0.',
                                        min: 1,
                                    },
                                },
                            },
                            apartment_number: {
                                validators: {
                                    notEmpty: {
                                        message: "Số phòng không được để trống.",
                                    },
                                    integer: { message:"Giá trị không phải là một số lớn hơn 0."},
                                    greaterThan: {
                                        message: 'Giá trị không phải là một số lớn hơn 0.',
                                        min: 1,
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
                                e &&
                                    e.validate().then(function (e) {
                                        console.log("validated!"),
                                            "Valid" == e
                                                ? (o.setAttribute(
                                                      "data-kt-indicator",
                                                      "on"
                                                  ),
                                                  (o.disabled = !0),
                                                  setTimeout(() => {
                                                    let quill = new Quill("#kt_ecommerce_add_product_description", {});
                                                    let token = $('input[name=_token]').val();

                                                    let id = $(t).data('id');
                                                    let status = $('#kt_ecommerce_add_product_status_select').val();
                                                    let height = $('input[name=height]').val();
                                                    let acreage = $('input[name=acreage]').val();
                                                    let floors_number = $('input[name=floors_number]').val();
                                                    let apartment_number = $('input[name=apartment_number]').val();
                                                    let name = $('input[name=product_name]').val();
                                                    let address = $('input[name=address]').val();
                                                    let email = $('input[name=email]').val();
                                                    let phone = $('input[name=phone]').val();
                                                    let description = quill.root.innerHTML;
                                                    let building_code = $('input[name=building_code]').val();
                                                    let data ={
                                                        _token: token,
                                                        id: id,
                                                        name: name,
                                                        description: description,
                                                        address: address,
                                                        phone: phone,
                                                        email: email,
                                                        status: status,
                                                        height: height,
                                                        acreage: acreage,
                                                        floors_number: floors_number,
                                                        apartment_number: apartment_number,
                                                        building_code: building_code,
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
                                                                  buttonsStyling:
                                                                      !1,
                                                                  confirmButtonText:
                                                                      "Chấp nhận!",
                                                                  customClass: {
                                                                      confirmButton:
                                                                          "btn btn-primary",
                                                                  },
                                                              }).then(function (e) {
                                                                  e.isConfirmed &&
                                                                      ((o.disabled =
                                                                          !1),
                                                                      (window.location =
                                                                          t.getAttribute(
                                                                              "data-kt-redirect"
                                                                          )));
                                                              });
                                                        },
                                                        error: function (response) {
                                                            let messageErr = (mess)=>{return `<div class="fv-plugins-message-container invalid-feedback"><div data-field="address" data-validator="notEmpty">${mess}</div></div>`}
                                                            console.log(response);
                                                          const errors = response.responseJSON.errors;
                                                          console.log(errors);
                                                          if(errors.name){
                                                            $('input[name=product_name]').parent().append(messageErr(errors.name))
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
