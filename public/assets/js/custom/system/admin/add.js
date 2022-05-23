"use strict";
const colIndex = (id)=>{
    return `<div class="form-check form-check-sm form-check-custom form-check-solid">
                <input class="form-check-input" type="checkbox" value="${id}" />
            </div>`;
},
colEnd = (id) => {
    return `<a href="#" class="btn btn-light btn-active-light-primary btn-sm btn-icon" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                <span class="svg-icon svg-icon-5 m-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect x="10" y="10" width="4" height="4" rx="2" fill="currentColor"></rect>
                        <rect x="17" y="10" width="4" height="4" rx="2" fill="currentColor"></rect>
                        <rect x="3" y="10" width="4" height="4" rx="2" fill="currentColor"></rect>
                    </svg>
                </span>
            </a>
            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                <div class="menu-item px-3">
                    <a class="menu-link px-3" onclick= "showEditModal('${id}')">Chỉnh sửa</a>
                </div>
                <div class="menu-item px-3">
                    <a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">Xoá</a>
                </div>
            </div>`;
},
colName = (id,name, email, avatar) =>{
    return `<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                <div class="symbol-label">
                    <img src="${location.origin}/assets/media/avatars/${avatar}" class="w-100" />
                </div>
            </div>
            <div class="d-flex flex-column">
                <a href="#" id="name_${id}" class="text-gray-800 text-hover-primary mb-1">${name}</a>
                <span id="email_${id}">${email}</span>
            </div>`;
},
colDepartment = (id, department, position) =>{
    return `<div class="d-flex flex-column">
                <span id="department_${id}" class="text-gray-800 text-hover-primary mb-1">${department}</span>
                <span id="position_${id}">${position}</span>
            </div>`;
},
colRole = (role)=>{
    if (role == 'super') return 'Super Admin';
    if(role == 'admin') return 'Admin';
};
var KTUsersAddUser = (function () {
    const t = document.getElementById("kt_modal_add_user"),
        e = t.querySelector("#kt_modal_add_user_form"),
        n = new bootstrap.Modal(t);
    const token = $('input[name="_token"]').val();

    function reloadDropdown(){
        KTMenu.init();
        KTMenu.updateDropdowns();
        KTMenu.init();
    };
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
                        department: {
                            validators: {
                                notEmpty: {
                                    message: "Bộ phận là bắt buộc",
                                },
                            },
                        },
                        position: {
                            validators: {
                                notEmpty: {
                                    message: "Chức vụ là bắt buộc",
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
                var table = $('#kt_table_users').DataTable();
                var type;
                i.addEventListener("click", (t) => {
                    t.preventDefault(),
                        o &&
                            o.validate().then(function (t) {
                                console.log("validated!"),
                                    "Valid" == t
                                        ?(i.setAttribute( "data-kt-indicator", "on"),
                                          (i.disabled = !0),
                                          (type = $("#add-form-type").val(),
                                          type == "new" ?
                                            $.ajax({
                                                url: "/admin/system/admins/create",
                                                type: "post",
                                                data: {
                                                    '_token': token,
                                                    name: $("#name").val(),
                                                    email: $('#email').val(),
                                                    department: $('#department').val(),
                                                    position: $('#position').val(),
                                                    role: $('input[name=user_role]:checked').val()
                                                },
                                                dataType: "json",
                                                success: function(data){
                                                    console.log(data);
                                                    const newRow = table.row.add( [colIndex(data.id), colName(data.id, data.name, data.email, data.avatar), colRole(data.role),colDepartment(data.id, data.department, data.position),data.status, `${data.time}`, colEnd(data.id, data.name)] ).node()
                                                    newRow.id = 'row_'+data.id;
                                                    $(newRow).attr('data-id', `${data.id}`);
                                                    $(newRow).find('td')[6].className = 'text-center';
                                                    $(newRow).find('td')[1].className = 'd-flex align-items-center';
                                                    $($(newRow).find('td')[2]).attr('id', `role_${data.id}`);
                                                    table.draw();
                                                    reloadDropdown();
                                                    KTMenu.init();
                                                    KTMenu.updateDropdowns();
                                                    KTMenu.init();
                                                    i.removeAttribute("data-kt-indicator"),
                                                        (i.disabled = !1),e.reset(),
                                                        Swal.fire({
                                                            text: "Tạo tài khoản thành công!",
                                                            icon: "success",
                                                            buttonsStyling: !1,
                                                            confirmButtonText: "Chấp nhận!",
                                                            customClass: { confirmButton: "btn btn-primary",},
                                                        }).then(function (t) {
                                                            t.isConfirmed && n.hide();
                                                        });
                                                },
                                                error: function (data) {
                                                    const errors = data.responseJSON.errors;
                                                    console.log(errors);

                                                    if (errors.name){
                                                        $($(".invalid-feedback")[1]).text(errors.name);
                                                    }
                                                    if (errors.email){
                                                        $($(".invalid-feedback")[2]).text(errors.email);
                                                    }
                                                    if (errors.department){
                                                        $($(".invalid-feedback")[3]).text(errors.department);
                                                    }
                                                    if (errors.position){
                                                        $($(".invalid-feedback")[4]).text(errors.position);
                                                    }
                                                    if (errors.role){
                                                        $($(".invalid-feedback")[5]).text(errors.role);
                                                    }
                                                    i.removeAttribute("data-kt-indicator"),
                                                    (i.disabled = !1),Swal.fire({
                                                        text: "Xin lỗi, có một vài vấn đề cần được khắc phục trước khi gửi.",
                                                        icon: "error",
                                                        buttonsStyling: !1,
                                                        confirmButtonText: "Chấp nhận!",
                                                        customClass: { confirmButton: "btn btn-primary"},
                                                    });
                                                    setTimeout(() => {
                                                        $(".invalid-feedback").empty();
                                                    }, 5000);
                                                }
                                            }): $.ajax({
                                                url: "/admin/system/admins/update",
                                                type: "put",
                                                data: {
                                                    '_token': token,
                                                    name: $("#name").val(),
                                                    email: $('#email').val(),
                                                    department: $('#department').val(),
                                                    position: $('#position').val(),
                                                    role: $('input[name=user_role]:checked').val(),
                                                    id: $('#id-user-edit').val()
                                                },
                                                dataType: "json",
                                                success: function(data){
                                                    const updateRow = table.row('#row_'+data.id).data( [colIndex(data.id), colName(data.id, data.name, data.email, data.avatar), colRole(data.role),colDepartment(data.id, data.department, data.position),data.status, `${data.time}`, colEnd(data.id, data.name)] ).node()
                                                    table.draw();
                                                    reloadDropdown();

                                                    i.removeAttribute( "data-kt-indicator"),
                                                        (i.disabled = !1),e.reset(),
                                                        Swal.fire({
                                                            text: "Chỉnh sửa thành công!",
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
                                                },
                                                error: function (data) {
                                                    const errors = data.responseJSON.errors;
                                                    console.log(errors);
                                                    i.removeAttribute("data-kt-indicator"),
                                                    (i.disabled = !1),Swal.fire({
                                                        text: "Xin lỗi, có một vài vấn đề cần được khắc phục trước khi gửi.",
                                                        icon: "error",
                                                        buttonsStyling: !1,
                                                        confirmButtonText: "Chấp nhận!",
                                                        customClass: { confirmButton: "btn btn-primary"},
                                                    });

                                                    if (errors.name){
                                                        $($(".invalid-feedback")[1]).text(errors.name);
                                                    }
                                                    if (errors.email){
                                                        $($(".invalid-feedback")[2]).text(errors.email);
                                                    }
                                                    if (errors.department){
                                                        $($(".invalid-feedback")[3]).text(errors.department);
                                                    }
                                                    if (errors.position){
                                                        $($(".invalid-feedback")[4]).text(errors.position);
                                                    }
                                                    if (errors.role){
                                                        $($(".invalid-feedback")[5]).text(errors.role);
                                                    }
                                                    setTimeout(() => {
                                                        $(".invalid-feedback").empty();
                                                    }, 7000);
                                                }
                                            })
                                          ))
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
