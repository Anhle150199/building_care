"use strict";
var KTAppCalendar = (function () {
    var e,t,n,a,o,r,i,l,d,s,c,m,u,v,f,p,y,D,_,b,k,g,S,Y,h,T,M,w,E,L,
        x = {
            id: "",
            eventName: "",
            eventDescription: "",
            eventLocation: "",
            startDate: "",
            endDate: "",
            allDay: !1,
        },
        B = !1;
    const token = $('input[name=_token]').val();
    const checkDateEnd = function() {
        return {
            validate: function(input) {
                let start_at = $('#kt_calendar_datepicker_start_date').val();
                let end_at = $('#kt_calendar_datepicker_end_date').val();

                if($('#kt_calendar_datepicker_allday').is(':checked') ){
                    if(start_at >= end_at){
                        return {
                            valid: false,
                        };
                    }
                }else{
                    start_at = $('#kt_calendar_datepicker_start_date').val() + ' ' + $('#kt_calendar_datepicker_start_time').val();
                    end_at = $('#kt_calendar_datepicker_end_date').val()+ ' ' + $('#kt_calendar_datepicker_end_time').val();

                    if(start_at >= end_at){
                        return {
                            valid: false,
                        };
                    }
                }
                return {
                    valid: true,
                };
            }
        }
    };

    const q = (e) => {
        C();
        const n = x.allDay
                ? moment(x.startDate).format("Do MMM, YYYY")
                : moment(x.startDate).format("Do MMM, YYYY - h:mm a"),
            a = x.allDay
                ? moment(x.endDate).format("Do MMM, YYYY")
                : moment(x.endDate).format("Do MMM, YYYY - h:mm a");
        var o = {
            container: "body",
            trigger: "manual",
            boundary: "window",
            placement: "auto",
            dismiss: !0,
            html: !0,
            title: "",
            content:
                '<div class="fw-bolder mb-2">' +x.eventName +
                '</div><div class="fs-7"><span class="fw-bold">Bắt đầu:</span> ' + n +
                '</div><div class="fs-7 mb-4"><span class="fw-bold">Kết thúc:</span> ' + a +
                '</div><div id="kt_calendar_event_view_button" type="button" class="btn btn-sm btn-light-primary">Xem thêm</div>',
        };
        (t = KTApp.initBootstrapPopover(e, o)).show(), (B = !0), F();
    },
    C = () => {B && (t.dispose(), (B = !1));},
    // form thêm mới
    N = () => {
        (f.innerText = "Thêm lịch bảo trì"), v.show();
        const t = p.querySelectorAll('[data-kt-calendar="datepicker"]'),
            r = p.querySelector("#kt_calendar_datepicker_allday");
        r.addEventListener("click", (e) => {
            e.target.checked
                ? t.forEach((e) => { e.classList.add("d-none"); })
                : (d.setDate(x.startDate, !0, "Y-m-d"),
                    t.forEach((e) => {e.classList.remove("d-none");}));
        }),
        O(x),
        _.addEventListener("click", function (t) {
            t.preventDefault(),
            y && y.validate().then(function (t) {
                console.log("validated!"),
                "Valid" == t
                    ? (_.setAttribute("data-kt-indicator","on"),
                        (_.disabled = !0),
                        setTimeout(function () {
                            let building_id=$('select[name=building_active]').val(),
                                title = $('#title').val(),
                                description = $('#description').val(),
                                location = $('#location').val(),
                                all_day, start_at, end_at, data;

                            if($('#kt_calendar_datepicker_allday').is(':checked')){
                                all_day = 1;
                                start_at = $('#kt_calendar_datepicker_start_date').val()+" "+"00:00:00";
                                end_at = $('#kt_calendar_datepicker_end_date').val()+" "+"00:00:00";
                            } else {
                                all_day = 0;
                                start_at = $('#kt_calendar_datepicker_start_date').val() + ' ' + $('#kt_calendar_datepicker_start_time').val();
                                end_at = $('#kt_calendar_datepicker_end_date').val()+ ' ' + $('#kt_calendar_datepicker_end_time').val();
                            }
                            if(description=="") description=null;
                            data = {
                                _token: token,
                                building_id: building_id,
                                title: title,
                                description: description,
                                location:location,
                                all_day: all_day,
                                start_at: start_at,
                                end_at: end_at
                            }
                            console.log(data);
                            $.ajax({
                                url:$("#kt_post").data('create'),
                                type: 'post',
                                data: data,
                                dataType: 'json',
                                success: function(response){
                                    console.log(response);
                                    _.removeAttribute("data-kt-indicator"),
                                    Swal.fire({
                                        text: "Đã thêm lịch bảo trì mới!",
                                        icon: "success",
                                        buttonsStyling: !1,
                                        confirmButtonText: "Chấp nhận!",
                                        customClass: { confirmButton: "btn btn-primary",},
                                    }).then(function (t) {
                                        if (t.isConfirmed) {
                                            v.hide(),(_.disabled = !1);
                                            let t = !1;
                                            r.checked && (t = !0), 0 === c.selectedDates.length &&(t = !0);
                                            var l = moment(i.selectedDates[0]).format(),
                                                s = moment(d.selectedDates[d.selectedDates.length - 1]).format();
                                            if (!t) {
                                                const e = moment(i.selectedDates[0]).format("YYYY-MM-DD"),
                                                    t = e;
                                                (l = e + "T" + moment(c.selectedDates[0]).format("HH:mm:ss")),
                                                (s =t + "T" + moment(u.selectedDates[0]).format("HH:mm:ss"));
                                            }
                                            let newEvent = {
                                                id: response[0].id,
                                                title: n.value,
                                                description:a.value,
                                                location: o.value,
                                                start: l,
                                                end: s,
                                                allDay: t,
                                            };
                                            e.addEvent(newEvent),
                                            e.render(),
                                            p.reset();
                                        }
                                    });
                                },
                                error: function(response){
                                    console.log(response);
                                    let errors = response.responseJSON.errors;
                                    console.log(errors);
                                    Swal.fire({
                                        text: "Có lỗi xảy ra, xin thử lại sau.",
                                        icon: "error",
                                        buttonsStyling: !1,
                                        confirmButtonText: "Chấp nhận",
                                        customClass: {confirmButton: "btn btn-primary",},
                                    });
                                    (_.setAttribute("data-kt-indicator","off"),_.disabled = !1)
                                }
                            });
                        }, 0))
                    : Swal.fire({
                        text: "Có lỗi xảy ra, xin thử lại sau.",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Chấp nhận",
                        customClass: {confirmButton: "btn btn-primary",},
                    });
            });
        });
    },
    A = () => {
        var e, t, n;
        w.show(),
            x.allDay
                ? ((e = "Cả ngày"),
                    (t = moment(x.startDate).format("Do MMM, YYYY")),
                    (n = moment(x.endDate).format("Do MMM, YYYY")))
                : ((e = ""),
                    (t = moment(x.startDate).format("Do MMM, YYYY - h:mm a")),
                    (n = moment(x.endDate).format("Do MMM, YYYY - h:mm a"))),
            (g.innerText = x.eventName),
            (S.innerText = e),
            (Y.innerText = x.eventDescription ? x.eventDescription : "--"),
            (h.innerText = x.eventLocation ? x.eventLocation : "--"),
            (T.innerText = t),
            (M.innerText = n);
    },
    // edit
    H = () => {
        E.addEventListener("click", (t) => {
            t.preventDefault(),
            w.hide(),
            (() => {
                (f.innerText = "Chỉnh sửa"), v.show();
                const t = p.querySelectorAll('[data-kt-calendar="datepicker"]'),
                    r = p.querySelector("#kt_calendar_datepicker_allday");
                r.addEventListener("click", (e) => {
                    e.target.checked
                        ? t.forEach((e) => { e.classList.add("d-none");})
                        : (d.setDate(x.startDate, !0, "Y-m-d"),
                        t.forEach((e) => { e.classList.remove("d-none");}));
                }),
                O(x),
                _.addEventListener("click", function (t) {
                    t.preventDefault(),
                    y && y.validate().then(function (t) {
                        console.log("validated!"),
                        "Valid" == t ? (_.setAttribute("data-kt-indicator", "on"),
                        (_.disabled = !0),
                        setTimeout(function () {
                            
                            _.removeAttribute( "data-kt-indicator"),
                                Swal.fire({
                                    text: "Đã cập nhật lịch bảo trì!",
                                    icon: "success",
                                    buttonsStyling: !1,
                                    confirmButtonText:"Chấp nhận!",
                                    customClass: {confirmButton:"btn btn-primary",},
                                }).then(function (t) {
                                    if (t.isConfirmed) {
                                        v.hide(),
                                        (_.disabled =!1),
                                        e.getEventById(x.id).remove();
                                        let t =!1;
                                        r.checked && (t = !0),
                                            0 ===c.selectedDates.length && (t = !0);
                                        var l = moment(i.selectedDates[0]).format(),
                                            s = moment(d.selectedDates[d.selectedDates.length - 1]).format();
                                        if (!t) {
                                            const e = moment(i.selectedDates[0]).format("YYYY-MM-DD"),
                                                t = e;
                                            (l = e + "T" + moment(c.selectedDates[0]).format("HH:mm:ss")),
                                            (s =t +"T" + moment( u.selectedDates[0]).format("HH:mm:ss"));
                                        }
                                        e.addEvent(
                                            {
                                                id: V(),
                                                title: n.value,
                                                description:a.value,
                                                location:o.value,
                                                start: l,
                                                end: s,
                                                allDay: t,
                                            }
                                        ),
                                        e.render(),
                                        p.reset();
                                    }
                                });
                        }, 2e3))
                        : Swal.fire({
                            text: "Đã xảy ra lỗi, vui lòng thử lại sau.",
                            icon: "error",
                            buttonsStyling: !1,
                            confirmButtonText:"Chấp nhận!",
                            customClass: {confirmButton:"btn btn-primary",},
                        });
                    });
                });
            })();
        });
    },
    F = () => {
        document.querySelector("#kt_calendar_event_view_button").addEventListener("click", (e) => {
            e.preventDefault(), C(), A();
        });
    },
    O = () => {
        (n.value = x.eventName ? x.eventName : ""),
        (a.value = x.eventDescription ? x.eventDescription : ""),
        (o.value = x.eventLocation ? x.eventLocation : ""),
        i.setDate(x.startDate, !0, "Y-m-d");
        const e = x.endDate ? x.endDate : moment(x.startDate).format();
        d.setDate(e, !0, "Y-m-d");
        const t = p.querySelector("#kt_calendar_datepicker_allday"),
            r = p.querySelectorAll('[data-kt-calendar="datepicker"]');
        x.allDay ? ((t.checked = !0),
            r.forEach((e) => {
                e.classList.add("d-none");
            }))
            : (c.setDate(x.startDate, !0, "Y-m-d H:i"),
            u.setDate(x.endDate, !0, "Y-m-d H:i"),
            d.setDate(x.startDate, !0, "Y-m-d"),
            (t.checked = !1),
            r.forEach((e) => {
                e.classList.remove("d-none");
            }));
    },
    P = (e) => {
        (x.id = e.id),
        (x.eventName = e.title),
        (x.eventDescription = e.description),
        (x.eventLocation = e.location),
        (x.startDate = e.startStr),
        (x.endDate = e.endStr),
        (x.allDay = e.allDay);
    },
    V = () => Date.now().toString() + Math.floor(1e3 * Math.random()).toString();

    return {
        init: function () {
            const t = document.getElementById("kt_modal_add_event");
            (p = t.querySelector("#kt_modal_add_event_form")),
            (n = p.querySelector('[name="calendar_event_name"]')),
            (a = p.querySelector('[name="calendar_event_description"]')),
            (o = p.querySelector('[name="calendar_event_location"]')),
            (r = p.querySelector("#kt_calendar_datepicker_start_date")),
            (l = p.querySelector("#kt_calendar_datepicker_end_date")),
            (s = p.querySelector("#kt_calendar_datepicker_start_time")),
            (m = p.querySelector("#kt_calendar_datepicker_end_time")),
            (D = document.querySelector('[data-kt-calendar="add"]')),
            (_ = p.querySelector("#kt_modal_add_event_submit")),
            (b = p.querySelector("#kt_modal_add_event_cancel")),
            (k = t.querySelector("#kt_modal_add_event_close")),
            (f = p.querySelector('[data-kt-calendar="title"]')),
            (v = new bootstrap.Modal(t));
            const B = document.getElementById("kt_modal_view_event");
            var F, O, I, R, G, K;
            (w = new bootstrap.Modal(B)),
                (g = B.querySelector('[data-kt-calendar="event_name"]')),
                (S = B.querySelector('[data-kt-calendar="all_day"]')),
                (Y = B.querySelector('[data-kt-calendar="event_description"]')),
                (h = B.querySelector('[data-kt-calendar="event_location"]')),
                (T = B.querySelector('[data-kt-calendar="event_start_date"]')),
                (M = B.querySelector('[data-kt-calendar="event_end_date"]')),
                (E = B.querySelector("#kt_modal_view_event_edit")),
                (L = B.querySelector("#kt_modal_view_event_delete")),
                (F = document.getElementById("kt_calendar_app")),
                (O = moment().startOf("day")),
                (I = O.format("YYYY-MM")),
                (R = O.clone().subtract(1, "day").format("YYYY-MM-DD")),
                (G = O.format("YYYY-MM-DD")),
                (K = O.clone().add(1, "day").format("YYYY-MM-DD")),
                (e = new FullCalendar.Calendar(F, {
                    headerToolbar: {
                        left: "prev,next today",
                        center: "title",
                        right: "dayGridMonth,timeGridWeek,timeGridDay",
                    },
                    initialDate: G,
                    navLinks: !0,
                    selectable: !0,
                    selectMirror: !0,
                    select: function (e) {
                        C(), P(e), N();
                    },
                    eventClick: function (e) {
                        C(),
                        P({
                            id: e.event.id,
                            title: e.event.title,
                            description: e.event.extendedProps.description,
                            location: e.event.extendedProps.location,
                            startStr: e.event.startStr,
                            endStr: e.event.endStr,
                            allDay: e.event.allDay,
                        }),
                        A();
                    },
                    eventMouseEnter: function (e) {
                        P({
                            id: e.event.id,
                            title: e.event.title,
                            description: e.event.extendedProps.description,
                            location: e.event.extendedProps.location,
                            startStr: e.event.startStr,
                            endStr: e.event.endStr,
                            allDay: e.event.allDay,
                        }),
                        q(e.el);
                    },
                    editable: !0,
                    dayMaxEvents: !0,
                    // Data
                    events:$('#kt_toolbar').data('route-get-list'),
                    // [
                    //     {
                    //         id: V(),
                    //         title: "All Day Event",
                    //         start: I + "-01",
                    //         end: I + "-02",
                    //         description:
                    //             "Toto lorem ipsum dolor sit incid idunt ut",
                    //         className: "fc-event-danger fc-event-solid-warning",
                    //         location: "Federation Square",
                    //     },
                    // ]
                    datesSet: function () {
                        C();
                    },
                })).render(),
                // Validator form thêm mới

                (y = FormValidation.formValidation(p, {
                    fields: {
                        calendar_event_name: {
                            validators: {
                                notEmpty: { message: "Trường này không được để trống" },
                            },
                        },
                        calendar_event_location: {
                            validators: {
                                notEmpty: { message: "Trường này không được để trống" },
                            },
                        },
                        calendar_event_start_date: {
                            validators: {
                                notEmpty: { message: "Trường này không được để trống" },
                                compareDate:{message: "Thời gian không đúng"}
                            },
                        },
                        calendar_event_end_date: {
                            validators: {
                                notEmpty: { message: "Trường này không được để trống" },
                                compareDate:{message: "Thời gian không đúng"}

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
                }).registerValidator('compareDate', checkDateEnd)
                ),
                // end validator
                (i = flatpickr(r, { enableTime: !1, dateFormat: "Y-m-d" })),
                (d = flatpickr(l, { enableTime: !1, dateFormat: "Y-m-d" })),
                (c = flatpickr(s, { enableTime: !0, noCalendar: !0, dateFormat: "H:i",})),
                (u = flatpickr(m, { enableTime: !0, noCalendar: !0, dateFormat: "H:i",})),
                H(),
                D.addEventListener("click", (e) => {
                    C(),
                    (x = {
                        id: "",
                        eventName: "",
                        eventDescription: "",
                        startDate: new Date(),
                        endDate: new Date(),
                        allDay: !1,
                    }),
                    N();
                }),
                L.addEventListener("click", (t) => {
                    t.preventDefault(),
                    Swal.fire({
                        text: "Bạn có chắc chắn muốn xóa không?",
                        icon: "warning",
                        showCancelButton: !0,
                        buttonsStyling: !1,
                        confirmButtonText: "Có!",
                        cancelButtonText: "Không",
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: "btn btn-active-light",
                        },
                    }).then(function (t) {
                        t.value ? (e.getEventById(x.id).remove(), w.hide()) : "cancel" === t.dismiss;
                    });
                }),
                b.addEventListener("click", function (e) {
                    e.preventDefault(),
                    Swal.fire({
                        text: "Bạn có chắc chắn muốn hủy không?",
                        icon: "warning",
                        showCancelButton: !0,
                        buttonsStyling: !1,
                        confirmButtonText: "Có!",
                        cancelButtonText: "Không",
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: "btn btn-active-light",
                        },
                    }).then(function (e) {
                        e.value ? (p.reset(), v.hide()) : "cancel" === e.dismiss &&
                        Swal.fire({
                            text: "Biểu mẫu của bạn chưa bị hủy!.",
                            icon: "error",
                            buttonsStyling: !1,
                            confirmButtonText: "Chấp nhận!",
                            customClass: {confirmButton: "btn btn-primary",},
                        });
                    });
                }),
                k.addEventListener("click", function (e) {
                    e.preventDefault(),
                    Swal.fire({
                        text: "Bạn có chắc chắn muốn hủy không?",
                        icon: "warning",
                        showCancelButton: !0,
                        buttonsStyling: !1,
                        confirmButtonText: "Có!",
                        cancelButtonText: "Không",
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: "btn btn-active-light",
                        },
                    }).then(function (e) {
                        e.value ? (p.reset(), v.hide()) : "cancel" === e.dismiss &&
                        Swal.fire({
                            text: "Biểu mẫu của bạn chưa bị hủy!.",
                            icon: "error",
                            buttonsStyling: !1,
                            confirmButtonText: "Chấp nhận!",
                            customClass: { confirmButton: "btn btn-primary",},
                        });
                    });
                }),
                ((e) => {
                    e.addEventListener("hidden.bs.modal", (e) => {
                        y && y.resetForm(!0);
                    });
                })(t);
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTAppCalendar.init();
});
