!function (a) {
    "function" == typeof define && define.amd ? define(["jquery", "moment"], a) : a(jQuery, moment)
}(function (a, b) {
    function c(a) {
        return a > 1 && 5 > a && 1 !== ~~(a / 10)
    }

    function d(a, b, d, e) {
        var f = a + " ";
        switch (d) {
            case"s":
                return b || e ? "pár sekund" : "pár sekundami";
            case"m":
                return b ? "minuta" : e ? "minutu" : "minutou";
            case"mm":
                return b || e ? f + (c(a) ? "minuty" : "minut") : f + "minutami";
            case"h":
                return b ? "hodina" : e ? "hodinu" : "hodinou";
            case"hh":
                return b || e ? f + (c(a) ? "hodiny" : "hodin") : f + "hodinami";
            case"d":
                return b || e ? "den" : "dnem";
            case"dd":
                return b || e ? f + (c(a) ? "dny" : "dní") : f + "dny";
            case"M":
                return b || e ? "měsíc" : "měsícem";
            case"MM":
                return b || e ? f + (c(a) ? "měsíce" : "měsíců") : f + "měsíci";
            case"y":
                return b || e ? "rok" : "rokem";
            case"yy":
                return b || e ? f + (c(a) ? "roky" : "let") : f + "lety"
        }
    }

    var e = "leden_únor_březen_duben_květen_červen_červenec_srpen_září_říjen_listopad_prosinec".split("_"), f = "led_úno_bře_dub_kvě_čvn_čvc_srp_zář_říj_lis_pro".split("_");
    (b.defineLocale || b.lang).call(b, "cs", {
        months: e,
        monthsShort: f,
        monthsParse: function (a, b) {
            var c, d = [];
            for (c = 0; 12 > c; c++)d[c] = new RegExp("^" + a[c] + "$|^" + b[c] + "$", "i");
            return d
        }(e, f),
        weekdays: "neděle_pondělí_úterý_středa_čtvrtek_pátek_sobota".split("_"),
        weekdaysShort: "ne_po_út_st_čt_pá_so".split("_"),
        weekdaysMin: "ne_po_út_st_čt_pá_so".split("_"),
        longDateFormat: {
            LT: "H:mm",
            LTS: "LT:ss",
            L: "DD.MM.YYYY",
            LL: "D. MMMM YYYY",
            LLL: "D. MMMM YYYY LT",
            LLLL: "dddd D. MMMM YYYY LT"
        },
        calendar: {
            sameDay: "[dnes v] LT",
            nextDay: "[zítra v] LT",
            nextWeek: function () {
                switch (this.day()) {
                    case 0:
                        return "[v neděli v] LT";
                    case 1:
                    case 2:
                        return "[v] dddd [v] LT";
                    case 3:
                        return "[ve středu v] LT";
                    case 4:
                        return "[ve čtvrtek v] LT";
                    case 5:
                        return "[v pátek v] LT";
                    case 6:
                        return "[v sobotu v] LT"
                }
            },
            lastDay: "[včera v] LT",
            lastWeek: function () {
                switch (this.day()) {
                    case 0:
                        return "[minulou neděli v] LT";
                    case 1:
                    case 2:
                        return "[minulé] dddd [v] LT";
                    case 3:
                        return "[minulou středu v] LT";
                    case 4:
                    case 5:
                        return "[minulý] dddd [v] LT";
                    case 6:
                        return "[minulou sobotu v] LT"
                }
            },
            sameElse: "L"
        },
        relativeTime: {
            future: "za %s",
            past: "před %s",
            s: d,
            m: d,
            mm: d,
            h: d,
            hh: d,
            d: d,
            dd: d,
            M: d,
            MM: d,
            y: d,
            yy: d
        },
        ordinalParse: /\d{1,2}\./,
        ordinal: "%d.",
        week: {dow: 1, doy: 4}
    }), a.fullCalendar.datepickerLang("cs", "cs", {
        closeText: "Zavřít",
        prevText: "&#x3C;Dříve",
        nextText: "Později&#x3E;",
        currentText: "Nyní",
        monthNames: ["leden", "únor", "březen", "duben", "květen", "červen", "červenec", "srpen", "září", "říjen", "listopad", "prosinec"],
        monthNamesShort: ["led", "úno", "bře", "dub", "kvě", "čer", "čvc", "srp", "zář", "říj", "lis", "pro"],
        dayNames: ["neděle", "pondělí", "úterý", "středa", "čtvrtek", "pátek", "sobota"],
        dayNamesShort: ["ne", "po", "út", "st", "čt", "pá", "so"],
        dayNamesMin: ["ne", "po", "út", "st", "čt", "pá", "so"],
        weekHeader: "Týd",
        dateFormat: "dd.mm.yy",
        firstDay: 1,
        isRTL: !1,
        showMonthAfterYear: !1,
        yearSuffix: ""
    }), a.fullCalendar.lang("cs", {
        buttonText: {
            month: "Měsíc",
            week: "Týden",
            day: "Den",
            list: "Agenda"
        }, allDayText: "Celý den", eventLimitText: function (a) {
            return "+další: " + a
        }
    })
});