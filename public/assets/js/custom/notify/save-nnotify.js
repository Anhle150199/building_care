"use strict";

var KTAppEcommerceSaveProduct = (function () {
    var emptyMessage = "Trường này không được để trống.";
    var toolbarOptions = [
        [{ 'font': [] }],
        // [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
        [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
        ['bold', 'italic', 'underline', 'strike'],        // toggled buttons

        [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
        [{ 'align': [] }],['blockquote', 'code-block'],

        [{ 'header': 1 }, { 'header': 2 }],               // custom button values
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
        [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
        [{ 'direction': 'rtl' }],                         // text direction
        ['link'],
        ['clean']                            // remove formatting button
      ];

    return {
        init: function () {
            var o, a;
            [
                "#kt_description"
            ].forEach((e) => {
                let t = document.querySelector(e);
                t &&
                    (t = new Quill(e, {
                        modules: {
                            toolbar:toolbarOptions
                        },
                        placeholder: "Viết thông báo, tin tức...",
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
                        title: {
                            validators: {
                                notEmpty: {
                                    message: emptyMessage,
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
                                            ? (o.setAttribute("data-kt-indicator","on"),
                                            (o.disabled = !0),
                                            setTimeout(() => {
                                                let building_select;
                                                let mess='';
                                                let quill = new Quill("#kt_description", {});
                                                let token = $('input[name=_token]').val();
                                                let ok = true;
                                                let id = $(t).data('id');
                                                let status = $('#status_select').val();
                                                let category = $('#category_select').val();

                                                let sent_type = $('input[name=sent_type]:checked').val();
                                                if(sent_type == '1'){
                                                    building_select = [];
                                                } else {
                                                    building_select = $('#building_select').val();
                                                    // console.log(building_select);
                                                    if(building_select.length == 0){
                                                        let buildingCheck = FormValidation.formValidation(t, {
                                                            fields: {
                                                                building_select: {
                                                                    validators: {
                                                                        notEmpty: {
                                                                            message: emptyMessage,
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
                                                        buildingCheck.validate();
                                                        if("Valid" != buildingCheck)
                                                            ok = false;
                                                    }

                                                    building_select = JSON.stringify(building_select);
                                                }

                                                let title = $('input[name=title]').val();
                                                let image = $('input[name=image')[0].files[0];
                                                if ($(t).data('type') == 'new' || image != undefined) {
                                                    let imageCheck = FormValidation.formValidation(t, {
                                                        fields: {
                                                            image: {
                                                                validators: {
                                                                    notEmpty: {
                                                                        message: emptyMessage,
                                                                    },
                                                                    file: {
                                                                        extension: 'jpeg,jpg,png',
                                                                        type: 'image/jpeg,image/png',
                                                                        maxSize: 2097152, // 2048 * 1024
                                                                        message: 'Chấp nhận các file ảnh nhỏ hơn 2Mb có đuôi jpg, jpeg, png.',
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
                                                    imageCheck.validate().then(function (e) {
                                                        if("Valid" != e){
                                                            ok = false;
                                                            mess = 'image không được để trống.'
                                                            console.log(imageCheck);
                                                        }
                                                    });

                                                }else image =null;

                                                let description = quill.root.innerHTML;
                                                if(description == '<p><br></p>'){
                                                    ok = false;
                                                    mess = 'Nội dung không được để trống.'
                                                }
                                                if(ok == false){
                                                    o.removeAttribute("data-kt-indicator"),o.disabled = !1,
                                                    Swal.fire({
                                                        html: "Xin lỗi,có một số vấn đề cần phải giải quyết trước khi gửi. <br/>Hãy thử lại sau.<br/>"+mess ,
                                                        icon: "error",
                                                        buttonsStyling: !1,
                                                        confirmButtonText: "Chấp nhận",
                                                        customClass: {confirmButton: "btn btn-primary",},
                                                    });
                                                }else{
                                                    let data = new FormData();
                                                    data.append('_token', token);
                                                    data.append('id', id);
                                                    data.append('title', title);
                                                    data.append('image', image);
                                                    data.append('content', description);
                                                    data.append('status', status);
                                                    data.append('category', category);
                                                    data.append('sent_type', sent_type);
                                                    data.append('building_select', building_select);
                                                    for (const value of data.values()) {
                                                        console.log(value);
                                                    }
                                                    $.ajaxSetup({
                                                        headers: {
                                                            'X-CSRF-TOKEN': token
                                                        }
                                                     });
                                                    $.ajax({
                                                        url: $(t).data('action'),
                                                        type: 'post',
                                                        data: data,
                                                        enctype: 'multipart/form-data',
                                                        processData: false,  // tell jQuery not to process the data
                                                        contentType: false,   // tell jQuery not to set contentType
                                                        success: function (response) {
                                                            console.log(response);
                                                            o.removeAttribute(
                                                                "data-kt-indicator"
                                                            ),
                                                                Swal.fire({
                                                                    text: "Đã xong!",
                                                                    icon: "success",
                                                                    buttonsStyling:!1,
                                                                    confirmButtonText:
                                                                        "Chấp nhận!",
                                                                    customClass: {
                                                                        confirmButton:
                                                                            "btn btn-primary",
                                                                    },
                                                                }).then(function (e) {
                                                                    e.isConfirmed &&
                                                                        (o.disabled =!1);
                                                                        (window.location =t.getAttribute("data-kt-redirect"));
                                                                });
                                                        },
                                                        error: function (response) {
                                                            let messageErr = (mess)=>{return `<div class="fv-plugins-message-container invalid-feedback"><div data-field="address" data-validator="notEmpty">${mess}</div></div>`}
                                                            console.log(response);
                                                            const errors = response.responseJSON.errors;
                                                            console.log(errors);
                                                            o.removeAttribute("data-kt-indicator"),o.disabled = !1,
                                                            Swal.fire({
                                                                html: "Có lỗi xảy ra. <br/>Hãy thử lại sau.",
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
                                                html: "Có lỗi xảy ra. <br/>Hãy thử lại sau.",
                                                icon: "error",
                                                buttonsStyling: !1,
                                                confirmButtonText:"Chấp nhận",
                                                customClass: {confirmButton: "btn btn-primary",},
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
