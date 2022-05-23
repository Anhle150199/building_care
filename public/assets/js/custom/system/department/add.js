"use strict";
var KTUsersAddUser = (function () {
    const t = document.getElementById("kt_modal_add_user"),
        e = t.querySelector("#kt_modal_add_department_form"),
        n = new bootstrap.Modal(t);
        var reloadDropdown = ()=>{
            KTMenu.init();
            KTMenu.updateDropdowns();
            KTMenu.init();
        }
    return {
        init: function () {
            (() => {
                var o = FormValidation.formValidation(e, {
                    fields: {
                        department_name: {
                            validators: {
                                notEmpty: { message: "Tên phòng là bắt buộc " },
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
                    '[data-kt-departments-modal-action="submit"]'
                );
                const token = $('input[name="_token"]').val();
                const colIndex = (id)=>{return `<div class="form-check form-check-sm form-check-custom form-check-solid"><input class="form-check-input" type="checkbox" value="${id}" /></div>`};
                const colEnd = (id, name)=>{
                    return `<a href="#" class="btn btn-light btn-active-light-primary btn-sm btn-icon" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"> <span class="svg-icon svg-icon-5 m-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <rect x="10" y="10" width="4" height="4" rx="2" fill="currentColor"></rect> <rect x="17" y="10" width="4" height="4" rx="2" fill="currentColor"></rect> <rect x="3" y="10" width="4" height="4" rx="2" fill="currentColor"></rect>
                                    </svg>
                                </span>
                            </a>
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
                                data-kt-menu="true">
                                <div class="menu-item px-3">
                                    <a href="#" onclick="showEditModal('${id}', '${name}')" class="menu-link px-3">Chỉnh sửa</a>
                                </div>
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-table-filter="delete_row">Xoá</a>
                                </div>
                            </div>`;
                    };
                var table = $('#kt_table_departments').DataTable();
                var type;
                i.addEventListener("click", (t) => {
                    t.preventDefault(),
                        o && o.validate().then(function (t) {
                            console.log("validated!"),
                                "Valid" == t ? (i.setAttribute("data-kt-indicator","on"),
                                    (i.disabled = !0),
                                    (type = $("#add_department_form_type").val(),
                                        type == "new" ?
                                        $.ajax({
                                            url: "/admin/system/departments/new",
                                            type: "post",
                                            data: {
                                                '_token': token,
                                                name: $("#department_name").val(),
                                            },
                                            dataType: "json",
                                            success: function (data) {
                                                const newRow = table.row.add( [colIndex(data.id), data.name, 0, data.time, colEnd(data.id, data.name)] ).node()
                                                newRow.id = 'row_'+data.id;
                                                $(newRow).attr('data-id', `${data.id}`);
                                                $(newRow).find('td')[4].className = 'text-center';
                                                table.draw();
                                                reloadDropdown();
                                                i.removeAttribute("data-kt-indicator"),
                                                    (i.disabled = !1),
                                                    Swal.fire({
                                                        text: "Thêm mới thành công!",
                                                        icon: "success",
                                                        buttonsStyling:!1,
                                                        confirmButtonText: "Chấp nhận!",
                                                        customClass: {confirmButton: "btn btn-primary",},
                                                    }).then(function (t) {
                                                        e.reset();
                                                        t.isConfirmed && n.hide();
                                                    });
                                            },
                                            error: function (data) {
                                                const errors = data.responseJSON.errors;
                                                if (errors.name){
                                                    $(".invalid-feedback").text(errors.name);
                                                }
                                                i.removeAttribute("data-kt-indicator"),
                                                    (i.disabled = !1),
                                                    Swal.fire({
                                                        text: "Xin lỗi, có một vài vấn đề cần được khắc phục trước khi gửi.",
                                                        icon: "error",
                                                        buttonsStyling: !1,
                                                        confirmButtonText: "Chấp nhận!",
                                                        customClass: { confirmButton: "btn btn-primary",},
                                                    });
                                            },
                                        }) :
                                        $.ajax({
                                            url: "/admin/system/departments/edit",
                                            type: "put",
                                            data: {
                                                '_token': token,
                                                name: $("#department_name").val(),
                                                id: $('#add_department_form_id').val(),
                                            },
                                            dataType: "json",
                                            success: function (data) {
                                                const editRow = table.row('#row_'+data.id).data([colIndex(data.id), data.name, data.count, data.time, colEnd(data.id, data.name)]).node();
                                                editRow.id = 'row_'+data.id;
                                                $(editRow).attr('data-id', `${data.id}`);
                                                $(editRow).find('td')[4].className = 'text-center';
                                                table.draw();
                                                reloadDropdown();
                                                i.removeAttribute("data-kt-indicator"),
                                                    (i.disabled = !1),
                                                    Swal.fire({
                                                        text: "Cập nhật thành công!",
                                                        icon: "success",
                                                        buttonsStyling:!1,
                                                        confirmButtonText: "Chấp nhận!",
                                                        customClass: {
                                                            confirmButton: "btn btn-primary",
                                                        },
                                                    }).then(function (t) {
                                                        e.reset();
                                                        t.isConfirmed && n.hide();
                                                    });
                                            },
                                            error: function (data) {
                                                const errors =
                                                    data.responseJSON
                                                        .errors;
                                                console.log(errors);
                                                if (errors.name)
                                                    $(".invalid-feedback").text(errors.name);
                                                else
                                                    $(".invalid-feedback").text(errors.id);

                                                i.removeAttribute("data-kt-indicator"),
                                                (i.disabled = !1),
                                                Swal.fire({
                                                    text: "Xin lỗi, có một vài vấn đề cần được khắc phục trước khi gửi.",
                                                    icon: "error",
                                                    buttonsStyling: !1,
                                                    confirmButtonText: "Chấp nhận!",
                                                    customClass: { confirmButton: "btn btn-primary",},
                                                });
                                            },
                                        })
                                        )
                                    )
                                    : Swal.fire({
                                        text: "Xin lỗi, có một vài vấn đề cần được khắc phục trước khi gửi.",
                                        icon: "error",
                                        buttonsStyling: !1,
                                        confirmButtonText: "Chấp nhận!",
                                        customClass: { confirmButton: "btn btn-primary",},
                                    });
                        });
                }),
                    t.querySelector('[data-kt-departments-modal-action="cancel"]').addEventListener("click", (t) => {
                        t.preventDefault(), Swal.fire({
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
                            t.value ? (e.reset(), n.hide()) : "cancel" === t.dismiss
                                && Swal.fire({
                                    text: "Tiếp tục chỉnh sửa!.",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Chấp nhận!",
                                    customClass: {confirmButton: "btn btn-primary",},
                                });
                        });
                    }), t.querySelector('[data-kt-departments-modal-action="close"]')
                        .addEventListener("click", (t) => {
                            t.preventDefault(),Swal.fire({
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
                                t.value ? (e.reset(), n.hide())
                                    : "cancel" === t.dismiss && Swal.fire({
                                        text: "Tiếp tục chỉnh sửa!.",
                                        icon: "error",
                                        buttonsStyling: !1,
                                        confirmButtonText: "Chấp nhận!",
                                        customClass: { confirmButton: "btn btn-primary"},
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
