"use strict";
var KTSubscriptionsList = (function () {
    const token = $('input[name="_token"]').val();
    var t,
        e,
        n,
        o,
        c,
        r = function () {
            t.querySelectorAll(
                '[data-kt-table-filter="delete_row"]'
            ).forEach((t) => {
                t.addEventListener("click", function (t) {
                    t.preventDefault();
                    const n = t.target.closest("tr"),
                        o = n.querySelectorAll("td")[1].innerText;
                    Swal.fire({
                        text: "Bạn có muốn xoá " + o + "?",
                        icon: "warning",
                        showCancelButton: !0,
                        buttonsStyling: !1,
                        confirmButtonText: "Xoá!",
                        cancelButtonText: "Trở lại",
                        customClass: {
                            confirmButton: "btn fw-bold btn-danger",
                            cancelButton:
                                "btn fw-bold btn-active-light-primary",
                        },
                    }).then(function (t) {
                        t.value
                            ? setTimeout(() => {
                                let id = [$(e.row($(n)).selector.rows[0]).attr('data-id')];
                                console.log(id);
                                $.ajax({
                                    url: $('#kt_toolbar').data('route-delete'),
                                    type: 'delete',
                                    data: {
                                        '_token': token,
                                        id: id
                                    },
                                    dataType: "json",
                                    success: function (data) {
                                        console.log(data);
                                        Swal.fire({
                                            text: "Bạn đã xoá " + o + "!.",
                                            icon: "success",
                                            buttonsStyling: !1,
                                            confirmButtonText: "Chấp nhận!",
                                            customClass: {
                                                confirmButton:
                                                    "btn fw-bold btn-primary",
                                            },
                                        })
                                            .then(function () {
                                                e.row($(n)).remove().draw();
                                            })
                                            .then(function () {
                                                i();
                                            });
                                    },
                                    error: function (data) {
                                        console.log(data);

                                        Swal.fire({
                                            text: o + " chưa được xoá.",
                                            icon: "error",
                                            buttonsStyling: !1,
                                            confirmButtonText: "Chấp nhận!",
                                            customClass: {
                                                confirmButton: "btn fw-bold btn-primary",
                                            },
                                        });
                                    },
                                })
                              }, 0)
                            : "cancel" === t.dismiss
                    });
                });
            });
        },
        l = () => {
            const r = t.querySelectorAll('[type="checkbox"]');
            (n = document.querySelector(
                '[data-kt-table-toolbar="base"]'
            )),
                (o = document.querySelector(
                    '[data-kt-table-toolbar="selected"]'
                )),
                (c = document.querySelector(
                    '[data-kt-table-select="selected_count"]'
                ));
            const a = document.querySelector(
                '[data-kt-table-select="delete_selected"]'
            );
            r.forEach((t) => {
                t.addEventListener("click", function () {
                    setTimeout(function () {
                        i();
                    }, 50);
                });
            }),
                a.addEventListener("click", function () {
                    Swal.fire({
                        text: "Bạn có muốn xoá mục đã chọn?",
                        icon: "warning",
                        showCancelButton: !0,
                        buttonsStyling: !1,
                        confirmButtonText: "Xoá!",
                        cancelButtonText: "Trở lại",
                        customClass: {
                            confirmButton: "btn fw-bold btn-danger",
                            cancelButton:
                                "btn fw-bold btn-active-light-primary",
                        },
                    }).then(function (n) {
                        let idDel = [];
                        r.forEach((t) => {
                            t.checked && idDel.push($(t.closest("tbody tr")).attr('data-id'));
                        });
                        idDel = idDel.filter((item)=>item!=undefined)
                        console.log(idDel);
                        n.value ? $.ajax({
                            url: $('#kt_toolbar').data('route-delete'),
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
                                    confirmButtonText: "Chấp nhận",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    },
                                })
                                    .then(function () {
                                        r.forEach((t) => {
                                            t.checked &&
                                                e
                                                    .row($(t.closest("tbody tr")))
                                                    .remove()
                                                    .draw();
                                        });
                                        t.querySelectorAll(
                                            '[type="checkbox"]'
                                        )[0].checked = !1;
                                    })
                                    .then(function () {
                                        i(), l();
                                    })
                            },
                            error:function (data) {
                                console.log(data);
                                Swal.fire({
                                    text: "Mục đã chọn chưa bị xoá.",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Chấp nhận!",
                                    customClass: { confirmButton: "btn fw-bold btn-primary"},
                                });
                            }
                        })

                            : "cancel" === n.dismiss;
                    });
                });
        };
    const i = () => {
        const e = t.querySelectorAll('tbody [type="checkbox"]');
        let r = !1,
            l = 0;
        e.forEach((t) => {
            t.checked && ((r = !0), l++);
        }),
            r
                ? ((c.innerHTML = l),
                  n.classList.add("d-none"),
                  o.classList.remove("d-none"))
                : (n.classList.remove("d-none"), o.classList.add("d-none"));
    };
    return {
        init: function () {
            (t = document.getElementById("kt_table")) &&
                (t.querySelectorAll("tbody tr").forEach((t) => {
                    const e = t.querySelectorAll("td"),
                        n = moment(e[5].innerHTML, "DD MMM YYYY, LT").format();
                    e[5].setAttribute("data-order", n);
                }),
                (e = $(t).DataTable({
                    info: !1,
                    order: [],
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
                    l(), r(), i();
                }),
                l(),
                document
                    .querySelector(
                        '[data-kt-table-filter="search"]'
                    )
                    .addEventListener("keyup", function (t) {
                        e.search(t.target.value).draw();
                    }),
                r());
                // ,
                // (function () {
                //     const t = document.querySelector(
                //             '[data-kt-table-filter="form"]'
                //         ),
                //         n = t.querySelector(
                //             '[data-kt-table-filter="filter"]'
                //         ),
                //         o = t.querySelector(
                //             '[data-kt-table-filter="reset"]'
                //         ),
                //         c = t.querySelectorAll("select");
                //     n.addEventListener("click", function () {
                //         var t = "";
                //         c.forEach((e, n) => {
                //             e.value &&
                //                 "" !== e.value &&
                //                 (0 !== n && (t += " "), (t += e.value));
                //         }),
                //             e.search(t).draw();
                //     }),
                //         o.addEventListener("click", function () {
                //             c.forEach((t, e) => {
                //                 $(t).val(null).trigger("change");
                //             }),
                //                 e.search("").draw();
                //         });
                // })()
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTSubscriptionsList.init();
});
