"use strict";
var KTUsersList = (function () {
    const token = $('input[name="_token"]').val();
    var e,
        t,
        n,
        r,
        o = document.getElementById("kt_table_users"),
        c = () => {
            o.querySelectorAll(
                '[data-kt-users-table-filter="delete_row"]'
            ).forEach((t) => {
                t.addEventListener("click", function (t) {
                    t.preventDefault();
                    const n = t.target.closest("tr"),
                        r = n
                            .querySelectorAll("td")[1]
                            .querySelectorAll("a")[0].innerText;
                    Swal.fire({
                        text: "Bạn có chắc muốn xoá " + r + "?",
                        icon: "warning",
                        showCancelButton: !0,
                        buttonsStyling: !1,
                        confirmButtonText: "Xoá",
                        cancelButtonText: "Huỷ",
                        customClass: {
                            confirmButton: "btn fw-bold btn-danger",
                            cancelButton:
                                "btn fw-bold btn-active-light-primary",
                        },
                    }).then(function (t) {
                        t.value
                            ? $.ajax({
                                url: "/admin/system/admins/delete",
                                type: "delete",
                                data: {
                                    '_token': token,
                                    id: [$(e.row($(n)).selector.rows[0]).attr('data-id')]
                                },
                                dataType: "json",
                                success: function (data) {
                                    console.log(data);
                                    Swal.fire({
                                        text: "Bạn đã xoá \"" + r + "\"!.",
                                        icon: "success",
                                        buttonsStyling: !1,
                                        confirmButtonText: "Chấp nhận!",
                                        customClass: { confirmButton: "btn fw-bold btn-primary"},
                                    }).then(function () {
                                        e.row($(n)).remove().draw();
                                    })
                                    .then(function () {a();})
                                },
                                error: function (data) {
                                    console.log(data.responseJSON.errors);
                                    Swal.fire({
                                        text: r + " chưa được xoá. Thử lại sau.",
                                        icon: "error",
                                        buttonsStyling: !1,
                                        confirmButtonText: "Chấp nhận!",
                                        customClass: {confirmButton: "btn fw-bold btn-primary"},
                                    });
                                },
                            })
                            : "cancel" === t.dismiss &&
                              Swal.fire({
                                  text: r + " chưa được xoá.",
                                  icon: "error",
                                  buttonsStyling: !1,
                                  confirmButtonText: "Chấp nhận!",
                                  customClass: {
                                      confirmButton: "btn fw-bold btn-primary",
                                  },
                              });
                    });
                });
            });
        },
        l = () => {
            const c = o.querySelectorAll('[type="checkbox"]');
            (t = document.querySelector('[data-kt-user-table-toolbar="base"]')),
                (n = document.querySelector(
                    '[data-kt-user-table-toolbar="selected"]'
                )),
                (r = document.querySelector(
                    '[data-kt-user-table-select="selected_count"]'
                ));
            const s = document.querySelector(
                '[data-kt-user-table-select="delete_selected"]'
            );
            c.forEach((e) => {
                e.addEventListener("click", function () {
                    setTimeout(function () {
                        a();
                    }, 50);
                });
            }),
                s.addEventListener("click", function () {
                    Swal.fire({
                        text: "Bạn có chắc muốn xoá mục đã chọn?",
                        icon: "warning",
                        showCancelButton: !0,
                        buttonsStyling: !1,
                        confirmButtonText: "Xoá!",
                        cancelButtonText: "Huỷ",
                        customClass: {
                            confirmButton: "btn fw-bold btn-danger",
                            cancelButton:
                                "btn fw-bold btn-active-light-primary",
                        },
                    }).then(function (t) {
                        let idDel = [];
                        c.forEach((t) => {
                            t.checked && idDel.push($(t.closest("tbody tr")).attr('data-id'));
                        });
                        idDel = idDel.filter((item)=>item!=undefined)
                        console.log(idDel);
                        t.value ? $.ajax({
                            url: "/admin/system/admins/delete",
                            type: "delete",
                            data: {
                                '_token': token,
                                id: idDel
                            },
                            dataType: "json",
                            success: function (data) {
                                Swal.fire({
                                    text: "Đã xoá!.",
                                    icon: "success",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Chấp nhận!",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    },
                                })
                                    .then(function () {
                                        c.forEach((t) => {
                                            t.checked &&
                                                e
                                                    .row($(t.closest("tbody tr")))
                                                    .remove()
                                                    .draw();
                                        });
                                        o.querySelectorAll('[type="checkbox"]')[0].checked = !1;
                                    })
                                    .then(function () {
                                        a(), l();
                                    })
                            },
                            error:function () {
                                Swal.fire({
                                    text: "Mục đã chọn chưa bị xoá.",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Chấp nhận!",
                                    customClass: { confirmButton: "btn fw-bold btn-primary"},
                                });
                            }
                        })
                            : "cancel" === t.dismiss &&
                              Swal.fire({
                                  text: "Mục đã chọn chưa bị xoá.",
                                  icon: "error",
                                  buttonsStyling: !1,
                                  confirmButtonText: "Chấp nhận!",
                                  customClass: {
                                      confirmButton: "btn fw-bold btn-primary",
                                  },
                              });
                    });
                });
        };
    const a = () => {
        const e = o.querySelectorAll('tbody [type="checkbox"]');
        let c = !1,
            l = 0;
        e.forEach((e) => {
            e.checked && ((c = !0), l++);
        }),
            c
                ? ((r.innerHTML = l),
                  t.classList.add("d-none"),
                  n.classList.remove("d-none"))
                : (t.classList.remove("d-none"), n.classList.add("d-none"));
    };
    return {
        init: function () {
            o &&
                (o.querySelectorAll("tbody tr").forEach((e) => {
                    const t = e.querySelectorAll("td")
                }),
                (e = $(o).DataTable({
                    info: !1,
                    order: [[1, 'asc']],
                    pageLength: 10,
                    lengthChange: !1,
                    columnDefs: [
                        { orderable: !1, targets: 0 },
                        { orderable: !1, targets: 6 },
                    ],
                    dom: 'Bfrtip',
                    buttons: [
                        'csv', 'excel', 'pdf'
                    ]
                })).on("draw", function () {
                    l(), c(), a();
                }),
                l(),
                document
                    .querySelector('[data-kt-user-table-filter="search"]')
                    .addEventListener("keyup", function (t) {
                        e.search(t.target.value).draw();
                    }),
                c(),
                (() => {
                    n.addEventListener("click", function () {
                        var t = "";
                        r.forEach((e, n) => {
                            e.value &&
                                "" !== e.value &&
                                (0 !== n && (t += " "), (t += e.value));
                        }),
                            e.search(t).draw();
                    });
                })());
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTUsersList.init();
});
