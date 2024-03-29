"use strict";
const $ = (e) => document.querySelector(e),
    countdown = function (e) {
        const t = $(e.target).getAttribute("data-date").split("-"),
            r = parseInt(t[0]),
            n = parseInt(t[1]),
            a = parseInt(t[2]);
        let o,
            d,
            i = $(e.target).getAttribute("data-time");
        null != i &&
            ((i = i.split(":")), (o = parseInt(i[0])), (d = parseInt(i[1])));
        new Date().getFullYear();
        let u = new Date();
        u.getDate(),
            u.getMonth(),
            u.getFullYear(),
            u.getHours(),
            u.getMinutes();
        const g = new Date(a, n - 1, r, o, d, 0, 0).getTime();
        ($(e.target + " .day .word").innerHTML = e.dayWord),
            ($(e.target + " .hour .word").innerHTML = e.hourWord),
            ($(e.target + " .min .word").innerHTML = e.minWord),
            ($(e.target + " .sec .word").innerHTML = e.secWord);
        const s = () => {
            const t = new Date().getTime(),
                r = g - t,
                n = Math.floor(r / 864e5),
                a = Math.floor((r % 864e5) / 36e5),
                o = Math.floor((r % 36e5) / 6e4),
                d = Math.floor((r % 6e4) / 1e3);
            requestAnimationFrame(s),
                ($(e.target + " .day .num").innerHTML = addZero(n)),
                ($(e.target + " .hour .num").innerHTML = addZero(a)),
                ($(e.target + " .min .num").innerHTML = addZero(o)),
                ($(e.target + " .sec .num").innerHTML = addZero(d)),
                r < 0 && ($(".countdown").innerHTML = "EXPIRED");
        };
        s();
    },
    addZero = (e) => (e < 10 && e >= 0 ? "0" + e : e);
