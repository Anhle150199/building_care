"use strict";
var KTSubscriptionsList = (function () {
    const token = $('input[name="_token"]').val();
    var t,
        e,
        n,
        o,
        c
    const i = () => {
        // const e = t.querySelectorAll('tbody [type="checkbox"]');
        // let r = !1,
        //     l = 0;
        // e.forEach((t) => {
        //     t.checked && ((r = !0), l++);
        // }),
        //     r
        //         ? ((c.innerHTML = l),
        //           n.classList.add("d-none"),
        //           o.classList.remove("d-none"))
        //         : (n.classList.remove("d-none"), o.classList.add("d-none"));
    };
    return {
        init: function () {
            (t = document.getElementById("kt_table")) &&
                (
                (e = $(t).DataTable({
                    info: !1,
                    order: [],
                    pageLength: 10,
                    lengthChange: !1,
                    columnDefs: [
                        // { orderable: !1, targets: 0 },
                        { orderable: !1, targets: 4 },
                    ],
                    dom: 'Bfrtip',
                    buttons: [
                        'csv', 'excel', 'pdf'
                    ]
                })).on("draw", function () {
                     i();
                }),
                document
                    .querySelector(
                        '[data-kt-table-filter="search"]'
                    )
                    .addEventListener("keyup", function (t) {
                        e.search(t.target.value).draw();
                    }));
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTSubscriptionsList.init();
});
