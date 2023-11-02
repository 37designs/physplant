/*Copyright (c), 2011 Sanford, L.P. All Rights Reserved.*/
(function () {
    var l, aa = aa || {}, n = this;
    n.Aa = !0;

    function p() {
    }

    function ba(a) {
        var b = typeof a;
        if ("object" == b) if (a) {
            if (a instanceof Array) return "array";
            if (a instanceof Object) return b;
            var d = Object.prototype.toString.call(a);
            if ("[object Window]" == d) return "object";
            if ("[object Array]" == d || "number" == typeof a.length && "undefined" != typeof a.splice && "undefined" != typeof a.propertyIsEnumerable && !a.propertyIsEnumerable("splice")) return "array";
            if ("[object Function]" == d || "undefined" != typeof a.call && "undefined" != typeof a.propertyIsEnumerable && !a.propertyIsEnumerable("call")) return "function"
        } else return "null";
        else if ("function" == b && "undefined" == typeof a.call) return "object";
        return b
    }

    function ca(a) {
        return "array" == ba(a)
    }

    function da(a) {
        var b = ba(a);
        return "array" == b || "object" == b && "number" == typeof a.length
    }

    function q(a) {
        return "string" == typeof a
    }

    function ea(a) {
        return "number" == typeof a
    }

    function t(a) {
        return "function" == ba(a)
    }

    var fa = "closure_uid_" + (1E9 * Math.random() >>> 0), ga = 0;

    function ha(a, b, d) {
        return a.call.apply(a.bind, arguments)
    }

    function ia(a, b, d) {
        if (!a) throw Error();
        if (2 < arguments.length) {
            var e = Array.prototype.slice.call(arguments, 2);
            return function () {
                var d = Array.prototype.slice.call(arguments);
                Array.prototype.unshift.apply(d, e);
                return a.apply(b, d)
            }
        }
        return function () {
            return a.apply(b, arguments)
        }
    }

    function u(a, b, d) {
        u = Function.prototype.bind && -1 != Function.prototype.bind.toString().indexOf("native code") ? ha : ia;
        return u.apply(null, arguments)
    }

    function ja(a, b) {
        var d = Array.prototype.slice.call(arguments, 1);
        return function () {
            var b = d.slice();
            b.push.apply(b, arguments);
            return a.apply(this, b)
        }
    }

    var ka = Date.now || function () {
        return +new Date
    };

    function v(a, b) {
        var d = a.split("."), e = n;
        d[0] in e || !e.execScript || e.execScript("var " + d[0]);
        for (var f; d.length && (f = d.shift());) d.length || void 0 === b ? e[f] ? e = e[f] : e = e[f] = {} : e[f] = b
    }

    function w(a, b) {
        function d() {
        }

        d.prototype = b.prototype;
        a.ca = b.prototype;
        a.prototype = new d;
        a.prototype.constructor = a;
        a.Ba = function (a, d, g) {
            for (var h = Array(arguments.length - 2), k = 2; k < arguments.length; k++) h[k - 2] = arguments[k];
            return b.prototype[d].apply(a, h)
        }
    };

    function y(a) {
        if (Error.captureStackTrace) Error.captureStackTrace(this, y); else {
            var b = Error().stack;
            b && (this.stack = b)
        }
        a && (this.message = String(a))
    }

    w(y, Error);
    y.prototype.name = "CustomError";

    function la(a, b) {
        for (var d = a.split("%s"), e = "", f = Array.prototype.slice.call(arguments, 1); f.length && 1 < d.length;) e += d.shift() + f.shift();
        return e + d.join("%s")
    }

    var ma = String.prototype.trim ? function (a) {
        return a.trim()
    } : function (a) {
        return a.replace(/^[\s\xa0]+|[\s\xa0]+$/g, "")
    };

    function A(a, b) {
        return -1 != a.indexOf(b)
    }

    function na(a) {
        return Array.prototype.join.call(arguments, "")
    }

    function oa(a, b) {
        return a < b ? -1 : a > b ? 1 : 0
    };

    function pa(a, b) {
        b.unshift(a);
        y.call(this, la.apply(null, b));
        b.shift()
    }

    w(pa, y);
    pa.prototype.name = "AssertionError";

    function qa(a, b) {
        throw new pa("Failure" + (a ? ": " + a : ""), Array.prototype.slice.call(arguments, 1));
    };var B = Array.prototype, ra = B.indexOf ? function (a, b, d) {
        return B.indexOf.call(a, b, d)
    } : function (a, b, d) {
        d = null == d ? 0 : 0 > d ? Math.max(0, a.length + d) : d;
        if (q(a)) return q(b) && 1 == b.length ? a.indexOf(b, d) : -1;
        for (; d < a.length; d++) if (d in a && a[d] === b) return d;
        return -1
    }, sa = B.forEach ? function (a, b, d) {
        B.forEach.call(a, b, d)
    } : function (a, b, d) {
        for (var e = a.length, f = q(a) ? a.split("") : a, g = 0; g < e; g++) g in f && b.call(d, f[g], g, a)
    }, ta = B.reduce ? function (a, b, d, e) {
        e && (b = u(b, e));
        return B.reduce.call(a, b, d)
    } : function (a, b, d, e) {
        var f = d;
        sa(a, function (d,
                        h) {
            f = b.call(e, f, d, h, a)
        });
        return f
    }, ua = B.some ? function (a, b, d) {
        return B.some.call(a, b, d)
    } : function (a, b, d) {
        for (var e = a.length, f = q(a) ? a.split("") : a, g = 0; g < e; g++) if (g in f && b.call(d, f[g], g, a)) return !0;
        return !1
    };

    function va(a) {
        var b;
        a:{
            b = wa;
            for (var d = a.length, e = q(a) ? a.split("") : a, f = 0; f < d; f++) if (f in e && b.call(void 0, e[f], f, a)) {
                b = f;
                break a
            }
            b = -1
        }
        return 0 > b ? null : q(a) ? a.charAt(b) : a[b]
    }

    function xa(a, b) {
        var d = ra(a, b), e;
        (e = 0 <= d) && B.splice.call(a, d, 1);
        return e
    }

    function ya(a) {
        return B.concat.apply(B, arguments)
    };var C;
    a:{
        var za = n.navigator;
        if (za) {
            var Ba = za.userAgent;
            if (Ba) {
                C = Ba;
                break a
            }
        }
        C = ""
    }
    ;

    function Ca(a, b) {
        for (var d in a) b.call(void 0, a[d], d, a)
    }

    function Da(a) {
        var b = [], d = 0, e;
        for (e in a) b[d++] = a[e];
        return b
    }

    function Ea(a) {
        var b = [], d = 0, e;
        for (e in a) b[d++] = e;
        return b
    }

    var Fa = "constructor hasOwnProperty isPrototypeOf propertyIsEnumerable toLocaleString toString valueOf".split(" ");

    function Ga(a, b) {
        for (var d, e, f = 1; f < arguments.length; f++) {
            e = arguments[f];
            for (d in e) a[d] = e[d];
            for (var g = 0; g < Fa.length; g++) d = Fa[g], Object.prototype.hasOwnProperty.call(e, d) && (a[d] = e[d])
        }
    }

    function Ha(a) {
        var b = arguments.length;
        if (1 == b && ca(arguments[0])) return Ha.apply(null, arguments[0]);
        for (var d = {}, e = 0; e < b; e++) d[arguments[e]] = !0;
        return d
    };

    function Ia() {
        return A(C, "Edge") || A(C, "Trident") || A(C, "MSIE")
    };

    function D() {
        return A(C, "Edge")
    };var Ja = A(C, "Opera") || A(C, "OPR"), E = Ia(),
        Ka = A(C, "Gecko") && !(A(C.toLowerCase(), "webkit") && !D()) && !(A(C, "Trident") || A(C, "MSIE")) && !D(),
        La = A(C.toLowerCase(), "webkit") && !D();

    function Ma() {
        var a = C;
        if (Ka) return /rv\:([^\);]+)(\)|;)/.exec(a);
        if (E && D()) return /Edge\/([\d\.]+)/.exec(a);
        if (E) return /\b(?:MSIE|rv)[: ]([^\);]+)(\)|;)/.exec(a);
        if (La) return /WebKit\/(\S+)/.exec(a)
    }

    function Na() {
        var a = n.document;
        return a ? a.documentMode : void 0
    }

    var Oa = function () {
        if (Ja && n.opera) {
            var a = n.opera.version;
            return t(a) ? a() : a
        }
        var a = "", b = Ma();
        b && (a = b ? b[1] : "");
        return E && !D() && (b = Na(), b > parseFloat(a)) ? String(b) : a
    }(), Pa = {};

    function F(a) {
        var b;
        if (!(b = Pa[a])) {
            b = 0;
            for (var d = ma(String(Oa)).split("."), e = ma(String(a)).split("."), f = Math.max(d.length, e.length), g = 0; 0 == b && g < f; g++) {
                var h = d[g] || "", k = e[g] || "", m = RegExp("(\\d*)(\\D*)", "g"), r = RegExp("(\\d*)(\\D*)", "g");
                do {
                    var z = m.exec(h) || ["", "", ""], x = r.exec(k) || ["", "", ""];
                    if (0 == z[0].length && 0 == x[0].length) break;
                    b = oa(0 == z[1].length ? 0 : parseInt(z[1], 10), 0 == x[1].length ? 0 : parseInt(x[1], 10)) || oa(0 == z[2].length, 0 == x[2].length) || oa(z[2], x[2])
                } while (0 == b)
            }
            b = Pa[a] = 0 <= b
        }
        return b
    }

    var Qa = n.document, Ra = Na(),
        Sa = !Qa || !E || !Ra && D() ? void 0 : Ra || ("CSS1Compat" == Qa.compatMode ? parseInt(Oa, 10) : 5);
    !Ka && !E || E && E && (D() || 9 <= Sa) || Ka && F("1.9.1");
    E && F("9");
    Ha("area base br col command embed hr img input keygen link meta param source track wbr".split(" "));

    function Ta() {
        this.c = "";
        this.f = null
    }

    Ta.prototype.toString = function () {
        return "SafeHtml{" + this.c + "}"
    };

    function Ua(a) {
        var b = new Ta;
        b.c = a;
        b.f = 0
    }

    Ua("<!DOCTYPE html>");
    Ua("");

    function Va(a, b) {
        Ca(b, function (b, e) {
            "style" == e ? a.style.cssText = b : "class" == e ? a.className = b : "for" == e ? a.htmlFor = b : e in Wa ? a.setAttribute(Wa[e], b) : 0 == e.lastIndexOf("aria-", 0) || 0 == e.lastIndexOf("data-", 0) ? a.setAttribute(e, b) : a[e] = b
        })
    }

    var Wa = {
        cellpadding: "cellPadding",
        cellspacing: "cellSpacing",
        colspan: "colSpan",
        frameborder: "frameBorder",
        height: "height",
        maxlength: "maxLength",
        role: "role",
        rowspan: "rowSpan",
        type: "type",
        usemap: "useMap",
        valign: "vAlign",
        width: "width"
    };

    function Xa(a, b) {
        var d = [];
        Ya(a, b, d, !1);
        return d
    }

    function Ya(a, b, d, e) {
        if (null != a) for (a = a.firstChild; a;) {
            if (b(a) && (d.push(a), e) || Ya(a, b, d, e)) return !0;
            a = a.nextSibling
        }
        return !1
    }

    var Za = {SCRIPT: 1, STYLE: 1, HEAD: 1, IFRAME: 1, OBJECT: 1}, $a = {IMG: " ", BR: "\n"};

    function ab(a, b, d) {
        if (!(a.nodeName in Za)) if (3 == a.nodeType) d ? b.push(String(a.nodeValue).replace(/(\r\n|\r|\n)/g, "")) : b.push(a.nodeValue); else if (a.nodeName in $a) b.push($a[a.nodeName]); else for (a = a.firstChild; a;) ab(a, b, d), a = a.nextSibling
    };

    function bb(a) {
        a.prototype.then = a.prototype.then;
        a.prototype.$goog_Thenable = !0
    }

    function cb(a) {
        if (!a) return !1;
        try {
            return !!a.$goog_Thenable
        } catch (b) {
            return !1
        }
    };

    function db(a, b) {
        this.h = a;
        this.i = b;
        this.f = 0;
        this.c = null
    }

    function eb(a) {
        var b;
        0 < a.f ? (a.f--, b = a.c, a.c = b.next, b.next = null) : b = a.h();
        return b
    }

    function fb(a, b) {
        a.i(b);
        100 > a.f && (a.f++, b.next = a.c, a.c = b)
    };var hb = new db(function () {
        return new gb
    }, function (a) {
        a.reset()
    });

    function ib() {
        var a = jb, b = null;
        a.c && (b = a.c, a.c = a.c.next, a.c || (a.f = null), b.next = null);
        return b
    }

    function gb() {
        this.next = this.f = this.c = null
    }

    gb.prototype.reset = function () {
        this.next = this.f = this.c = null
    };

    function kb(a) {
        n.setTimeout(function () {
            throw a;
        }, 0)
    }

    var lb;

    function mb() {
        var a = n.MessageChannel;
        "undefined" === typeof a && "undefined" !== typeof window && window.postMessage && window.addEventListener && !A(C, "Presto") && (a = function () {
            var a = document.createElement("IFRAME");
            a.style.display = "none";
            a.src = "";
            document.documentElement.appendChild(a);
            var b = a.contentWindow, a = b.document;
            a.open();
            a.write("");
            a.close();
            var d = "callImmediate" + Math.random(),
                e = "file:" == b.location.protocol ? "*" : b.location.protocol + "//" + b.location.host,
                a = u(function (a) {
                    if (("*" == e || a.origin == e) && a.data ==
                        d) this.port1.onmessage()
                }, this);
            b.addEventListener("message", a, !1);
            this.port1 = {};
            this.port2 = {
                postMessage: function () {
                    b.postMessage(d, e)
                }
            }
        });
        if ("undefined" !== typeof a && !Ia()) {
            var b = new a, d = {}, e = d;
            b.port1.onmessage = function () {
                if (void 0 !== d.next) {
                    d = d.next;
                    var a = d.ea;
                    d.ea = null;
                    a()
                }
            };
            return function (a) {
                e.next = {ea: a};
                e = e.next;
                b.port2.postMessage(0)
            }
        }
        return "undefined" !== typeof document && "onreadystatechange" in document.createElement("SCRIPT") ? function (a) {
            var b = document.createElement("SCRIPT");
            b.onreadystatechange =
                function () {
                    b.onreadystatechange = null;
                    b.parentNode.removeChild(b);
                    b = null;
                    a();
                    a = null
                };
            document.documentElement.appendChild(b)
        } : function (a) {
            n.setTimeout(a, 0)
        }
    };

    function nb(a, b) {
        ob || pb();
        qb || (ob(), qb = !0);
        var d = jb, e = eb(hb);
        e.c = a;
        e.f = b;
        e.next = null;
        d.f ? d.f.next = e : d.c = e;
        d.f = e
    }

    var ob;

    function pb() {
        if (n.Promise && n.Promise.resolve) {
            var a = n.Promise.resolve();
            ob = function () {
                a.then(rb)
            }
        } else ob = function () {
            var a = rb;
            !t(n.setImmediate) || n.Window && n.Window.prototype && n.Window.prototype.setImmediate == n.setImmediate ? (lb || (lb = mb()), lb(a)) : n.setImmediate(a)
        }
    }

    var qb = !1, jb = new function () {
        this.f = this.c = null
    };

    function rb() {
        for (var a = null; a = ib();) {
            try {
                a.c.call(a.f)
            } catch (b) {
                kb(b)
            }
            fb(hb, a)
        }
        qb = !1
    };

    function G(a, b) {
        this.c = H;
        this.o = void 0;
        this.i = this.f = this.h = null;
        this.l = this.m = !1;
        if (a == sb) tb(this, ub, b); else try {
            var d = this;
            a.call(b, function (a) {
                tb(d, ub, a)
            }, function (a) {
                if (!(a instanceof vb)) try {
                    if (a instanceof Error) throw a;
                    throw Error("Promise rejected.");
                } catch (b) {
                }
                tb(d, I, a)
            })
        } catch (e) {
            tb(this, I, e)
        }
    }

    var H = 0, ub = 2, I = 3;

    function wb() {
        this.next = this.h = this.f = this.i = this.c = null;
        this.l = !1
    }

    wb.prototype.reset = function () {
        this.h = this.f = this.i = this.c = null;
        this.l = !1
    };
    var xb = new db(function () {
        return new wb
    }, function (a) {
        a.reset()
    });

    function yb(a, b, d) {
        var e = eb(xb);
        e.i = a;
        e.f = b;
        e.h = d;
        return e
    }

    function sb() {
    }

    function zb(a) {
        return new G(function (b, d) {
            var e = a.length, f = [];
            if (e) for (var g = function (a, d) {
                e--;
                f[a] = d;
                0 == e && b(f)
            }, h = function (a) {
                d(a)
            }, k = 0, m; m = a[k]; k++) Ab(m, ja(g, k), h); else b(f)
        })
    }

    G.prototype.then = function (a, b, d) {
        return Bb(this, t(a) ? a : null, t(b) ? b : null, d)
    };
    bb(G);

    function Ab(a, b, d, e) {
        a instanceof G ? Cb(a, yb(b || p, d || null, e)) : a.then(b, d, e)
    }

    l = G.prototype;
    l.ja = function (a, b) {
        return Bb(this, null, a, b)
    };
    l.cancel = function (a) {
        this.c == H && nb(function () {
            var b = new vb(a);
            Db(this, b)
        }, this)
    };

    function Db(a, b) {
        if (a.c == H) if (a.h) {
            var d = a.h;
            if (d.f) {
                for (var e = 0, f = null, g = null, h = d.f; h && (h.l || (e++, h.c == a && (f = h), !(f && 1 < e))); h = h.next) f || (g = h);
                f && (d.c == H && 1 == e ? Db(d, b) : (g ? (e = g, e.next == d.i && (d.i = e), e.next = e.next.next) : Eb(d), Fb(d, f, I, b)))
            }
            a.h = null
        } else tb(a, I, b)
    }

    function Cb(a, b) {
        a.f || a.c != ub && a.c != I || Gb(a);
        a.i ? a.i.next = b : a.f = b;
        a.i = b
    }

    function Bb(a, b, d, e) {
        var f = yb(null, null, null);
        f.c = new G(function (a, h) {
            f.i = b ? function (d) {
                try {
                    var f = b.call(e, d);
                    a(f)
                } catch (r) {
                    h(r)
                }
            } : a;
            f.f = d ? function (b) {
                try {
                    var f = d.call(e, b);
                    void 0 === f && b instanceof vb ? h(b) : a(f)
                } catch (r) {
                    h(r)
                }
            } : h
        });
        f.c.h = a;
        Cb(a, f);
        return f.c
    }

    l.ka = function (a) {
        this.c = H;
        tb(this, ub, a)
    };
    l.la = function (a) {
        this.c = H;
        tb(this, I, a)
    };

    function tb(a, b, d) {
        if (a.c == H) {
            if (a == d) b = I, d = new TypeError("Promise cannot resolve to itself"); else {
                if (cb(d)) {
                    a.c = 1;
                    Ab(d, a.ka, a.la, a);
                    return
                }
                var e = typeof d;
                if ("object" == e && null != d || "function" == e) try {
                    var f = d.then;
                    if (t(f)) {
                        Hb(a, d, f);
                        return
                    }
                } catch (g) {
                    b = I, d = g
                }
            }
            a.o = d;
            a.c = b;
            a.h = null;
            Gb(a);
            b != I || d instanceof vb || Ib(a, d)
        }
    }

    function Hb(a, b, d) {
        function e(b) {
            g || (g = !0, a.la(b))
        }

        function f(b) {
            g || (g = !0, a.ka(b))
        }

        a.c = 1;
        var g = !1;
        try {
            d.call(b, f, e)
        } catch (h) {
            e(h)
        }
    }

    function Gb(a) {
        a.m || (a.m = !0, nb(a.ya, a))
    }

    function Eb(a) {
        var b = null;
        a.f && (b = a.f, a.f = b.next, b.next = null);
        a.f || (a.i = null);
        return b
    }

    l.ya = function () {
        for (var a = null; a = Eb(this);) Fb(this, a, this.c, this.o);
        this.m = !1
    };

    function Fb(a, b, d, e) {
        if (d == I && b.f && !b.l) for (; a && a.l; a = a.h) a.l = !1;
        if (b.c) b.c.h = null, Jb(b, d, e); else try {
            b.l ? b.i.call(b.h) : Jb(b, d, e)
        } catch (f) {
            Kb.call(null, f)
        }
        fb(xb, b)
    }

    function Jb(a, b, d) {
        b == ub ? a.i.call(a.h, d) : a.f && a.f.call(a.h, d)
    }

    function Ib(a, b) {
        a.l = !0;
        nb(function () {
            a.l && Kb.call(null, b)
        })
    }

    var Kb = kb;

    function vb(a) {
        y.call(this, a)
    }

    w(vb, y);
    vb.prototype.name = "cancel";

    function Lb() {
        0 != Mb && (Nb[this[fa] || (this[fa] = ++ga)] = this);
        this.l = this.l;
        this.A = this.A
    }

    var Mb = 0, Nb = {};
    Lb.prototype.l = !1;

    function Ob(a) {
        a.l || (a.l = !0, a.K(), 0 != Mb && (a = a[fa] || (a[fa] = ++ga), delete Nb[a]))
    }

    Lb.prototype.K = function () {
        if (this.A) for (; this.A.length;) this.A.shift()()
    };
    var Pb = !E || E && (D() || 9 <= Sa), Qb = E && !F("9");
    !La || F("528");
    Ka && F("1.9b") || E && F("8") || Ja && F("9.5") || La && F("528");
    Ka && !F("8") || E && F("9");

    function Rb(a, b) {
        this.type = a;
        this.c = this.target = b;
        this.ha = !0
    }

    Rb.prototype.f = function () {
        this.ha = !1
    };

    function Sb(a) {
        Sb[" "](a);
        return a
    }

    Sb[" "] = p;

    function Tb(a, b) {
        Rb.call(this, a ? a.type : "");
        this.h = this.state = this.c = this.target = null;
        if (a) {
            this.type = a.type;
            this.target = a.target || a.srcElement;
            this.c = b;
            var d = a.relatedTarget;
            if (d && Ka) try {
                Sb(d.nodeName)
            } catch (e) {
            }
            this.state = a.state;
            this.h = a;
            a.defaultPrevented && this.f()
        }
    }

    w(Tb, Rb);
    Tb.prototype.f = function () {
        Tb.ca.f.call(this);
        var a = this.h;
        if (a.preventDefault) a.preventDefault(); else if (a.returnValue = !1, Qb) try {
            if (a.ctrlKey || 112 <= a.keyCode && 123 >= a.keyCode) a.keyCode = -1
        } catch (b) {
        }
    };
    var Ub = "closure_listenable_" + (1E6 * Math.random() | 0), Vb = 0;

    function Wb(a, b, d, e, f) {
        this.listener = a;
        this.c = null;
        this.src = b;
        this.type = d;
        this.aa = !!e;
        this.ba = f;
        ++Vb;
        this.N = this.$ = !1
    }

    function Xb(a) {
        a.N = !0;
        a.listener = null;
        a.c = null;
        a.src = null;
        a.ba = null
    };

    function Yb(a) {
        this.src = a;
        this.c = {};
        this.f = 0
    }

    function Zb(a, b, d, e, f, g) {
        var h = b.toString();
        b = a.c[h];
        b || (b = a.c[h] = [], a.f++);
        var k = $b(b, d, f, g);
        -1 < k ? (a = b[k], e || (a.$ = !1)) : (a = new Wb(d, a.src, h, !!f, g), a.$ = e, b.push(a));
        return a
    }

    function ac(a, b) {
        var d = b.type;
        d in a.c && xa(a.c[d], b) && (Xb(b), 0 == a.c[d].length && (delete a.c[d], a.f--))
    }

    function $b(a, b, d, e) {
        for (var f = 0; f < a.length; ++f) {
            var g = a[f];
            if (!g.N && g.listener == b && g.aa == !!d && g.ba == e) return f
        }
        return -1
    };var bc = "closure_lm_" + (1E6 * Math.random() | 0), cc = {}, dc = 0;

    function ec(a, b, d, e, f) {
        if (ca(b)) for (var g = 0; g < b.length; g++) ec(a, b[g], d, e, f); else if (d = fc(d), a && a[Ub]) Zb(a.D, String(b), d, !1, e, f); else {
            if (!b) throw Error("Invalid event type");
            var g = !!e, h = gc(a);
            h || (a[bc] = h = new Yb(a));
            d = Zb(h, b, d, !1, e, f);
            if (!d.c) {
                e = hc();
                d.c = e;
                e.src = a;
                e.listener = d;
                if (a.addEventListener) a.addEventListener(b.toString(), e, g); else if (a.attachEvent) a.attachEvent(ic(b.toString()), e); else throw Error("addEventListener and attachEvent are unavailable.");
                dc++
            }
        }
    }

    function hc() {
        var a = jc, b = Pb ? function (d) {
            return a.call(b.src, b.listener, d)
        } : function (d) {
            d = a.call(b.src, b.listener, d);
            if (!d) return d
        };
        return b
    }

    function kc(a, b, d, e, f) {
        if (ca(b)) for (var g = 0; g < b.length; g++) kc(a, b[g], d, e, f); else (d = fc(d), a && a[Ub]) ? (a = a.D, b = String(b).toString(), b in a.c && (g = a.c[b], d = $b(g, d, e, f), -1 < d && (Xb(g[d]), B.splice.call(g, d, 1), 0 == g.length && (delete a.c[b], a.f--)))) : a && (a = gc(a)) && (b = a.c[b.toString()], a = -1, b && (a = $b(b, d, !!e, f)), (d = -1 < a ? b[a] : null) && lc(d))
    }

    function lc(a) {
        if (!ea(a) && a && !a.N) {
            var b = a.src;
            if (b && b[Ub]) ac(b.D, a); else {
                var d = a.type, e = a.c;
                b.removeEventListener ? b.removeEventListener(d, e, a.aa) : b.detachEvent && b.detachEvent(ic(d), e);
                dc--;
                (d = gc(b)) ? (ac(d, a), 0 == d.f && (d.src = null, b[bc] = null)) : Xb(a)
            }
        }
    }

    function ic(a) {
        return a in cc ? cc[a] : cc[a] = "on" + a
    }

    function mc(a, b, d, e) {
        var f = !0;
        if (a = gc(a)) if (b = a.c[b.toString()]) for (b = b.concat(), a = 0; a < b.length; a++) {
            var g = b[a];
            g && g.aa == d && !g.N && (g = nc(g, e), f = f && !1 !== g)
        }
        return f
    }

    function nc(a, b) {
        var d = a.listener, e = a.ba || a.src;
        a.$ && lc(a);
        return d.call(e, b)
    }

    function jc(a, b) {
        if (a.N) return !0;
        if (!Pb) {
            var d;
            if (!(d = b)) a:{
                d = ["window", "event"];
                for (var e = n, f; f = d.shift();) if (null != e[f]) e = e[f]; else {
                    d = null;
                    break a
                }
                d = e
            }
            f = d;
            d = new Tb(f, this);
            e = !0;
            if (!(0 > f.keyCode || void 0 != f.returnValue)) {
                a:{
                    var g = !1;
                    if (0 == f.keyCode) try {
                        f.keyCode = -1;
                        break a
                    } catch (h) {
                        g = !0
                    }
                    if (g || void 0 == f.returnValue) f.returnValue = !0
                }
                f = [];
                for (g = d.c; g; g = g.parentNode) f.push(g);
                for (var g = a.type, k = f.length - 1; 0 <= k; k--) {
                    d.c = f[k];
                    var m = mc(f[k], g, !0, d), e = e && m
                }
                for (k = 0; k < f.length; k++) d.c = f[k], m = mc(f[k], g, !1, d),
                    e = e && m
            }
            return e
        }
        return nc(a, new Tb(b, this))
    }

    function gc(a) {
        a = a[bc];
        return a instanceof Yb ? a : null
    }

    var oc = "__closure_events_fn_" + (1E9 * Math.random() >>> 0);

    function fc(a) {
        if (t(a)) return a;
        a[oc] || (a[oc] = function (b) {
            return a.handleEvent(b)
        });
        return a[oc]
    };

    function J() {
        Lb.call(this);
        this.D = new Yb(this);
        this.na = this;
        this.R = null
    }

    w(J, Lb);
    J.prototype[Ub] = !0;
    J.prototype.addEventListener = function (a, b, d, e) {
        ec(this, a, b, d, e)
    };
    J.prototype.removeEventListener = function (a, b, d, e) {
        kc(this, a, b, d, e)
    };

    function K(a, b) {
        var d, e = a.R;
        if (e) for (d = []; e; e = e.R) d.push(e);
        var e = a.na, f = b, g = f.type || f;
        if (q(f)) f = new Rb(f, e); else if (f instanceof Rb) f.target = f.target || e; else {
            var h = f, f = new Rb(g, e);
            Ga(f, h)
        }
        var h = !0, k;
        if (d) for (var m = d.length - 1; 0 <= m; m--) k = f.c = d[m], h = pc(k, g, !0, f) && h;
        k = f.c = e;
        h = pc(k, g, !0, f) && h;
        h = pc(k, g, !1, f) && h;
        if (d) for (m = 0; m < d.length; m++) k = f.c = d[m], h = pc(k, g, !1, f) && h
    }

    J.prototype.K = function () {
        J.ca.K.call(this);
        if (this.D) {
            var a = this.D, b = 0, d;
            for (d in a.c) {
                for (var e = a.c[d], f = 0; f < e.length; f++) ++b, Xb(e[f]);
                delete a.c[d];
                a.f--
            }
        }
        this.R = null
    };

    function pc(a, b, d, e) {
        b = a.D.c[String(b)];
        if (!b) return !0;
        b = b.concat();
        for (var f = !0, g = 0; g < b.length; ++g) {
            var h = b[g];
            if (h && !h.N && h.aa == d) {
                var k = h.listener, m = h.ba || h.src;
                h.$ && ac(a.D, h);
                f = !1 !== k.call(m, e) && f
            }
        }
        return f && 0 != e.ha
    };

    function qc(a, b, d) {
        if (t(a)) d && (a = u(a, d)); else if (a && "function" == typeof a.handleEvent) a = u(a.handleEvent, a); else throw Error("Invalid listener argument");
        return 2147483647 < b ? -1 : n.setTimeout(a, b || 0)
    };

    function rc(a) {
        var b = [];
        sc(new tc, a, b);
        return b.join("")
    }

    function tc() {
    }

    function sc(a, b, d) {
        if (null == b) d.push("null"); else {
            if ("object" == typeof b) {
                if (ca(b)) {
                    var e = b;
                    b = e.length;
                    d.push("[");
                    for (var f = "", g = 0; g < b; g++) d.push(f), sc(a, e[g], d), f = ",";
                    d.push("]");
                    return
                }
                if (b instanceof String || b instanceof Number || b instanceof Boolean) b = b.valueOf(); else {
                    d.push("{");
                    f = "";
                    for (e in b) Object.prototype.hasOwnProperty.call(b, e) && (g = b[e], "function" != typeof g && (d.push(f), uc(e, d), d.push(":"), sc(a, g, d), f = ","));
                    d.push("}");
                    return
                }
            }
            switch (typeof b) {
                case "string":
                    uc(b, d);
                    break;
                case "number":
                    d.push(isFinite(b) &&
                    !isNaN(b) ? b : "null");
                    break;
                case "boolean":
                    d.push(b);
                    break;
                case "function":
                    break;
                default:
                    throw Error("Unknown type: " + typeof b);
            }
        }
    }

    var vc = {
        '"': '\\"',
        "\\": "\\\\",
        "/": "\\/",
        "\b": "\\b",
        "\f": "\\f",
        "\n": "\\n",
        "\r": "\\r",
        "\t": "\\t",
        "\x0B": "\\u000b"
    }, wc = /\uffff/.test("\uffff") ? /[\\\"\x00-\x1f\x7f-\uffff]/g : /[\\\"\x00-\x1f\x7f-\xff]/g;

    function uc(a, b) {
        b.push('"', a.replace(wc, function (a) {
            var b = vc[a];
            b || (b = "\\u" + (a.charCodeAt(0) | 65536).toString(16).substr(1), vc[a] = b);
            return b
        }), '"')
    };

    function xc(a) {
        if ("function" == typeof a.J) return a.J();
        if (q(a)) return a.split("");
        if (da(a)) {
            for (var b = [], d = a.length, e = 0; e < d; e++) b.push(a[e]);
            return b
        }
        return Da(a)
    }

    function yc(a, b) {
        if ("function" == typeof a.forEach) a.forEach(b, void 0); else if (da(a) || q(a)) sa(a, b, void 0); else {
            var d;
            if ("function" == typeof a.I) d = a.I(); else if ("function" != typeof a.J) if (da(a) || q(a)) {
                d = [];
                for (var e = a.length, f = 0; f < e; f++) d.push(f)
            } else d = Ea(a); else d = void 0;
            for (var e = xc(a), f = e.length, g = 0; g < f; g++) b.call(void 0, e[g], d && d[g], a)
        }
    };

    function zc(a, b) {
        this.f = {};
        this.c = [];
        this.i = this.h = 0;
        var d = arguments.length;
        if (1 < d) {
            if (d % 2) throw Error("Uneven number of arguments");
            for (var e = 0; e < d; e += 2) Ac(this, arguments[e], arguments[e + 1])
        } else if (a) {
            a instanceof zc ? (d = a.I(), e = a.J()) : (d = Ea(a), e = Da(a));
            for (var f = 0; f < d.length; f++) Ac(this, d[f], e[f])
        }
    }

    l = zc.prototype;
    l.J = function () {
        Bc(this);
        for (var a = [], b = 0; b < this.c.length; b++) a.push(this.f[this.c[b]]);
        return a
    };
    l.I = function () {
        Bc(this);
        return this.c.concat()
    };
    l.clear = function () {
        this.f = {};
        this.i = this.h = this.c.length = 0
    };

    function Bc(a) {
        if (a.h != a.c.length) {
            for (var b = 0, d = 0; b < a.c.length;) {
                var e = a.c[b];
                Cc(a.f, e) && (a.c[d++] = e);
                b++
            }
            a.c.length = d
        }
        if (a.h != a.c.length) {
            for (var f = {}, d = b = 0; b < a.c.length;) e = a.c[b], Cc(f, e) || (a.c[d++] = e, f[e] = 1), b++;
            a.c.length = d
        }
    }

    function Dc(a, b) {
        return Cc(a.f, b) ? a.f[b] : void 0
    }

    function Ac(a, b, d) {
        Cc(a.f, b) || (a.h++, a.c.push(b), a.i++);
        a.f[b] = d
    }

    l.forEach = function (a, b) {
        for (var d = this.I(), e = 0; e < d.length; e++) {
            var f = d[e];
            a.call(b, Dc(this, f), f, this)
        }
    };
    l.clone = function () {
        return new zc(this)
    };

    function Cc(a, b) {
        return Object.prototype.hasOwnProperty.call(a, b)
    };

    function Ec(a, b, d, e, f) {
        this.reset(a, b, d, e, f)
    }

    Ec.prototype.c = null;
    var Fc = 0;
    Ec.prototype.reset = function (a, b, d, e, f) {
        "number" == typeof f || Fc++;
        e || ka();
        this.f = b;
        delete this.c
    };

    function Gc(a) {
        this.i = a;
        this.h = this.c = this.f = null
    }

    function Hc(a, b) {
        this.name = a;
        this.value = b
    }

    Hc.prototype.toString = function () {
        return this.name
    };
    var Ic = new Hc("SEVERE", 1E3), Jc = new Hc("WARNING", 900), Kc = new Hc("INFO", 800), Lc = new Hc("CONFIG", 700),
        Mc = new Hc("FINE", 500);

    function Nc(a) {
        if (a.c) return a.c;
        if (a.f) return Nc(a.f);
        qa("Root logger has no level set.");
        return null
    }

    Gc.prototype.log = function (a, b, d) {
        if (a.value >= Nc(this).value) for (t(b) && (b = b()), a = new Ec(a, String(b), this.i), d && (a.c = d), d = "log:" + a.f, n.console && (n.console.timeStamp ? n.console.timeStamp(d) : n.console.markTimeline && n.console.markTimeline(d)), n.msWriteProfilerMark && n.msWriteProfilerMark(d), d = this; d;) d = d.f
    };
    var Oc = {}, Pc = null;

    function Qc(a) {
        Pc || (Pc = new Gc(""), Oc[""] = Pc, Pc.c = Lc);
        var b;
        if (!(b = Oc[a])) {
            b = new Gc(a);
            var d = a.lastIndexOf("."), e = a.substr(d + 1), d = Qc(a.substr(0, d));
            d.h || (d.h = {});
            d.h[e] = b;
            b.f = d;
            Oc[a] = b
        }
        return b
    };

    function L(a, b) {
        a && a.log(Mc, b, void 0)
    };

    function Rc() {
    }

    Rc.prototype.c = null;

    function Sc(a) {
        var b;
        (b = a.c) || (b = {}, Tc(a) && (b[0] = !0, b[1] = !0), b = a.c = b);
        return b
    };var Uc;

    function Vc() {
    }

    w(Vc, Rc);

    function Wc(a) {
        return (a = Tc(a)) ? new ActiveXObject(a) : new XMLHttpRequest
    }

    function Tc(a) {
        if (!a.f && "undefined" == typeof XMLHttpRequest && "undefined" != typeof ActiveXObject) {
            for (var b = ["MSXML2.XMLHTTP.6.0", "MSXML2.XMLHTTP.3.0", "MSXML2.XMLHTTP", "Microsoft.XMLHTTP"], d = 0; d < b.length; d++) {
                var e = b[d];
                try {
                    return new ActiveXObject(e), a.f = e
                } catch (f) {
                }
            }
            throw Error("Could not create ActiveXObject. ActiveX might be disabled, or MSXML might not be installed");
        }
        return a.f
    }

    Uc = new Vc;
    var Xc = /^(?:([^:/?#.]+):)?(?:\/\/(?:([^/?#]*)@)?([^/#?]*?)(?::([0-9]+))?(?=[/#?]|$))?([^?#]+)?(?:\?([^#]*))?(?:#(.*))?$/;

    function Yc(a) {
        if (Zc) {
            Zc = !1;
            var b = n.location;
            if (b) {
                var d = b.href;
                if (d && (d = (d = Yc(d)[3] || null) ? decodeURI(d) : d) && d != b.hostname) throw Zc = !0, Error();
            }
        }
        return a.match(Xc)
    }

    var Zc = La;

    function $c(a, b) {
        for (var d = a.split("&"), e = 0; e < d.length; e++) {
            var f = d[e].indexOf("="), g = null, h = null;
            0 <= f ? (g = d[e].substring(0, f), h = d[e].substring(f + 1)) : g = d[e];
            b(g, h ? decodeURIComponent(h.replace(/\+/g, " ")) : "")
        }
    }

    function ad(a) {
        var b = "getPrinters";
        if (0 <= a.indexOf("#") || 0 <= a.indexOf("?")) throw Error("goog.uri.utils: Fragment or query identifiers are not supported: [" + a + "]");
        var d = a.length - 1;
        0 <= d && a.indexOf("/", d) == d && (a = a.substr(0, a.length - 1));
        0 == b.lastIndexOf("/", 0) && (b = b.substr(1));
        return na(a, "/", b)
    };

    function bd(a) {
        J.call(this);
        this.qa = new zc;
        this.M = a || null;
        this.f = !1;
        this.H = this.c = null;
        this.m = this.Z = this.o = "";
        this.h = this.P = this.s = this.O = !1;
        this.i = 0;
        this.G = null;
        this.F = cd;
        this.B = this.ra = !1
    }

    w(bd, J);
    var cd = "", dd = bd.prototype, ed = Qc("goog.net.XhrIo");
    dd.v = ed;
    var fd = /^https?$/i, gd = ["POST", "PUT"], hd = [];

    function id(a, b, d, e) {
        var f = new bd;
        hd.push(f);
        b && Zb(f.D, "complete", b, !1, void 0, void 0);
        Zb(f.D, "ready", f.wa, !0, void 0, void 0);
        f.i = Math.max(0, 3E3);
        f.send(a, d, e, void 0)
    }

    l = bd.prototype;
    l.wa = function () {
        Ob(this);
        xa(hd, this)
    };
    l.send = function (a, b, d, e) {
        if (this.c) throw Error("[goog.net.XhrIo] Object is active with another request=" + this.o + "; newUri=" + a);
        b = b ? b.toUpperCase() : "GET";
        this.o = a;
        this.m = "";
        this.Z = b;
        this.O = !1;
        this.f = !0;
        this.c = this.M ? Wc(this.M) : Wc(Uc);
        this.H = this.M ? Sc(this.M) : Sc(Uc);
        this.c.onreadystatechange = u(this.ga, this);
        try {
            L(this.v, M(this, "Opening Xhr")), this.P = !0, this.c.open(b, String(a), !0), this.P = !1
        } catch (f) {
            L(this.v, M(this, "Error opening Xhr: " + f.message));
            jd(this, f);
            return
        }
        a = d || "";
        var g = this.qa.clone();
        e &&
        yc(e, function (a, b) {
            Ac(g, b, a)
        });
        e = va(g.I());
        d = n.FormData && a instanceof n.FormData;
        !(0 <= ra(gd, b)) || e || d || Ac(g, "Content-Type", "application/x-www-form-urlencoded;charset=utf-8");
        g.forEach(function (a, b) {
            this.c.setRequestHeader(b, a)
        }, this);
        this.F && (this.c.responseType = this.F);
        "withCredentials" in this.c && (this.c.withCredentials = this.ra);
        try {
            kd(this), 0 < this.i && (this.B = ld(this.c), L(this.v, M(this, "Will abort after " + this.i + "ms if incomplete, xhr2 " + this.B)), this.B ? (this.c.timeout = this.i, this.c.ontimeout = u(this.L,
                this)) : this.G = qc(this.L, this.i, this)), L(this.v, M(this, "Sending request")), this.s = !0, this.c.send(a), this.s = !1
        } catch (h) {
            L(this.v, M(this, "Send error: " + h.message)), jd(this, h)
        }
    };

    function ld(a) {
        return E && F(9) && ea(a.timeout) && void 0 !== a.ontimeout
    }

    function wa(a) {
        return "content-type" == a.toLowerCase()
    }

    l.L = function () {
        "undefined" != typeof aa && this.c && (this.m = "Timed out after " + this.i + "ms, aborting", L(this.v, M(this, this.m)), K(this, "timeout"), this.c && this.f && (L(this.v, M(this, "Aborting")), this.f = !1, this.h = !0, this.c.abort(), this.h = !1, K(this, "complete"), K(this, "abort"), md(this)))
    };

    function jd(a, b) {
        a.f = !1;
        a.c && (a.h = !0, a.c.abort(), a.h = !1);
        a.m = b;
        nd(a);
        md(a)
    }

    function nd(a) {
        a.O || (a.O = !0, K(a, "complete"), K(a, "error"))
    }

    l.K = function () {
        this.c && (this.f && (this.f = !1, this.h = !0, this.c.abort(), this.h = !1), md(this, !0));
        bd.ca.K.call(this)
    };
    l.ga = function () {
        this.l || (this.P || this.s || this.h ? od(this) : this.za())
    };
    l.za = function () {
        od(this)
    };

    function od(a) {
        if (a.f && "undefined" != typeof aa) if (a.H[1] && 4 == pd(a) && 2 == a.w()) L(a.v, M(a, "Local request error detected and ignored")); else if (a.s && 4 == pd(a)) qc(a.ga, 0, a); else if (K(a, "readystatechange"), 4 == pd(a)) {
            L(a.v, M(a, "Request complete"));
            a.f = !1;
            try {
                if (qd(a)) K(a, "complete"), K(a, "success"); else {
                    var b;
                    try {
                        b = 2 < pd(a) ? a.c.statusText : ""
                    } catch (d) {
                        L(a.v, "Can not get status: " + d.message), b = ""
                    }
                    a.m = b + " [" + a.w() + "]";
                    nd(a)
                }
            } finally {
                md(a)
            }
        }
    }

    function md(a, b) {
        if (a.c) {
            kd(a);
            var d = a.c, e = a.H[0] ? p : null;
            a.c = null;
            a.H = null;
            b || K(a, "ready");
            try {
                d.onreadystatechange = e
            } catch (f) {
                (d = a.v) && d.log(Ic, "Problem encountered resetting onreadystatechange: " + f.message, void 0)
            }
        }
    }

    function kd(a) {
        a.c && a.B && (a.c.ontimeout = null);
        ea(a.G) && (n.clearTimeout(a.G), a.G = null)
    }

    function qd(a) {
        var b = a.w(), d;
        a:switch (b) {
            case 200:
            case 201:
            case 202:
            case 204:
            case 206:
            case 304:
            case 1223:
                d = !0;
                break a;
            default:
                d = !1
        }
        if (!d) {
            if (b = 0 === b) a = Yc(String(a.o))[1] || null, !a && self.location && (a = self.location.protocol, a = a.substr(0, a.length - 1)), b = !fd.test(a ? a.toLowerCase() : "");
            d = b
        }
        return d
    }

    function pd(a) {
        return a.c ? a.c.readyState : 0
    }

    l.w = function () {
        try {
            return 2 < pd(this) ? this.c.status : -1
        } catch (a) {
            return -1
        }
    };

    function rd(a) {
        try {
            if (!a.c) return null;
            if ("response" in a.c) return a.c.response;
            switch (a.F) {
                case cd:
                case "text":
                    return a.c.responseText;
                case "arraybuffer":
                    if ("mozResponseArrayBuffer" in a.c) return a.c.mozResponseArrayBuffer
            }
            var b = a.v;
            b && b.log(Ic, "Response type " + a.F + " is not supported on this browser", void 0);
            return null
        } catch (d) {
            return L(a.v, "Can not get response: " + d.message), null
        }
    }

    function M(a, b) {
        return b + " [" + a.Z + " " + a.o + " " + a.w() + "]"
    };

    function N(a, b) {
        this.c = this.o = this.i = "";
        this.s = null;
        this.l = this.f = "";
        this.m = !1;
        var d;
        a instanceof N ? (this.m = void 0 !== b ? b : a.m, sd(this, a.i), this.o = a.o, this.c = a.c, td(this, a.s), this.f = a.f, ud(this, a.h.clone()), this.l = a.l) : a && (d = Yc(String(a))) ? (this.m = !!b, sd(this, d[1] || "", !0), this.o = vd(d[2] || ""), this.c = vd(d[3] || "", !0), td(this, d[4]), this.f = vd(d[5] || "", !0), ud(this, d[6] || "", !0), this.l = vd(d[7] || "")) : (this.m = !!b, this.h = new wd(null, 0, this.m))
    }

    N.prototype.toString = function () {
        var a = [], b = this.i;
        b && a.push(xd(b, yd, !0), ":");
        if (b = this.c) {
            a.push("//");
            var d = this.o;
            d && a.push(xd(d, yd, !0), "@");
            a.push(encodeURIComponent(String(b)).replace(/%25([0-9a-fA-F]{2})/g, "%$1"));
            b = this.s;
            null != b && a.push(":", String(b))
        }
        if (b = this.f) this.c && "/" != b.charAt(0) && a.push("/"), a.push(xd(b, "/" == b.charAt(0) ? zd : Ad, !0));
        (b = this.h.toString()) && a.push("?", b);
        (b = this.l) && a.push("#", xd(b, Bd));
        return a.join("")
    };
    N.prototype.clone = function () {
        return new N(this)
    };

    function sd(a, b, d) {
        a.i = d ? vd(b, !0) : b;
        a.i && (a.i = a.i.replace(/:$/, ""))
    }

    function td(a, b) {
        if (b) {
            b = Number(b);
            if (isNaN(b) || 0 > b) throw Error("Bad port number " + b);
            a.s = b
        } else a.s = null
    }

    function ud(a, b, d) {
        b instanceof wd ? (a.h = b, Cd(a.h, a.m)) : (d || (b = xd(b, Dd)), a.h = new wd(b, 0, a.m))
    }

    function Ed(a) {
        return a instanceof N ? a.clone() : new N(a, void 0)
    }

    function Fd(a, b) {
        a instanceof N || (a = Ed(a));
        b instanceof N || (b = Ed(b));
        var d = a, e = b, f = d.clone(), g = !!e.i;
        g ? sd(f, e.i) : g = !!e.o;
        g ? f.o = e.o : g = !!e.c;
        g ? f.c = e.c : g = null != e.s;
        var h = e.f;
        if (g) td(f, e.s); else if (g = !!e.f) if ("/" != h.charAt(0) && (d.c && !d.f ? h = "/" + h : (d = f.f.lastIndexOf("/"), -1 != d && (h = f.f.substr(0, d + 1) + h))), d = h, ".." == d || "." == d) h = ""; else if (A(d, "./") || A(d, "/.")) {
            for (var h = 0 == d.lastIndexOf("/", 0), d = d.split("/"), k = [], m = 0; m < d.length;) {
                var r = d[m++];
                "." == r ? h && m == d.length && k.push("") : ".." == r ? ((1 < k.length || 1 == k.length &&
                    "" != k[0]) && k.pop(), h && m == d.length && k.push("")) : (k.push(r), h = !0)
            }
            h = k.join("/")
        } else h = d;
        g ? f.f = h : g = "" !== e.h.toString();
        g ? ud(f, vd(e.h.toString())) : g = !!e.l;
        g && (f.l = e.l);
        return f
    }

    function vd(a, b) {
        return a ? b ? decodeURI(a.replace(/%25/g, "%2525")) : decodeURIComponent(a) : ""
    }

    function xd(a, b, d) {
        return q(a) ? (a = encodeURI(a).replace(b, Gd), d && (a = a.replace(/%25([0-9a-fA-F]{2})/g, "%$1")), a) : null
    }

    function Gd(a) {
        a = a.charCodeAt(0);
        return "%" + (a >> 4 & 15).toString(16) + (a & 15).toString(16)
    }

    var yd = /[#\/\?@]/g, Ad = /[\#\?:]/g, zd = /[\#\?]/g, Dd = /[\#\?@]/g, Bd = /#/g;

    function wd(a, b, d) {
        this.h = this.c = null;
        this.f = a || null;
        this.i = !!d
    }

    function Hd(a) {
        a.c || (a.c = new zc, a.h = 0, a.f && $c(a.f, function (b, d) {
            var e = decodeURIComponent(b.replace(/\+/g, " "));
            Hd(a);
            a.f = null;
            var e = Id(a, e), f = Dc(a.c, e);
            f || Ac(a.c, e, f = []);
            f.push(d);
            a.h++
        }))
    }

    function Jd(a, b) {
        Hd(a);
        b = Id(a, b);
        if (Cc(a.c.f, b)) {
            a.f = null;
            a.h -= Dc(a.c, b).length;
            var d = a.c;
            Cc(d.f, b) && (delete d.f[b], d.h--, d.i++, d.c.length > 2 * d.h && Bc(d))
        }
    }

    l = wd.prototype;
    l.clear = function () {
        this.c = this.f = null;
        this.h = 0
    };
    l.I = function () {
        Hd(this);
        for (var a = this.c.J(), b = this.c.I(), d = [], e = 0; e < b.length; e++) for (var f = a[e], g = 0; g < f.length; g++) d.push(b[e]);
        return d
    };
    l.J = function (a) {
        Hd(this);
        var b = [];
        if (q(a)) {
            var d = a;
            Hd(this);
            d = Id(this, d);
            Cc(this.c.f, d) && (b = ya(b, Dc(this.c, Id(this, a))))
        } else for (a = this.c.J(), d = 0; d < a.length; d++) b = ya(b, a[d]);
        return b
    };

    function Kd(a, b, d) {
        Jd(a, b);
        if (0 < d.length) {
            a.f = null;
            var e = a.c;
            b = Id(a, b);
            var f;
            f = d.length;
            if (0 < f) {
                for (var g = Array(f), h = 0; h < f; h++) g[h] = d[h];
                f = g
            } else f = [];
            Ac(e, b, f);
            a.h += d.length
        }
    }

    l.toString = function () {
        if (this.f) return this.f;
        if (!this.c) return "";
        for (var a = [], b = this.c.I(), d = 0; d < b.length; d++) for (var e = b[d], f = encodeURIComponent(String(e)), e = this.J(e), g = 0; g < e.length; g++) {
            var h = f;
            "" !== e[g] && (h += "=" + encodeURIComponent(String(e[g])));
            a.push(h)
        }
        return this.f = a.join("&")
    };
    l.clone = function () {
        var a = new wd;
        a.f = this.f;
        this.c && (a.c = this.c.clone(), a.h = this.h);
        return a
    };

    function Id(a, b) {
        var d = String(b);
        a.i && (d = d.toLowerCase());
        return d
    }

    function Cd(a, b) {
        b && !a.i && (Hd(a), a.f = null, a.c.forEach(function (a, b) {
            var f = b.toLowerCase();
            b != f && (Jd(this, b), Kd(this, f, a))
        }, a));
        a.i = b
    };G.prototype.thenCatch = G.prototype.ja;

    function Ld() {
        Md("testCookie", "test", 1);
        return "test" == Nd("testCookie")
    }

    function Md(a, b, d) {
        var e = new Date;
        e.setTime(e.getTime() + 864E5 * d);
        document.cookie = a + "=" + b + "; " + ("expires=" + e.toUTCString())
    }

    function Nd(a) {
        a = a + "=";
        for (var b = document.cookie.split(";"), d = 0; d < b.length; d++) {
            for (var e = b[d]; " " == e.charAt(0);) e = e.substring(1);
            if (0 == e.indexOf(a)) return e.substring(a.length, e.length)
        }
        return ""
    }

    function Pd(a) {
        if (window.localStorage) if (a) window.localStorage.ServicePort = a; else try {
            delete window.localStorage.ServicePort
        } catch (b) {
        } else Ld() ? a ? Md("ServicePort", a, 100) : Md("ServicePort", "", 100) : window.c = a
    }

    function Qd() {
        return window.localStorage ? window.localStorage.ServicePort : Ld() ? Nd("ServicePort") : window.c
    }

    function Rd(a, b, d) {
        var e;
        if ("undefined" !== typeof XMLHttpRequest) e = new XMLHttpRequest; else {
            e = "MSXML2.XmlHttp.6.0 MSXML2.XmlHttp.5.0 MSXML2.XmlHttp.4.0 MSXML2.XmlHttp.3.0 MSXML2.XmlHttp.2.0 Microsoft.XmlHttp".split(" ");
            for (var f, g = 0; g < e.length; g++) try {
                f = new ActiveXObject(e[g]);
                break
            } catch (h) {
            }
            e = f
        }
        f = [];
        var g = null, k;
        for (k in b) f.push(encodeURIComponent(k) + "=" + encodeURIComponent(b[k]));
        "POST" == d ? g = f.length ? f.join("&") : "" : a += f.length ? "?" + f.join("&") : "";
        e.open(d || "GET", a, !1);
        "POST" == d && e.setRequestHeader("Content-type",
            "application/x-www-form-urlencoded");
        e.send(g);
        if (200 != e.status) throw Error("Failed to execute webservice command: " + e.status + ": " + e.statusText);
        return e.responseText
    }

    function Sd(a, b) {
        var d = Qd();
        O("checkEnvironment > cachedWebPort : " + d);
        O("checkEnvironment > trying async service discovery");
        d ? id("https://localhost:" + d + "/DYMO/DLS/Printing/StatusConnected", function (d) {
            qd(d.target) ? a() : (Pd(null), Td(a, b))
        }, "GET", void 0) : Td(a, b)
    }

    function Ud(a, b) {
        var d = Qd();
        O("checkEnvironment > cachedWebPort : " + d);
        O("checkEnvironment > trying synchronous service discovery");
        var d = d || 41951, e;
        try {
            e = "true" === Rd("https://localhost:" + d + "/DYMO/DLS/Printing/StatusConnected", {}, "GET")
        } catch (f) {
            e = !1
        }
        e ? (O("checkEnvironment > web service found at port :" + d), Pd(d), a(), Vd || P.c()) : (Pd(null), b())
    }

    function Td(a, b) {
        for (var d = [], e = 41951; 41960 >= e; ++e) d.push(Wd(e));
        zb(d).then(function () {
            b()
        }).ja(function (d) {
            ea(d) ? (Pd(d), a()) : b()
        })
    }

    function Wd(a) {
        var b = "https://localhost:" + a + "/DYMO/DLS/Printing/StatusConnected";
        return new G(function (d, e) {
            id(b, function (b) {
                qd(b.target) ? e(a) : d(a)
            }, "GET", void 0)
        })
    }

    function Xd(a, b, d) {
        var e = "https://localhost:" + Qd() + "/DYMO/DLS/Printing/" + b;
        return new G(function (f, g) {
            var h = [], k = null, m;
            for (m in d) h.push(encodeURIComponent(m) + "=" + encodeURIComponent(d[m]));
            "POST" == a ? k = h.length ? h.join("&") : "" : e += h.length ? "?" + h.join("&") : "";
            id(e, function (a) {
                var d = a.target;
                a = null;
                if (qd(d)) {
                    d = rd(d);
                    try {
                        a = window.JSON.parse(d)
                    } catch (e) {
                        a = d
                    }
                    f(a)
                } else a = "Failed to execute webservice command: " + b + ". Error: " + d.w(), O("invokeWsCommandAsync > " + a), g(Error(a))
            }, a || "GET", k)
        })
    }

    function Yd(a, b, d) {
        var e = Qd();
        a = Rd("https://localhost:" + e + "/DYMO/DLS/Printing/" + b, d, a);
        try {
            return window.JSON.parse(a)
        } catch (f) {
            return a
        }
    }

    function Zd() {
        this.getPrinters = function () {
            return Yd("GET", "GetPrinters", {})
        };
        this.openLabelFile = function (a) {
            return Yd("GET", "OpenLabelFile", {fileName: a})
        };
        this.printLabel = function (a, b, d, e) {
            return Yd("POST", "PrintLabel", {printerName: a, printParamsXml: b, labelXml: d, labelSetXml: e})
        };
        this.printLabel2 = function (a, b, d, e) {
            return Yd("POST", "PrintLabel2", {printerName: a, printParamsXml: b, labelXml: d, labelSetXml: e})
        };
        this.renderLabel = function (a, b, d) {
            return Yd("POST", "RenderLabel", {labelXml: a, renderParamsXml: b, printerName: d})
        };
        this.loadImageAsPngBase64 = function (a) {
            return Yd("GET", "LoadImageAsPngBase64", {imageUri: a})
        };
        this.T = function () {
            return Xd("GET", "GetPrinters", {})
        };
        this.V = function (a) {
            return Xd("GET", "OpenLabelFile", {fileName: a})
        };
        this.X = function (a, b, d, e) {
            return Xd("POST", "PrintLabel", {printerName: a, printParamsXml: b, labelXml: d, labelSetXml: e})
        };
        this.W = function (a, b, d, e) {
            return Xd("POST", "PrintLabel2", {printerName: a, printParamsXml: b, labelXml: d, labelSetXml: e})
        };
        this.Y = function (a, b, d) {
            return Xd("POST", "RenderLabel", {
                labelXml: a,
                renderParamsXml: b, printerName: d
            })
        };
        this.U = function (a) {
            return Xd("GET", "LoadImageAsPngBase64", {imageUri: a})
        }
    };var $d = {};
    v("dymo.label.framework.FlowDirection", $d);
    $d.LeftToRight = "LeftToRight";
    $d.RightToLeft = "RightToLeft";
    var ae = {};
    v("dymo.label.framework.LabelWriterPrintQuality", ae);
    ae.Auto = "Auto";
    ae.Text = "Text";
    ae.BarcodeAndGraphics = "BarcodeAndGraphics";
    var be = {};
    v("dymo.label.framework.TwinTurboRoll", be);
    be.Auto = "Auto";
    be.Left = "Left";
    be.Right = "Right";
    var ce = {};
    v("dymo.label.framework.TapeAlignment", ce);
    ce.Center = "Center";
    ce.Left = "Left";
    ce.Right = "Right";
    var de = {};
    v("dymo.label.framework.TapeCutMode", de);
    de.AutoCut = "AutoCut";
    de.ChainMarks = "ChainMarks";
    var ee = {};
    v("dymo.label.framework.AddressBarcodePosition", ee);
    ee.AboveAddress = "AboveAddress";
    ee.BelowAddress = "BelowAddress";
    ee.Suppress = "Suppress";
    var Q = {};
    v("dymo.label.framework.PrintJobStatus", Q);
    Q.S = 0;
    Q.Unknown = Q.S;
    Q.va = 1;
    Q.Printing = Q.va;
    Q.ma = 2;
    Q.Finished = Q.ma;
    Q.Error = 3;
    Q.Error = Q.Error;
    Q.ta = 4;
    Q.PaperOut = Q.ta;
    Q.oa = 5;
    Q.InQueue = Q.oa;
    Q.da = -1;
    Q.ProcessingError = Q.da;
    Q.ua = -2;
    Q.PrinterBusy = Q.ua;
    Q.pa = -3;
    Q.InvalidJobId = Q.pa;
    Q.sa = -4;
    Q.NotSpooled = Q.sa;

    function R(a) {
        if ("undefined" != typeof DOMParser) return (new DOMParser).parseFromString(a, "application/xml");
        if ("undefined" != typeof ActiveXObject) {
            var b = new ActiveXObject("MSXML2.DOMDocument");
            if (b) {
                b.resolveExternals = !1;
                b.validateOnParse = !1;
                try {
                    b.setProperty("ProhibitDTD", !0), b.setProperty("MaxXMLSize", 2048), b.setProperty("MaxElementDepth", 256)
                } catch (d) {
                }
            }
            b.loadXML(a);
            return b
        }
        throw Error("Your browser does not support loading xml documents");
    }

    function fe(a) {
        if ("undefined" != typeof XMLSerializer) return (new XMLSerializer).serializeToString(a);
        if (a = a.xml) return a;
        throw Error("Your browser does not support serializing XML documents");
    };

    function S(a, b, d, e) {
        b = a.ownerDocument.createElement(b);
        d && b.appendChild(a.ownerDocument.createTextNode(d));
        if (e) for (var f in e) b.setAttribute(f, e[f]);
        a.appendChild(b)
    }

    function T(a) {
        if (a) {
            var b = [];
            ab(a, b, !1);
            a = b.join("")
        } else a = "";
        return a
    }

    function U(a, b) {
        var d = a.getElementsByTagName(b);
        if (0 < d.length) return d[0]
    }

    function V(a, b) {
        for (; a.firstChild;) a.removeChild(a.firstChild);
        a.appendChild(a.ownerDocument.createTextNode(b))
    };

    function W() {
        this.c = []
    }

    v("dymo.label.framework.LabelSetBuilder", W);
    W.prototype.h = function () {
        return this.c
    };
    W.prototype.getRecords = W.prototype.h;
    W.prototype.f = function () {
        var a = new X;
        this.c.push(a);
        return a
    };
    W.prototype.addRecord = W.prototype.f;

    function ge(a) {
        for (var b = R("<LabelSet/>"), d = b.documentElement, e = 0; e < a.length; e++) {
            var f = a[e], g = b.createElement("LabelRecord"), h;
            for (h in f) {
                var k = f[h];
                if ("function" != typeof k) {
                    var k = k.toString(), m = b.createElement("ObjectData");
                    m.setAttribute("Name", h);
                    0 == k.indexOf("<TextMarkup>") ? (k = R(k), m.appendChild(k.documentElement.cloneNode(!0))) : m.appendChild(b.createTextNode(k));
                    g.appendChild(m)
                }
            }
            d.appendChild(g)
        }
        return fe(b)
    }

    W.toXml = ge;
    W.prototype.toString = function () {
        return ge(this.c)
    };

    function X() {
    }

    X.prototype.h = function (a, b) {
        b = b.toString();
        0 != b.indexOf("<TextMarkup>") && (b = "<TextMarkup>" + b + "</TextMarkup>");
        this[a] = b;
        return this
    };
    X.prototype.setTextMarkup = X.prototype.h;
    X.prototype.f = function (a, b) {
        this[a] = b;
        return this
    };
    X.prototype.setText = X.prototype.f;
    X.prototype.c = function (a, b) {
        this[a] = b;
        return this
    };
    X.prototype.setBase64Image = X.prototype.c;

    function Y(a) {
        this.f = R(a)
    }

    Y.prototype.c = function () {
        return fe(this.f)
    };
    Y.prototype.getLabelXml = Y.prototype.c;
    Y.prototype.M = function (a, b) {
        return he(this.c(), a, b)
    };
    Y.prototype.render = Y.prototype.M;
    Y.prototype.O = function (a, b) {
        return ie(this.c(), a, b)
    };
    Y.prototype.renderAsync = Y.prototype.O;
    Y.prototype.h = function (a, b, d) {
        je(a, b, this.c(), d)
    };
    Y.prototype.print = Y.prototype.h;
    Y.prototype.H = function (a, b, d) {
        return ke(a, b, this.c(), d)
    };
    Y.prototype.printAsync = Y.prototype.H;
    Y.prototype.A = function (a, b, d) {
        return le(a, b, this.c(), d)
    };
    Y.prototype.print2 = Y.prototype.A;
    Y.prototype.F = function (a, b, d) {
        return me(a, b, this.c(), d)
    };
    Y.prototype.print2Async = Y.prototype.F;
    Y.prototype.G = function (a, b, d, e, f) {
        return ne(a, b, this.c(), d, e, f)
    };
    Y.prototype.printAndPollStatus = Y.prototype.G;
    Y.prototype.B = function (a, b, d, e, f) {
        return oe(a, b, this.c(), d, e, f)
    };
    Y.prototype.printAndPollStatusAsync = Y.prototype.B;
    var pe = "AddressObject TextObject BarcodeObject ShapeObject CounterObject ImageObject CircularTextObject DateTimeObject".split(" ");

    function qe(a, b) {
        var d = b || pe;
        return Xa(a.f.documentElement, function (a) {
            return 1 == a.nodeType && 0 <= ra(d, a.tagName)
        })
    }

    Y.prototype.o = function () {
        for (var a = qe(this), b = [], d = 0; d < a.length; d++) b.push(T(U(a[d], "Name")));
        return b
    };
    Y.prototype.getObjectNames = Y.prototype.o;
    Y.prototype.l = function () {
        return qe(this, ["AddressObject"]).length
    };
    Y.prototype.getAddressObjectCount = Y.prototype.l;

    function re(a, b) {
        return qe(a, ["AddressObject"])[b]
    }

    Y.prototype.i = function (a) {
        return T(U(re(this, a), "BarcodePosition"))
    };
    Y.prototype.getAddressBarcodePosition = Y.prototype.i;
    Y.prototype.P = function (a, b) {
        if ("AboveAddress" != b && "BelowAddress" != b && "Suppress" != b) throw Error("verifyAddressBarcodePosition(): barcode position '" + b + "' is invalid value");
        V(U(re(this, a), "BarcodePosition"), b);
        return this
    };
    Y.prototype.setAddressBarcodePosition = Y.prototype.P;
    Y.prototype.m = function (a) {
        return se(re(this, a))
    };
    Y.prototype.getAddressText = Y.prototype.m;
    Y.prototype.R = function (a, b) {
        return te(this, re(this, a), b)
    };
    Y.prototype.setAddressText = Y.prototype.R;

    function ue(a, b) {
        for (var d = qe(a), e = 0; e < d.length; e++) {
            var f = d[e];
            if (T(U(f, "Name")) == b) return f
        }
        throw Error("getObjectByNameElement(): no object with name '" + b + "' was found");
    }

    function se(a) {
        return ta(U(a, "StyledText").getElementsByTagName("String"), function (a, d) {
            return a + T(d)
        }, "")
    }

    Y.prototype.s = function (a) {
        a = ue(this, a);
        switch (a.tagName) {
            case "AddressObject":
            case "TextObject":
                return se(a);
            case "BarcodeObject":
                return T(U(a, "Text"));
            case "ImageObject":
                if (a = U(a, "Image")) return T(a);
                break;
            case "CircularTextObject":
                return T(U(a, "Text"))
        }
        return ""
    };
    Y.prototype.getObjectText = Y.prototype.s;

    function te(a, b, d) {
        var e = U(b, "StyledText"), f = [], g;
        g = e.getElementsByTagName("Element");
        for (var h = !0, k = 0; k < g.length; k++) {
            var m = g[k], r = T(U(m, "String"));
            if (r && r.length) {
                var r = r.split("\n"), z = r.length;
                if (1 != z || h) {
                    var x = 0;
                    h || (x = 1);
                    for (h = U(m, "Attributes"); x < z - 1; x++) f.push(h);
                    0 < r[z - 1].length ? (f.push(h), h = !1) : h = !0
                }
            }
        }
        g = U(b, "LineFonts");
        b = [];
        g && (b = g.getElementsByTagName("Font"));
        var Od;
        0 == b.length && (Od = R('<Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />').documentElement);
        for (g = R('<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />').documentElement; e.firstChild;) e.removeChild(e.firstChild);
        d = d.split("\n");
        for (k = 0; k < d.length; k++) x = d[k].replace("\r", ""), k < d.length - 1 && (x += "\n"), h = Od, 0 < b.length ? h = k < b.length ? b[k] : b[b.length - 1] : 0 < f.length && (h = k < f.length ? U(f[k], "Font") : U(f[f.length - 1], "Font")), m = g, k < f.length && (m = U(f[k], "ForeColor")), r = e.ownerDocument.createElement("Element"), z = e.ownerDocument.createElement("String"), V(z, x), x = e.ownerDocument.createElement("Attributes"),
            x.appendChild(h.cloneNode(!0)), x.appendChild(m.cloneNode(!0)), r.appendChild(z), r.appendChild(x), e.appendChild(r);
        return a
    }

    Y.prototype.Z = function (a, b) {
        var d = ue(this, a);
        switch (d.tagName) {
            case "AddressObject":
                te(this, d, b);
                break;
            case "TextObject":
                te(this, d, b);
                break;
            case "BarcodeObject":
                V(U(d, "Text"), b);
                break;
            case "ImageObject":
                var e = U(d, "Image");
                if (e) V(e, b); else {
                    var f = U(d, "ImageLocation");
                    if (!f) throw Error("setObjectText(): <ImageLocation> is expected but not found: " + fe(e));
                    e = f.ownerDocument.createElement("Image");
                    V(e, b);
                    d.replaceChild(e, f)
                }
                break;
            case "CircularTextObject":
                V(U(d, "Text"), b);
                break;
            case "DateTimeObject":
                V(U(d,
                    "PreText"), b);
                break;
            case "CounterObject":
                V(U(d, "PreText"), b)
        }
        return this
    };
    Y.prototype.setObjectText = Y.prototype.Z;
    Y.prototype.toString = function () {
        return this.c()
    };

    /*
 Portions of this code are from MochiKit, received by
 The Closure Authors under the MIT license. All other code is Copyright
 2005-2009 The Closure Authors. All Rights Reserved.
*/
    function ve(a, b) {
        this.l = [];
        this.B = a;
        this.G = b || null;
        this.i = this.c = !1;
        this.h = void 0;
        this.A = this.H = this.o = !1;
        this.m = 0;
        this.f = null;
        this.s = 0
    }

    ve.prototype.cancel = function (a) {
        if (this.c) this.h instanceof ve && this.h.cancel(); else {
            if (this.f) {
                var b = this.f;
                delete this.f;
                a ? b.cancel(a) : (b.s--, 0 >= b.s && b.cancel())
            }
            this.B ? this.B.call(this.G, this) : this.A = !0;
            this.c || (a = new we, xe(this), ye(this, !1, a))
        }
    };
    ve.prototype.F = function (a, b) {
        this.o = !1;
        ye(this, a, b)
    };

    function ye(a, b, d) {
        a.c = !0;
        a.h = d;
        a.i = !b;
        ze(a)
    }

    function xe(a) {
        if (a.c) {
            if (!a.A) throw new Ae;
            a.A = !1
        }
    }

    function Be(a, b, d, e) {
        a.l.push([b, d, e]);
        a.c && ze(a)
    }

    ve.prototype.then = function (a, b, d) {
        var e, f, g = new G(function (a, b) {
            e = a;
            f = b
        });
        Be(this, e, function (a) {
            a instanceof we ? g.cancel() : f(a)
        });
        return g.then(a, b, d)
    };
    bb(ve);

    function Ce(a) {
        return ua(a.l, function (a) {
            return t(a[1])
        })
    }

    function ze(a) {
        if (a.m && a.c && Ce(a)) {
            var b = a.m, d = De[b];
            d && (n.clearTimeout(d.u), delete De[b]);
            a.m = 0
        }
        a.f && (a.f.s--, delete a.f);
        for (var b = a.h, e = d = !1; a.l.length && !a.o;) {
            var f = a.l.shift(), g = f[0], h = f[1], f = f[2];
            if (g = a.i ? h : g) try {
                var k = g.call(f || a.G, b);
                void 0 !== k && (a.i = a.i && (k == b || k instanceof Error), a.h = b = k);
                if (cb(b) || "function" === typeof n.Promise && b instanceof n.Promise) e = !0, a.o = !0
            } catch (m) {
                b = m, a.i = !0, Ce(a) || (d = !0)
            }
        }
        a.h = b;
        e && (k = u(a.F, a, !0), e = u(a.F, a, !1), b instanceof ve ? (Be(b, k, e), b.H = !0) : b.then(k, e));
        d && (b =
            new Ee(b), De[b.u] = b, a.m = b.u)
    }

    function Ae() {
        y.call(this)
    }

    w(Ae, y);
    Ae.prototype.message = "Deferred has already fired";
    Ae.prototype.name = "AlreadyCalledError";

    function we() {
        y.call(this)
    }

    w(we, y);
    we.prototype.message = "Deferred was canceled";
    we.prototype.name = "CanceledError";

    function Ee(a) {
        this.u = n.setTimeout(u(this.f, this), 0);
        this.c = a
    }

    Ee.prototype.f = function () {
        delete De[this.u];
        throw this.c;
    };
    var De = {};

    function Fe(a, b) {
        var d = b || {}, e = d.document || document, f = document.createElement("SCRIPT"), g = {ia: f, L: void 0},
            h = new ve(Ge, g), k = null, m = null != d.timeout ? d.timeout : 5E3;
        0 < m && (k = window.setTimeout(function () {
            He(f, !0);
            var b = new Ie(Je, "Timeout reached for loading script " + a);
            xe(h);
            ye(h, !1, b)
        }, m), g.L = k);
        f.onload = f.onreadystatechange = function () {
            f.readyState && "loaded" != f.readyState && "complete" != f.readyState || (He(f, d.xa || !1, k), xe(h), ye(h, !0, null))
        };
        f.onerror = function () {
            He(f, !0, k);
            var b = new Ie(Ke, "Error while loading script " +
                a);
            xe(h);
            ye(h, !1, b)
        };
        Va(f, {type: "text/javascript", charset: "UTF-8", src: a});
        Le(e).appendChild(f);
        return h
    }

    function Le(a) {
        var b = a.getElementsByTagName("HEAD");
        return b && 0 != b.length ? b[0] : a.documentElement
    }

    function Ge() {
        if (this && this.ia) {
            var a = this.ia;
            a && "SCRIPT" == a.tagName && He(a, !0, this.L)
        }
    }

    function He(a, b, d) {
        null != d && n.clearTimeout(d);
        a.onload = p;
        a.onerror = p;
        a.onreadystatechange = p;
        b && window.setTimeout(function () {
            a && a.parentNode && a.parentNode.removeChild(a)
        }, 0)
    }

    var Ke = 0, Je = 1;

    function Ie(a, b) {
        var d = "Jsloader error (code #" + a + ")";
        b && (d += ": " + b);
        y.call(this, d)
    }

    w(Ie, y);

    function Me(a, b) {
        this.f = new N(a);
        this.c = b ? b : "callback";
        this.L = 5E3
    }

    var Ne = 0;
    Me.prototype.send = function (a, b, d, e) {
        a = a || null;
        e = e || "_" + (Ne++).toString(36) + ka().toString(36);
        n._callbacks_ || (n._callbacks_ = {});
        var f = this.f.clone();
        if (a) for (var g in a) if (!a.hasOwnProperty || a.hasOwnProperty(g)) {
            var h = f, k = g, m = a[g];
            ca(m) || (m = [String(m)]);
            Kd(h.h, k, m)
        }
        b && (n._callbacks_[e] = Oe(e, b), b = this.c, g = "_callbacks_." + e, ca(g) || (g = [String(g)]), Kd(f.h, b, g));
        b = Fe(f.toString(), {timeout: this.L, xa: !0});
        Be(b, null, Pe(e, a, d), void 0);
        return {u: e, fa: b}
    };
    Me.prototype.cancel = function (a) {
        a && (a.fa && a.fa.cancel(), a.u && Qe(a.u, !1))
    };

    function Pe(a, b, d) {
        return function () {
            Qe(a, !1);
            d && d(b)
        }
    }

    function Oe(a, b) {
        return function (d) {
            Qe(a, !0);
            b.apply(void 0, arguments)
        }
    }

    function Qe(a, b) {
        n._callbacks_[a] && (b ? delete n._callbacks_[a] : n._callbacks_[a] = p)
    };

    function Re(a, b, d) {
        Lb.call(this);
        this.c = a;
        this.m = b || 0;
        this.f = d;
        this.h = u(this.i, this)
    }

    w(Re, Lb);
    Re.prototype.u = 0;
    Re.prototype.K = function () {
        Re.ca.K.call(this);
        0 != this.u && n.clearTimeout(this.u);
        this.u = 0;
        delete this.c;
        delete this.f
    };

    function Se(a) {
        0 != a.u && n.clearTimeout(a.u);
        a.u = 0;
        a.u = qc(a.h, a.m)
    }

    Re.prototype.i = function () {
        this.u = 0;
        this.c && this.c.call(this.f)
    };
    var Te = function () {
        function a(a) {
            var b = f;
            return b[a[0]] + b[a[1]] + b[a[2]] + b[a[3]] + "-" + b[a[4]] + b[a[5]] + "-" + b[a[6]] + b[a[7]] + "-" + b[a[8]] + b[a[9]] + "-" + b[a[10]] + b[a[11]] + b[a[12]] + b[a[13]] + b[a[14]] + b[a[15]]
        }

        function b(b, f, g) {
            var h = "binary" != b ? e : f ? f : new d(16);
            f = f && g || 0;
            g = 4294967296 * Math.random();
            h[f++] = g & 255;
            h[f++] = (g >>>= 8) & 255;
            h[f++] = (g >>>= 8) & 255;
            h[f++] = g >>> 8 & 255;
            g = 4294967296 * Math.random();
            h[f++] = g & 255;
            h[f++] = (g >>>= 8) & 255;
            h[f++] = (g >>>= 8) & 15 | 64;
            h[f++] = g >>> 8 & 255;
            g = 4294967296 * Math.random();
            h[f++] = g & 63 | 128;
            h[f++] =
                (g >>>= 8) & 255;
            h[f++] = (g >>>= 8) & 255;
            h[f++] = g >>> 8 & 255;
            g = 4294967296 * Math.random();
            h[f++] = g & 255;
            h[f++] = (g >>>= 8) & 255;
            h[f++] = (g >>>= 8) & 255;
            h[f++] = g >>> 8 & 255;
            return void 0 === b ? a(h) : h
        }

        for (var d = Array, e = new d(16), f = [], g = {}, h = 0; 256 > h; h++) f[h] = (h + 256).toString(16).substr(1).toUpperCase(), g[f[h]] = h;
        b.f = function (a) {
            var b = new d(16), e = 0;
            a.toUpperCase().replace(/[0-9A-F][0-9A-F]/g, function (a) {
                b[e++] = g[a]
            });
            return b
        };
        b.h = a;
        b.c = d;
        return b
    }();

    function Ue(a, b, d, e) {
        this.printerName = a;
        this.jobId = b;
        this.status = d;
        this.statusMessage = e
    }

    function Ve(a) {
        var b = {};
        a = a.split(" ");
        1 <= a.length && (b.status = parseInt(a[0], 10));
        b.statusMessage = a.slice(1).join(" ");
        return b
    }

    function We(a) {
        for (var b = 0; b < navigator.plugins.length; ++b) for (var d = navigator.plugins[b], e = 0; e < d.length; ++e) if (d[e].type == a) return !0;
        return !1
    }

    function Xe() {
        if (!document.getElementById("_DymoLabelFrameworkJslSafariPlugin")) {
            var a = document.createElement("embed");
            a.type = "application/x-dymolabel";
            a.id = "_DymoLabelFrameworkJslSafariPlugin";
            a.width = 1;
            a.height = 1;
            a.hidden = !0;
            document.body.appendChild(a)
        }
        return window._DymoLabelFrameworkJslSafariPlugin
    }

    function Ye(a) {
        if (!document.getElementById("_DymoLabelFrameworkJslPlugin")) {
            var b = document.createElement("embed");
            b.type = "application/x-dymolabel";
            b.id = "_DymoLabelFrameworkJslPlugin";
            a ? (b.width = 1, b.height = 1, b.hidden = !0) : (b.width = 0, b.height = 0, b.hidden = !1);
            document.body.appendChild(b)
        }
        return document.getElementById("_DymoLabelFrameworkJslPlugin")
    }

    function Ze() {
        var a = Ye(!0);
        a.getPrinters || (document.body.removeChild(a), a = Ye(!1));
        return a
    }

    function $e(a) {
        if (!document.getElementById("_DymoLabelFrameworkJslPlugin")) {
            var b = document.createElement("embed");
            b.type = "application/x-npapi-dymolabel";
            b.id = "_DymoLabelFrameworkJslPlugin";
            a ? (b.width = 1, b.height = 1, b.hidden = !0) : (b.width = 0, b.height = 0, b.hidden = !1);
            document.body.appendChild(b);
            b.getPrinters || (b.width = 1, b.height = 1, b.hidden = !1)
        }
        return document.getElementById("_DymoLabelFrameworkJslPlugin")
    }

    function af() {
        var a = $e(!0);
        a.getPrinters || (document.body.removeChild(a), a = $e(!1));
        return a
    }

    function bf() {
        var a = new ActiveXObject("DYMOLabelFrameworkIEPlugin.Plugin");
        if ("object" != typeof a) throw Error("createFramework(): unable to create DYMO.Label.Framework object. Check DYMO Label Framework is installed");
        return a
    }

    function cf(a) {
        function b(a) {
            return function () {
                var b = arguments;
                return new G(function (d) {
                    d(a.apply(null, b))
                })
            }
        }

        if ("" != a.errorDetails) throw Error(a.errorDetails);
        if (a.isWebServicePresent) {
            O("chooseEnvironment > WebServicePresent");
            var d = new Zd;
            if (d) a = {
                getPrinters: function () {
                    return d.getPrinters()
                }, openLabelFile: function (a) {
                    return d.openLabelFile(a)
                }, printLabel: function (a, b, e, f) {
                    d.printLabel(a, b, e, f)
                }, printLabel2: function (a, b, e, f) {
                    d.printLabel2(a, b, e, f)
                }, renderLabel: function (a, b, e) {
                    return d.renderLabel(a,
                        b, e)
                }, loadImageAsPngBase64: function (a) {
                    return d.loadImageAsPngBase64(a)
                }, getJobStatus: function (a, b) {
                    var e;
                    t(d.getJobStatus) ? e = Ve(d.getJobStatus(a, parseInt(b, 10))) : e = {
                        status: Q.S,
                        statusMessage: "not implemented"
                    };
                    return new Ue(a, b, e.status, e.statusMessage)
                }, T: function () {
                    return d.T()
                }, V: function (a) {
                    return d.V(a)
                }, X: function (a, b, e, f) {
                    return d.X(a, b, e, f)
                }, W: function (a, b, e, f) {
                    return d.W(a, b, e, f)
                }, Y: function (a, b, e) {
                    return d.Y(a, b, e)
                }, U: function (a) {
                    return d.U(a)
                }
            }; else throw Error("Cannot establish connection to the web service. Is DYMO Label Framework installed?");
            return a
        }
        if ("ActiveXObject" in window) {
            O("chooseEnvironment > ActiveXObject");
            a = {};
            var e = bf();
            a.getPrinters = function () {
                return e.GetPrinters()
            };
            a.openLabelFile = function (a) {
                return e.OpenLabelFile(a)
            };
            a.printLabel = function (a, b, d, f) {
                e.PrintLabel(a, b, d, f)
            };
            a.renderLabel = function (a, b, d) {
                return e.RenderLabel(a, b, d)
            };
            a.loadImageAsPngBase64 = function (a) {
                return e.LoadImageAsPngBase64(a)
            };
            a.printLabel2 = function (a, b, d, f) {
                if (t(e.PrintLabel2)) return e.PrintLabel2(a, b, d, f).toString();
                e.PrintLabel(a, b, d, f)
            };
            a.getJobStatus =
                function (a, b) {
                    var d;
                    t(e.GetJobStatus) ? d = Ve(e.GetJobStatus(a, parseInt(b, 10))) : d = {
                        status: Q.S,
                        statusMessage: "not implemented"
                    };
                    return new Ue(a, b, d.status, d.statusMessage)
                }
        } else if (-1 != navigator.platform.indexOf("Win")) {
            O("chooseEnvironment > WIN");
            var f = Ze();
            if (f) a = {
                getPrinters: function () {
                    return f.getPrinters()
                }, openLabelFile: function (a) {
                    return f.openLabelFile(a)
                }, printLabel: function (a, b, d, e) {
                    f.printLabel(a, b, d, e)
                }, renderLabel: function (a, b, d) {
                    return f.renderLabel(a, b, d)
                }, loadImageAsPngBase64: function (a) {
                    return f.loadImageAsPngBase64(a)
                },
                printLabel2: function (a, b, d, e) {
                    if (t(f.printLabel2)) return f.printLabel2(a, b, d, e).toString();
                    f.printLabel(a, b, d, e)
                }, getJobStatus: function (a, b) {
                    var d;
                    t(f.getJobStatus) ? d = Ve(f.getJobStatus(a, parseInt(b, 10))) : d = {
                        status: Q.S,
                        statusMessage: "not implemented"
                    };
                    return new Ue(a, b, d.status, d.statusMessage)
                }
            }; else throw Error("DYMO Label Framework is not installed");
        } else {
            O("chooseEnvironment > not WIN");
            var g;
            We("application/x-dymolabel") ? (O("chooseEnvironment > _createSafariPlugin"), g = Xe()) : (O("chooseEnvironment > _createMacNsapiPlugin"),
                g = af());
            O("chooseEnvironment > safariPlugin : " + !!g);
            if (g) a = {
                getPrinters: function () {
                    return g.getPrinters()
                }, openLabelFile: function (a) {
                    var b = g.openLabelFile(a);
                    if (!b) throw Error("Unable to open label file '" + a + "'");
                    return b
                }, printLabel: function (a, b, d, e) {
                    g.printLabel(d, a, b, e)
                }, renderLabel: function (a, b, d) {
                    return g.renderLabel(a, b, d)
                }, loadImageAsPngBase64: function (a) {
                    var b = g.loadImageAsPngBase64(a);
                    if (!b) throw Error("Unable to load image from uri '" + a + "'");
                    return b
                }, printLabel2: function (a, b, d, e) {
                    if (t(g.printLabel2)) return g.printLabel2(d,
                        a, b, e).toString();
                    g.printLabel(d, a, b, e)
                }, getJobStatus: function (a, b) {
                    var d;
                    t(g.getJobStatus) ? d = Ve(g.getJobStatus(a, parseInt(b, 10))) : d = {
                        status: Q.S,
                        statusMessage: "not implemented"
                    };
                    return new Ue(a, b, d.status, d.statusMessage)
                }
            }; else throw Error("DYMO Label Framework is not installed");
        }
        a.T = b(a.getPrinters);
        a.V = b(a.openLabelFile);
        a.X = b(a.printLabel);
        a.W = b(a.printLabel2);
        a.Y = b(a.renderLabel);
        a.U = b(a.loadImageAsPngBase64);
        return a
    }

    v("dymo.label.framework.trace", !1);
    var Vd = 0;

    function O(a) {
        window.dymo.label.framework.trace && window.console && window.console.log && console.log(a)
    }

    function df(a) {
        function b() {
            throw d;
        }

        var d = a || Error("DYMO Label Framework Plugin or WebService are not installed");
        return {
            getPrinters: b,
            openLabelFile: b,
            printLabel: b,
            printLabel2: b,
            renderLabel: b,
            loadImageAsPngBase64: b,
            getJobStatus: b,
            T: b,
            V: b,
            X: b,
            W: b,
            Y: b,
            U: b
        }
    }

    var P = function () {
        function a(e, f) {
            if (d) throw O("_createFramework > Error service discovery is in progress. "), Error("DYMO Label Framework service discovery is in progress.");
            return b ? (O("_createFramework > returning existing instance of _framework, has callBack: " + !!e), e && e(), b) : this && this.constructor == a ? (d = !0, P.c = function () {
                b = null;
                Vd = 0
            }, ef(function (a) {
                O("onEnvironmentChecked > checkResult isBrowserSupported : " + a.isBrowserSupported + ", isFrameworkInstalled: " + a.isFrameworkInstalled + ", isWebServicePresent: " +
                    a.isWebServicePresent + ", errorDetails: " + a.errorDetails);
                try {
                    b = cf(a), Vd = a.isWebServicePresent ? 2 : 1
                } catch (h) {
                    O("onEnvironmentChecked > exception e : " + (h.description || h.message || h));
                    if (!f) throw h;
                    b = df(h);
                    O("onEnvironmentChecked > fall back to createFaultyFramework")
                } finally {
                    d = !1
                }
                e && e()
            }, f), O("_createFramework > return _framework : " + b + (f ? " (async)" : " (sync)")), b) : new a(e, f)
        }

        var b, d = !1;
        return a
    }();
    v("dymo.label.framework.init", function (a) {
        P(a, !0)
    });

    function ff(a, b, d, e, f) {
        this.printerType = a;
        this.name = b;
        this.modelName = d;
        this.isConnected = e;
        this.isLocal = f;
        this.c = this.C = ""
    }

    function gf(a, b, d, e, f) {
        ff.call(this, "LabelWriterPrinter", a, b, d, e);
        this.isTwinTurbo = f
    }

    w(gf, ff);

    function hf(a, b, d, e, f) {
        ff.call(this, "TapePrinter", a, b, d, e);
        this.isAutoCutSupported = f
    }

    w(hf, ff);

    function jf(a, b, d, e, f) {
        ff.call(this, "DZPrinter", a, b, d, e);
        this.isAutoCutSupported = f
    }

    w(jf, ff);

    function Z(a, b) {
        this.c = a;
        this.f = b
    }

    Z.prototype.h = function () {
        return this.c.name
    };
    Z.prototype.getPrinterName = Z.prototype.h;
    Z.prototype.i = function () {
        return this.f
    };
    Z.prototype.getJobId = Z.prototype.i;
    Z.prototype.w = function (a) {
        if ("" != this.c.C) kf(this, a); else {
            var b;
            try {
                b = P().getJobStatus(this.c.name, this.f)
            } catch (d) {
                b = new Ue(this.h(), this.f, Q.da, d.message || d)
            }
            a(b)
        }
    };
    Z.prototype.getStatus = Z.prototype.w;

    function kf(a, b) {
        var d = a.h(), e = a.f, f = a.c.C;
        (new Me(Fd(f, "getPrintJobStatus"), "callback")).send({jobId: e, printerName: a.c.c}, function (a) {
            b(new Ue(d, e, a.status, a.statusMessage))
        }, function () {
            b(new Ue(d, e, Q.da, 'Error processing getPrintJobStatus(): Unable to contact "' + f + '"'))
        })
    };v("dymo.label.framework.VERSION", "2.0.2");

    function ef(a, b) {
        function d() {
            O("checkLegacyPlugins");
            f.isWebServicePresent = !1;
            var b = window.navigator.platform;
            if (-1 != b.indexOf("Win")) if (O("checkLegacyPlugins > WIN platform "), "ActiveXObject" in window) {
                O("checkLegacyPlugins > ActiveXObject");
                f.isBrowserSupported = !0;
                try {
                    "object" != typeof new ActiveXObject("DYMOLabelFrameworkIEPlugin.Plugin") ? f.errorDetails = "Unable to create DYMO.Label.Framework ActiveX object. Check that DYMO.Label.Framework is installed" : f.isFrameworkInstalled = !0
                } catch (d) {
                    f.errorDetails =
                        "Unable to create DYMO.Label.Framework ActiveX object. Check that DYMO.Label.Framework is installed. Exception details: " + d
                }
            } else O("checkLegacyPlugins > non-IE"), f.isBrowserSupported = !0, We("application/x-dymolabel") ? (O("checkLegacyPlugins > 'application/x-dymolabel'"), f.isFrameworkInstalled = !0) : f.errorDetails = "DYMO Label Framework Plugin is not installed"; else -1 != b.indexOf("Mac") ? (O("checkLegacyPlugins > Mac platform"), f.isBrowserSupported = !0, We("application/x-dymolabel") ? (O("checkLegacyPlugins > safariPluginFound"),
                    b = Xe(), "2.0" <= b.GetAPIVersion() ? f.isFrameworkInstalled = !0 : f.errorDetails = "DYMO Label Safari Plugin is installed but outdated. Install the latest version.") : We("application/x-npapi-dymolabel") ? (O("checkLegacyPlugins > 'application/x-npapi-dymolabel'"), (b = af()) && b.getPrinters ? f.isFrameworkInstalled = !0 : f.errorDetails = 'DYMO NSAPI plugin is loaded but no callable functions found. If running Safari, then run it in 64-bit mode (MacOS X >= 10.7) or set "Open using Rosetta" option') : f.errorDetails = "DYMO Label Plugin is not installed.") :
                f.errorDetails = "The operating system is not supported.";
            a && a(f)
        }

        function e() {
            f.isBrowserSupported = !0;
            f.isFrameworkInstalled = !0;
            f.isWebServicePresent = !0;
            a && a(f)
        }

        var f = {isBrowserSupported: !1, isFrameworkInstalled: !1, isWebServicePresent: !1, errorDetails: ""};
        if (Vd) return O("checkEnvironment > return existing instance of framework"), 2 == Vd ? e() : (f.isBrowserSupported = !0, f.isFrameworkInstalled = !0, f.isWebServicePresent = !1, a && a(f)), f;
        b ? Sd(e, d) : Ud(e, d);
        return f
    }

    v("dymo.label.framework.checkEnvironment", ef);
    var lf = {};

    function mf(a, b, d) {
        this.c = a;
        this.f = b;
        this.h = d
    }

    mf.prototype.getPrinters = function () {
        var a = nf(this.h), b = new N(this.c), d = this.f;
        "" == d && (d = b.c);
        for (b = 0; b < a.length; ++b) {
            var e = a[b], f = e.name;
            e.name = f + " @ " + d;
            e.C = this.c;
            e.location = d;
            e.c = f;
            e.printerUri = e.C;
            e.location = e.location;
            e.localName = e.c
        }
        return a
    };
    v("dymo.label.framework.addPrinterUri", function (a, b, d, e) {
        var f = b || "";
        q(f) || (f = f.toString());
        b = null;
        e && (b = function () {
            e(a)
        });
        var g = ad(a);
        (new Me(g, "callback")).send(null, function (b) {
            lf[a] = new mf(a, f, b);
            d && d(a)
        }, b)
    });
    v("dymo.label.framework.removePrinterUri", function (a) {
        delete lf[a]
    });
    v("dymo.label.framework.removeAllPrinterUri", function () {
        lf = {}
    });

    function nf(a) {
        function b(a, b) {
            return T(U(a, b))
        }

        var d = R(a);
        a = [];
        for (var e = U(d, "Printers"), d = e.getElementsByTagName("LabelWriterPrinter"), f = 0; f < d.length; f++) {
            var g = b(d[f], "Name"), h = b(d[f], "ModelName"), k = "True" == b(d[f], "IsConnected"),
                m = "True" == b(d[f], "IsLocal"), r = "True" == b(d[f], "IsTwinTurbo"), g = new gf(g, h, k, m, r);
            a[f] = g;
            a[g.name] = g
        }
        r = e.getElementsByTagName("TapePrinter");
        for (f = 0; f < r.length; f++) {
            var g = b(r[f], "Name"), h = b(r[f], "ModelName"), k = "True" == b(r[f], "IsConnected"),
                m = "True" == b(r[f], "IsLocal"), z = "True" ==
                b(r[f], "IsAutoCutSupported"), g = new hf(g, h, k, m, z);
            a[f + d.length] = g;
            a[g.name] = g
        }
        e = e.getElementsByTagName("DZPrinter");
        for (f = 0; f < e.length; f++) g = b(e[f], "Name"), h = b(e[f], "ModelName"), k = "True" == b(e[f], "IsConnected"), m = "True" == b(e[f], "IsLocal"), z = "True" == b(e[f], "IsAutoCutSupported"), g = new jf(g, h, k, m, z), a[f + d.length] = g, a[g.name] = g;
        return a
    }

    function of() {
        var a = [];
        try {
            var b = P().getPrinters(), a = nf(b)
        } catch (d) {
        }
        for (var e in lf) for (var b = lf[e].getPrinters(), f = 0; f < b.length; ++f) {
            var g = b[f];
            a.push(g);
            a[g.name] = g
        }
        return a
    }

    v("dymo.label.framework.getPrinters", of);

    function pf() {
        return P().T().then(function (a) {
            var b = [];
            try {
                b = nf(a)
            } catch (d) {
            }
            for (var e in lf) {
                a = lf[e].getPrinters();
                for (var f = 0; f < a.length; ++f) {
                    var g = a[f];
                    b.push(g);
                    b[g.name] = g
                }
            }
            return b
        })
    }

    v("dymo.label.framework.getPrintersAsync", pf);

    function qf(a) {
        for (var b = [], d = of(), e = 0; e < d.length; e++) {
            var f = d[e];
            f.printerType && f.printerType == a && b.push(f)
        }
        return b
    }

    function rf(a) {
        return pf().then(function (b) {
            for (var d = [], e = 0; e < b.length; e++) {
                var f = b[e];
                f.printerType && f.printerType == a && d.push(f)
            }
            return d
        })
    }

    v("dymo.label.framework.getLabelWriterPrinters", function () {
        return qf("LabelWriterPrinter")
    });
    v("dymo.label.framework.getTapePrinters", function () {
        return qf("TapePrinter")
    });
    v("dymo.label.framework.getDZPrinters", function () {
        return qf("DZPrinter")
    });
    v("dymo.label.framework.getLabelWriterPrintersAsync", function () {
        return rf("LabelWriterPrinter")
    });
    v("dymo.label.framework.getTapePrintersAsync", function () {
        return rf("TapePrinter")
    });
    v("dymo.label.framework.getDZPrintersAsync", function () {
        return rf("DZPrinter")
    });
    v("dymo.label.framework.openLabelFile", function (a) {
        return new Y(P().openLabelFile(a))
    });
    v("dymo.label.framework.openLabelFileAsync", function (a) {
        return P().V(a).then(function (a) {
            return new Y(a)
        })
    });
    v("dymo.label.framework.openLabelXml", function (a) {
        var b = new Gc("dymo.label.framework");
        b.c = Kc;
        b.log(Kc, a, void 0);
        return new Y(a)
    });

    function je(a, b, d, e) {
        b = b || "";
        e = e || "";
        "string" != typeof e && (e = e.toString());
        if ("undefined" == typeof d) throw Error("printLabel(): labelXml parameter should be specified");
        "string" != typeof d && (d = d.toString());
        var f = of()[a];
        if (null != f) "" != f.C ? sf(f, b, d, e) : P().printLabel(f.name, b, d, e); else throw Error("printLabel(): unknown printer '" + a + "'");
    }

    v("dymo.label.framework.printLabel", je);

    function ke(a, b, d, e) {
        b = b || "";
        e = e || "";
        "string" != typeof e && (e = e.toString());
        if ("undefined" == typeof d) throw Error("printLabelAsync(): labelXml parameter should be specified");
        "string" != typeof d && (d = d.toString());
        return pf().then(function (f) {
            f = f[a];
            if (null != f) return "" != f.C ? sf(f, b, d, e) : P().X(f.name, b, d, e);
            throw Error("printLabelAsync(): unknown printer '" + a + "'");
        })
    }

    v("dymo.label.framework.printLabelAsync", ke);

    function le(a, b, d, e) {
        b = b || "";
        e = e || "";
        "string" != typeof e && (e = e.toString());
        if ("undefined" == typeof d) throw Error("printLabel2(): labelXml parameter should be specified");
        "string" != typeof d && (d = d.toString());
        var f = of()[a];
        if (null != f) return "" != f.C ? sf(f, b, d, e) : new Z(f, P().printLabel2(a, b, d, e));
        throw Error("printLabel(): unknown printer '" + a + "'");
    }

    v("dymo.label.framework.printLabel2", le);

    function me(a, b, d, e) {
        b = b || "";
        e = e || "";
        "string" != typeof e && (e = e.toString());
        if ("undefined" == typeof d) throw Error("printLabel2Async(): labelXml parameter should be specified");
        "string" != typeof d && (d = d.toString());
        return pf().then(function (f) {
            var g = f[a];
            if (null != g) return "" != g.C ? sf(g, b, d, e) : P().W(a, b, d, e).then(function (a) {
                return new Z(g, a)
            });
            throw Error("printLabel2Async(): unknown printer '" + a + "'");
        })
    }

    v("dymo.label.framework.printLabel2Async", me);

    function sf(a, b, d, e) {
        function f(a, b) {
            var d = 4E3 * a, e = "";
            d >= k.length ? a = -1 : e = k.substr(d, 4E3);
            (new Me(h, "c")).send({j: g, cid: a, pl: e}, function (d) {
                var e = d.status, h = new Gc("dymo.label.framework");
                h.c = Kc;
                0 == e ? -1 != a ? f(++a, 0) : h.log(Kc, "Finished sending job payload for " + g, void 0) : -5 == e ? 10 > b ? f(++d.lastAckChunkId, ++b) : h.log(Jc, 'Unable to send print job data for "' + g + '": STATUS_INVALID_CHUNK_ID: Max retry count reached', void 0) : 10 > b ? f(a, ++b) : h.log(Jc, 'Unable to send print job data for "' + g + '": Max retry count reached',
                    void 0)
            }, function () {
                var d = new Gc("dymo.label.framework");
                d.c = Kc;
                10 > b ? f(a, ++b) : d.log(Jc, 'Unable to send print job data for "' + g + '": error: Max retry count reached', void 0)
            })
        }

        var g = Te();
        b = {printerName: a.c, labelXml: d, printParamsXml: b, labelSetXml: e};
        var h = Fd(a.C, "pl"), k = rc(b);
        f(0, 0);
        return new Z(a, g)
    }

    function ne(a, b, d, e, f, g) {
        function h(a) {
            if (f(k, a)) {
                var b = new Re(function () {
                    k.w(h);
                    Ob(b)
                }, g);
                Se(b)
            }
        }

        var k = le(a, b, d, e);
        k.w(h);
        return k
    }

    v("dymo.label.framework.printLabelAndPollStatus", ne);

    function oe(a, b, d, e, f, g) {
        return me(a, b, d, e).then(function (a) {
            function b(d) {
                if (f(a, d)) {
                    var e = new Re(function () {
                        a.w(b);
                        Ob(e)
                    }, g);
                    Se(e)
                }
            }

            a.w(b);
            return a
        })
    }

    v("dymo.label.framework.printLabelAndPollStatusAsync", oe);

    function he(a, b, d) {
        if ("undefined" == typeof a) throw Error("renderLabel(): labelXml parameter should be specified");
        "string" != typeof a && (a = a.toString());
        b = b || "";
        d = d || "";
        return P().renderLabel(a, b, d)
    }

    v("dymo.label.framework.renderLabel", he);

    function ie(a, b, d) {
        if ("undefined" == typeof a) throw Error("renderLabelAsync(): labelXml parameter should be specified");
        "string" != typeof a && (a = a.toString());
        b = b || "";
        d = d || "";
        return P().Y(a, b, d)
    }

    v("dymo.label.framework.renderLabelAsync", ie);
    v("dymo.label.framework.loadImageAsPngBase64", function (a) {
        return P().loadImageAsPngBase64(a)
    });
    v("dymo.label.framework.loadImageAsPngBase64Async", function (a) {
        return P().U(a)
    });
    v("dymo.label.framework.createLabelWriterPrintParamsXml", function (a) {
        if (!a) return "";
        var b = R("<LabelWriterPrintParams/>"), d = b.documentElement;
        a.copies && S(d, "Copies", a.copies.toString());
        a.jobTitle && S(d, "JobTitle", a.jobTitle);
        a.flowDirection && S(d, "FlowDirection", a.flowDirection);
        a.printQuality && S(d, "PrintQuality", a.printQuality);
        a.twinTurboRoll && S(d, "TwinTurboRoll", a.twinTurboRoll);
        return fe(b)
    });
    v("dymo.label.framework.createTapePrintParamsXml", function (a) {
        if (!a) return "";
        var b = R("<TapePrintParams/>"), d = b.documentElement;
        a.copies && S(d, "Copies", a.copies.toString());
        a.jobTitle && S(d, "JobTitle", a.jobTitle);
        a.flowDirection && S(d, "FlowDirection", a.flowDirection);
        a.alignment && S(d, "Alignment", a.alignment);
        a.cutMode && S(d, "CutMode", a.cutMode);
        return fe(b)
    });
    v("dymo.label.framework.createDZPrintParamsXml", function (a) {
        if (!a) return "";
        var b = R("<DZPrintParams/>"), d = b.documentElement;
        a.copies && S(d, "Copies", a.copies.toString());
        a.jobTitle && S(d, "JobTitle", a.jobTitle);
        a.flowDirection && S(d, "FlowDirection", a.flowDirection);
        a.alignment && S(d, "Alignment", a.alignment);
        a.cutMode && S(d, "CutMode", a.cutMode);
        return fe(b)
    });
    v("dymo.label.framework.createLabelRenderParamsXml", function (a) {
        function b(a, b) {
            S(e, a, void 0, {
                Alpha: b.a || b.alpha || 255,
                Red: b.r || b.red || 0,
                Green: b.g || b.green || 0,
                Blue: b.b || b.blue || 0
            })
        }

        if (!a) return "";
        var d = R("<LabelRenderParams/>"), e = d.documentElement;
        a.labelColor && b("LabelColor", a.labelColor);
        a.shadowColor && b("ShadowColor", a.shadowColor);
        "undefined" != typeof a.shadowDepth && S(e, "ShadowDepth", a.shadowDepth.toString());
        a.flowDirection && S(e, "FlowDirection", a.flowDirection);
        "undefined" != typeof a.pngUseDisplayResolution &&
        S(e, "PngUseDisplayResolution", a.pngUseDisplayResolution ? "True" : "False");
        return fe(d)
    });
})();
