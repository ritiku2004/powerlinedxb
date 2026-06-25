/* SmtpJS.com - v3.0.0 - Local Copy */
var Email = {
    send: function (a) {
        return new Promise(function (n, g) {
            a.nocache = Math.random();
            a.Action = "Send";
            var t = JSON.stringify(a);
            Email.ajaxPost("https://smtpjs.com/v3/smtpjs.aspx?", t, function (e) {
                n(e);
            });
        });
    },
    ajaxPost: function (e, n, t) {
        var a = Email.createCORSRequest("POST", e);
        a.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        a.onload = function () {
            var e = a.responseText;
            if (t != null) t(e);
        };
        a.send(n);
    },
    ajax: function (e, n) {
        var t = Email.createCORSRequest("GET", e);
        t.onload = function () {
            var e = t.responseText;
            if (n != null) n(e);
        };
        t.send();
    },
    createCORSRequest: function (e, n) {
        var t = new XMLHttpRequest();
        if ("withCredentials" in t) {
            t.open(e, n, true);
        } else if (typeof XDomainRequest != "undefined") {
            t = new XDomainRequest();
            t.open(e, n);
        } else {
            t = null;
        }
        return t;
    }
};
