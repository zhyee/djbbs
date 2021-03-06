/**
 * Created by zyee on 2017/3/17.
 */
/*!
 intel-appframework - v3.0.0 - 2015-10-23

 @author Ian Maffett
 @description jQuery helper functions for App Framework
 2011-2014 Intel
 @author Intel
 @version 3.0
 2014 Intel
 */
(function(a, h) {
    function g(a, c) {
        if (a) if (a.nodeType) c[c.length++] = a;
        else for (var d = 0,
                      b = a.length; d < b; d++) c[c.length++] = a[d]
    }
    function b(a, c) {
        a.os = {};
        a.os.webkit = c.match(/WebKit\/([\d.]+)/) ? !0 : !1;
        a.os.android = c.match(/(Android)\s+([\d.]+)/) || c.match(/Silk-Accelerated/) ? !0 : !1;
        a.os.androidICS = a.os.android && c.match(/(Android)\s4/) ? !0 : !1;
        a.os.ipad = c.match(/(iPad).*OS\s([\d_]+)/) ? !0 : !1;
        a.os.iphone = !a.os.ipad && c.match(/(iPhone\sOS)\s([\d_]+)/) ? !0 : !1;
        a.os.ios7 = a.os.ipad || a.os.iphone;
        a.os.webos = c.match(/(webOS|hpwOS)[\s\/]([\d.]+)/) ? !0 : !1;
        a.os.touchpad = a.os.webos && c.match(/TouchPad/) ? !0 : !1;
        a.os.ios = a.os.ipad || a.os.iphone;
        a.os.playbook = c.match(/PlayBook/) ? !0 : !1;
        a.os.blackberry10 = c.match(/BB10/) ? !0 : !1;
        a.os.blackberry = a.os.playbook || a.os.blackberry10 || c.match(/BlackBerry/) ? !0 : !1;
        a.os.chrome = c.match(/Chrome/) ? !0 : !1;
        a.os.opera = c.match(/Opera/) ? !0 : !1;
        a.os.fennec = c.match(/fennec/i) ? !0 : c.match(/Firefox/) ? !0 : !1;
        a.os.ie = c.match(/MSIE 10.0/i) || c.match(/Trident\/7/i) ? !0 : !1;
        a.os.ieTouch = a.os.ie && c.toLowerCase().match(/touch/i) ? !0 : !1;
        a.os.tizen = c.match(/Tizen/i) ? !0 : !1;
        a.os.supportsTouch = h.DocumentTouch && f instanceof h.DocumentTouch || "ontouchstart" in h;
        a.os.kindle = c.match(/Silk-Accelerated/) ? !0 : !1;
        a.feat = {};
        a.feat.cssTransformStart = !a.os.opera ? "3d(": "(";
        a.feat.cssTransformEnd = !a.os.opera ? ",0)": ")";
        a.os.android && !a.os.webkit && (a.os.android = !1);
        c.match(/IEMobile/i) && (a.each(a.os,
            function(c) {
                a.os[c] = !1
            }), a.os.ie = !0, a.os.ieTouch = !0);
        for (var d = ["Webkit", "Moz", "ms", "O"], b = 0; b < d.length; b++)"" === f.documentElement.style[d[b] + "Transform"] && (a.feat.cssPrefix = d[b])
    }
    jQuery.event.props.push("touches");
    jQuery.event.props.push("originalTouches");
    jQuery.event.props.push("changedTouches");
    var f = h.document,
        e = {},
        c = "object" === typeof MSApp;
    a.extend(a.fn, {
        vendorCss: function(c, d, b) {
            this.css(c.toLowerCase(), d, b);
            return this.css(a.feat.cssPrefix + c, d, b)
        },
        cssTranslate: function(c) {
            this.vendorCss("Transform", "translate" + a.feat.cssTransformStart + c + a.feat.cssTransformEnd)
        },
        computedStyle: function(a) {
            if (! (0 === this.length || void 0 == a)) return h.getComputedStyle(this[0], "")[a]
        },
        replaceClass: function(a, c) {
            if (void 0 == a || void 0 == c) return this;
            var d = function(a) {
                    f = f.replace(a in e ? e[a] : e[a] = RegExp("(^|\\s)" + a + "(\\s|$)"), " ")
                },
                b = 0;
            for (; b < this.length; b++) {
                var f = this[b].className;
                a.split(/\s+/g).concat(c.split(/\s+/g)).forEach(d);
                f = f.trim();
                this[b].className = 0 < f.length ? (f + " " + c).trim() : c
            }
            return this
        }
    });
    b(a, navigator.userAgent);
    a.__detectUA = b;
    a.uuid = function() {
        var a = function() {
            return (65536 * (1 + Math.random()) | 0).toString(16).substring(1)
        };
        return a() + a() + "-" + a() + "-" + a() + "-" + a() + "-" + a() + a() + a()
    };
    a.getCssMatrix = function(c) {
        a.is$(c) && (c = c.get(0));
        var d = h.WebKitCSSMatrix || h.MSCSSMatrix;
        if (void 0 === c) return d ? new d: {
            a: 0,
            b: 0,
            c: 0,
            d: 0,
            e: 0,
            f: 0
        };
        c = h.getComputedStyle(c);
        c = c.webkitTransform || c.transform || c[a.feat.cssPrefix + "Transform"];
        return d ? new d(c) : c ? (d = c.replace(/[^0-9\-.,]/g, "").split(","), {
            a: +d[0],
            b: +d[1],
            c: +d[2],
            d: +d[3],
            e: +d[4],
            f: +d[5]
        }) : {
            a: 0,
            b: 0,
            c: 0,
            d: 0,
            e: 0,
            f: 0
        }
    };
    a.create = function(d, b) {
        var e, k = new a;
        if (b || "<" !== d[0]) {
            b.html && (b.innerHTML = b.html, delete b.html);
            e = f.createElement(d);
            for (var h in b) e[h] = b[h];
            k[k.length++] = e
        } else e = f.createElement("div"),
            c ? MSApp.execUnsafeLocalFunction(function() {
                e.innerHTML = d.trim()
            }) : e.innerHTML = d,
            g(e.childNodes, k);
        return k
    };
    a.query = function(c, d) {
        try {
            return a(c, d)
        } catch(b) {
            return a()
        }
    };
    a.isObject = function(a) {
        return "object" === typeof a
    };
    a.is$ = function(c) {
        return c instanceof a
    };
    h.$afm = a;
    a.feat.TouchList = function() {
        this.length = 0
    };
    a.feat.TouchList.prototype = {
        item: function(a) {
            return this[a]
        },
        _add: function(a) {
            this[this.length] = a;
            this.length++
        }
    };
    var d = 1E3;
    a.feat.Touch = function() {
        this.identifier = d++
    };
    a.feat.Touch.prototype = {
        clientX: 0,
        clientY: 0,
        screenX: 0,
        screenY: 0,
        pageX: 0,
        pageY: 0,
        identifier: 0
    }
})(jQuery, window);
window.af = window.jq = jQuery; (function(a) {
    var h = window.location.pathname + window.location.search,
        g = function() {
            function c() {
                if (d.useOSThemes) {
                    var c = a(document.body);
                    c.removeClass("ios ios7 win8 tizen bb android light dark firefox");
                    a.os.android ? c.addClass("android") : a.os.ie ? c.addClass("win8") : a.os.blackberry || a.os.blackberry10 || a.os.playbook ? (c.addClass("bb"), d.backButtonText = "Back") : a.os.ios7 ? c.addClass("ios7") : a.os.ios ? c.addClass("ios7") : a.os.tizen ? c.addClass("tizen") : a.os.fennec && c.addClass("firefox")
                }
                a.os.ios7 && d.overlayStatusbar && d.ready(function() {
                    a(document.body).addClass("overlayStatusbar")
                })
            }
            var d = this;
            "function" === typeof define && define.amd ? (d.autoLaunch = !1, define("appframeworkui", [],
                function() {
                    return a.afui
                })) : "undefined" !== typeof module && module.exports && (d.autoLaunch = !1, a.afui = d);
            var b = function() {
                c();
                window.FastClick && FastClick.attach(document.documentElement)
            };
            if ("complete" === document.readyState || "loaded" === document.readyState) if (b(), d.init) d.autoBoot();
            else a(window).one("afui:init",
                    function() {
                        d.autoBoot()
                    });
            else a(document).ready(function() {
                    b();
                    if (d.init) d.autoBoot();
                    else a(window).one("afui:init",
                        function() {
                            d.autoBoot()
                        })
                },
                !1);
            window.addEventListener("popstate",
                function() {
                    if (d.useInternalRouting) {
                        var c = d.getPanelId(document.location.hash);
                        "#" !== document.location.href.replace(document.location.origin + "/", "") && ("" === c && 1 === d.history.length && (c = "#" + d.firstPanel.id), "" !== c && 0 !== a(c).filter(".panel").length && c !== "#" + d.activeDiv.id && d.goBack())
                    }
                },
                !1);
            window.addEventListener("orientationchange",
                function() {
                    window.scrollTo(0, 0)
                })
        },
        b = [];
    g.prototype = {
        init: !1,
        showLoading: !0,
        showingMask: !1,
        loadingText: "Loading Content",
        remotePages: {},
        history: [],
        views: {},
        _readyFunc: null,
        doingTransition: !1,
        ajaxUrl: "",
        transitionType: "slide",
        firstPanel: "",
        hasLaunched: !1,
        isLaunching: !1,
        launchCompleted: !1,
        activeDiv: "",
        customClickHandler: "",
        useOSThemes: !0,
        overlayStatusbar: !1,
        useAutoPressed: !0,
        useInternalRouting: !0,
        backButtonText: "Back",
        autoBoot: function() {
            this.hasLaunched = !0;
            this.autoLaunch && this.launch()
        },
        blockPageBounce: function(c) {
            a.os.ios && (!1 === c ? (window.removeEventListener("touchmove", this.handlePageBounce, !1), window.removeEventListener("touchstart", this.handlePageBounce, !1)) : (window.addEventListener("touchmove", this.handlePageBounce, !1), window.addEventListener("touchstart", this.handlePageBounce, !1)))
        },
        handlePageBounce: function(c) {
            if ("touchstart" === c.type) this._startTouchY = c.touches[0].screenY;
            else {
                var d = a(c.target).closest(".panel");
                if (0 === d.length) return c.preventDefault();
                var d = d.get(0),
                    b = d.scrollHeight > d.clientHeight,
                    f = "touch" === a(d).computedStyle("-webkit-overflow-scrolling"),
                    e = "hidden" !== a(d).computedStyle("overflowY"),
                    k = parseInt(a(d).computedStyle("height"), 10);
                b && (f && e) && (b = c.touches[0].screenY, k = this._startTouchY >= b && d.scrollHeight - d.scrollTop === k, (this._startTouchY <= b && 0 === d.scrollTop || k) && c.preventDefault())
            }
        },
        registerDataDirective: function(a, d) {
            b.push({
                sel: a,
                cb: d
            })
        },
        enableTabBar: function() {
            a(document).on("click", ".button-grouped.tabbed",
                function(c) {
                    var d = a(c.target);
                    d.closest(".tabbed").find(".button").data("ignore-pressed", "true").removeClass("pressed");
                    d.closest(".button").addClass("pressed");
                    setTimeout(function() {
                        d.closest(".button").addClass("pressed")
                    })
                })
        },
        disableTabBar: function() {
            a(document).off("click", ".button-grouped.tabbed");
            a(".button-grouped.tabbed .button").removeAttr("data-ignore-pressed")
        },
        manageHistory: !0,
        loadDefaultHash: !0,
        actionsheet: function(c) {
            return a.query(document.body).actionsheet(c)
        },
        popup: function(c) {
            return a.query(document.body).popup(c)
        },
        blockUI: function(c) {
            a.blockUI(c)
        },
        unblockUI: function() {
            a.unblockUI()
        },
        autoLaunch: !0,
        ready: function(c) {
            if (this.launchCompleted) c();
            else a(document).one("afui:ready",
                function() {
                    c()
                })
        },
        goBack: function(c) {
            var d = a(this.activeDiv).closest(".view");
            c && c.target && (d = a(c.target).closest(".view"));
            if (0 !== d.length && this.views[d.prop("id")]) {
                var b = this.views[d.prop("id")];
                if (0 !== b.length && (c = b.pop(), 0 !== c.length)) if (0 < b.length) {
                    if ((b = b[b.length - 1].target) && c.target !== b) this.runTransition(c.transition, c.target, b, !0),
                        this.loadContentData(b, d, !0),
                        this.updateHash(b.id)
                } else try {
                    this.dismissView(c.target, c.transition)
                } catch(f) {}
            }
        },
        clearHistory: function() {
            var a = this.findViewTarget(this.activeDiv);
            this.views[a.prop("id")] = [];
            this.setBackButtonVisibility(!1)
        },
        pushHistory: function(c, d, b, f) {
            try {
                this.manageHistory && (window.history.pushState(d, d, h + "#" + d + f), a(window).trigger("hashchange", null, {
                    newUrl: h + "#" + d + f,
                    oldUrl: h + c
                }))
            } catch(e) {}
        },
        updateHash: function(c) {
            if (this.manageHistory) {
                c = -1 === c.indexOf("#") ? "#" + c: c;
                var d = window.location.hash,
                    b = this.getPanelId(c).substring(1);
                try {
                    window.history.replaceState(b, b, h + c),
                        a(window).trigger("hashchange", null, {
                            newUrl: h + c,
                            oldUrl: h + d
                        })
                } catch(f) {}
            }
        },
        getPanelId: function(a) {
            var d = a.indexOf("/");
            return - 1 === d ? a: a.substring(0, d)
        },
        setBackButtonText: function(c) {
            a(this.activeDiv).closest(".view").find("header .backButton").html(c)
        },
        setTitle: function(c) {
            var d = "";
            "string" === typeof c ? (d = c, c = a(this.activeDiv).closest(".view")) : a(c).attr("data-title") ? d = a(c).attr("data-title") : a(c).attr("title") && (d = a(c).attr("title"));
            d && a(c).closest(".view").children("header").find("h1").html(d)
        },
        getTitle: function() {
            return a(this.activeDiv).closest(".view").children("header").find("h1").html()
        },
        setBackButtonVisibility: function(c) {
            a(this.activeDiv).closest(".view").children("header").find(".backButton").css("visibility", c ? "visible": "hidden")
        },
        updateBadge: function(c, d, b, f) {
            void 0 === b && (b = "");
            c = a(c);
            var e = c.find("span.af-badge");
            0 === e.length ? ("absolute" !== c.css("position") && c.css("position", "relative"), e = a.create("span", {
                className: "af-badge " + b,
                html: d
            }), c.append(e)) : e.html(d);
            e.removeClass("tl bl br tr");
            e.addClass(b);
            void 0 === f && (f = "red");
            a.isObject(f) ? e.css(f) : f && e.css("background", f);
            e.data("ignore-pressed", "true")
        },
        removeBadge: function(c) {
            a(c).find("span.af-badge").remove()
        },
        showMask: function(c) {
            c || (c = this.loadingText || "");
            a.query("#afui_mask>h1").html(c);
            a.query("#afui_mask").show();
            this.showingMask = !0;
            var d = this;
            setTimeout(function() {
                    d.showingMask && d.hideMask()
                },
                15E3)
        },
        hideMask: function() {
            a.query("#afui_mask").hide();
            this.showingMask = !1
        },
        dismissView: function(c, d) {
            d = d.replace(":dismiss", "");
            var b = a(c).closest(".view");
            this.runTransition(d, b, null, !0, a(c.hash).addClass("active").closest(".view"));
            this.activeDiv = a(".view").not(b).find(".panel.active").get(0);
            this.updateHash(this.activeDiv.id)
        },
        loadContent: function(a, d, b, f, e) {
            this.doingTransition || (e = e || null, 0 !== a.length && ( - 1 !== a.indexOf("#") ? this.loadDiv(a, d, b, f, e) : this.loadAjax(a, d, b, f, e)))
        },
        loadDiv: function(c, d, b, f, e) {
            var k = c,
                g = k.indexOf("#"),
                h = k.indexOf("/"); - 1 !== h && -1 !== g && h > g && (k = k.substr(0, h));
            k = k.replace("#", "");
            if (k = a.query("#" + k).get(0)) if (k === this.activeDiv && !b) this.doingTransition = !1;
            else {
                this.transitionType = f;
                var g = this.findViewTarget(k),
                    h = this.findPreviousPanel(k, g),
                    n = (e = e ? this.findViewTarget(e) : this.findViewTarget(this.activeDiv)) && e.get(0) !== g.get(0) && e.closest(".splitview").get(0) === g.closest(".splitview").get(0) && 0 !== e.closest(".splitview").length;
                n && (d = !1);
                a(k).trigger("panelbeforeload");
                a(h).trigger("panelbeforeunload");
                var s = !1;
                n || (n = 1 === e.parent().closest(".view").length);
                n && (e && e.get(0) !== g.get(0)) && a(e).trigger("nestedviewunload"); ! n && (d || e && e.get(0) !== g.get(0)) ? (this.runViewTransition(f, g, e || d, k, b), this.updateViewHistory(g, k, f, c), s = !0) : (this.runTransition(f, h, k, b), this.updateViewHistory(g, k, f, c));
                this.loadContentData(k, g, !1, s)
            } else a(document).trigger("missingpanel", null, {
                missingTarget: c
            }),
                this.doingTransition = !1
        },
        findViewTarget: function(c) {
            c = a(c).closest(".view");
            if (!c) return ! 1;
            this.views[c.prop("id")] || (this.views[c.prop("id")] = []);
            return c
        },
        findPreviousPanel: function(c, d) {
            var b = a(d).find(">.pages .panel.active").not(c);
            0 === b.length && (b = a(d).find(">.pages .panel:first-of-type"));
            return b.get(0)
        },
        loadContentData: function(a, d, b, e) {
            this.activeDiv = a;
            this.setTitle(a, d, b, e);
            this.showBackButton(d, e);
            this.setActiveTab(a, d)
        },
        setActiveTab: function(c, d) {
            var b;
            "string" !== typeof c && (b = a(c).prop("id"));
            if (! (0 === d.find("footer").find("a").filter("[href='" + b + "']").length && 0 === d.find("footer").find("a").filter("[href='#" + b + "']").length)) {
                var e = d.find("footer").find("a").removeClass("pressed").attr("data-ignore-pressed", "true");
                e.filter("[href='" + b + "']").addClass("pressed");
                e.filter("[href='#" + b + "']").addClass("pressed")
            }
        },
        showBackButton: function(a, d) {
            var b = this.views[a.prop("id")].length,
                e = a.children("header");
            0 !== e.length && (2 <= b && !0 !== d ? 1 !== e.find(".backButton").length && e.prepend("<a class='backButton back'>" + this.backButtonText + "</a>") : e.find(".backButton").remove())
        },
        loadAjax: function(c, d, b, f, g) {
            var k = this,
                h = e(c),
                q = a(".panel[data-crc='" + h + "']"),
                n = g.getAttribute("data-refresh");
            if (0 < q.length) if (n) k.showLoading && k.showMask("Loading Content"),
                a.ajax(c).then(function(a) {
                    q.html(a);
                    k.showLoading && k.hideMask();
                    return k.loadContent("#" + q.prop("id"), d, b, f, g)
                });
            else return k.loadContent("#" + q.prop("id"), d, b, f, g);
            k.showLoading && k.showMask("Loading Content");
            a.ajax(c).then(function(e) {
                e = a.create("div", {
                    html: e
                });
                e.hasClass(".panel") ? e = e.find(".panel") : (e = a(g).attr("data-title") ? e.attr("data-title", g.getAttribute("data-title")) : a(g).attr("title") ? e.attr("data-title", g.getAttribute("title")) : e.attr("data-title", c), e.prop("id", h), e.addClass("panel"));
                a(k.activeDiv).closest(".pages").append(e);
                e.attr("data-crc", h);
                k.showLoading && k.hideMask();
                k.loadContent("#" + e.prop("id"), d, b, f, g)
            }).fail(function(a) {
                k.showLoading && k.hideMask();
                console.log("Error with ajax request", a)
            })
        },
        runTransition: function(c, b, e, f, g) {
            c || (c = "slide"); - 1 !== c.indexOf(":back") && (c = c.replace(":back", ""), f = !0);
            var k = this,
                h = f ? b: e;
            b = f ? e: b;
            e = !1; - 1 !== c.indexOf("-reveal") && (c = c.replace("-reveal", ""), e = !0);
            a(h).css("zIndex", "10");
            a(b).css("zIndex", "1");
            a(g).css("zIndex", "1").addClass("active");
            var q = a(b).animation().remove(c + "-in"); ! e && q ? (f && q.reverse(), q.end(function() {
                f ? (this.classList.add("active"), a(this).trigger("panelload")) : (this.classList.remove("active"), a(this).trigger("panelunload"));
                k.doingTransition = !1
            }).run(c + "-out")) : f ? (a(b).trigger("panelload"), a(b).addClass("activeDiv")) : a(b).trigger("panelunload");
            h = a(h).animation().remove(c + "-out");
            f && h.reverse();
            h.end(function() {
                k.doingTransition = !1;
                f ? (g && a(g).css("zIndex", "10"), this.classList.remove("active"), a(this).trigger("panelunload")) : (this.classList.add("active"), a(this).trigger("panelload"), a(g).trigger("panelload"))
            }).run(c + "-in")
        },
        runViewTransition: function(c, b, e, f, g) {
            b.addClass("active");
            a(f).addClass("active");
            "none" === c ? (this.doingTransition = !1, setTimeout(function() {
                    e.removeClass("active");
                    b.addClass("active");
                    a(f).addClass("active")
                },
                50)) : this.runTransition(c, e, b, g, f)
        },
        updateViewHistory: function(a, b, e, f) {
            var g = this.views[a.prop("id")];
            g || (g = this.views[a.prop("id")] = []);
            1 <= g.length && g[g.length - 1].target === b || (this.pushHistory(b.id, b.id, e, f.replace(b.id, "").replace("#", "")), this.views[a.prop("id")].push({
                target: b,
                transition: e
            }))
        },
        launch: function() {
            if (!1 === this.hasLaunched || this.launchCompleted) this.hasLaunched = !0;
            else {
                if (this.isLaunching) return ! 0;
                this.isLaunching = !0;
                this.blockPageBounce();
                var c = this,
                    d = a.create("div", {
                        id: "afui_mask",
                        className: "ui-loader",
                        html: "<span class='ui-icon ui-icon-loading spin'></span><h1>Loading Content</h1>"
                    }).css({
                        "z-index": 2E4,
                        display: "none"
                    });
                document.body.appendChild(d.get(0));
                d = a(".view[data-default='true']");
                if (0 === d.length && (d = a(".view").eq(0), 0 === d.length)) throw "You need to create a view";
                d.addClass("active");
                this.views[d.prop("id")] = [];
                var e = window.location.hash,
                    g = 0 === d.find(".panel[data-selected='true']").length ? d.find(".panel").eq(0) : d.find(".panel[data-selected='true']");
                g.addClass("active");
                this.activeDiv = g.get(0);
                this.views[d.prop("id")].push({
                    target: g.get(0),
                    transition: this.transitionType
                });
                this.defaultPanel = g.get(0);
                this.loadContentData(g.get(0), d, !1, !0);
                this.updateHash(g.get(0).id);
                this.loadDefaultHash && setTimeout(function() {
                    this.loadContent(e, !1, 0, "none")
                }.bind(this));
                this.enableTabBar();
                a(document).on("click", "a",
                    function(a) {
                        c.useInternalRouting && f(a, a.currentTarget)
                    });
                a(document).on("click",
                    function(d) {
                        for (var e = b.length,
                                 f = a(d.target), g = 0; g < e; g++) {
                            var h = b[g],
                                m = f.closest(h.sel);
                            0 < m.length && h.cb.call(c, m.get(0), d)
                        }
                    });
                a(document).on("click", ".backButton, [data-back]",
                    function() {
                        c.useInternalRouting && c.goBack(c)
                    });
                d = a("[data-include]");
                if (0 === d.length) this.launchCompleted = !0,
                    a(document).trigger("afui:ready");
                else {
                    var h = [];
                    d.each(function() {
                        var c = this.getAttribute("data-include"),
                            b = a(this);
                        h.push(a.get(c,
                            function(a) {
                                b.append(a)
                            }))
                    });
                    a.when.apply(a, h).then(function() {
                        this.launchCompleted = !0;
                        a(document).trigger("afui:ready")
                    }).fail(function() {
                        this.launchCompleted = !0;
                        a(document).trigger("afui:ready")
                    })
                }
                a(document).on("click", "footer a:not(.button)",
                    function(c) {
                        c = a(c.target);
                        var b = c.closest("footer");
                        c.parent().find("a:not(.button)").attr("data-ignore-pressed", "true").removeClass("pressed");
                        "true" !== b.attr("data-ignore-pressed") && c.addClass("pressed")
                    })
            }
        }
    };
    var f = function(c, b) {
            b = b || c.currentTarget;
            if (b !== document) {
                if (!1 !== ("function" === typeof a.afui.customClickHandler ? a.afui.customClickHandler: !1) && a.afui.customClickHandler(b.getAttribute("href"), c)) return c.preventDefault();
                if ("a" !== b.tagName.toLowerCase() && b.parentNode) return f(c, b.parentNode);
                if ("undefined" !== b.tagName && "a" === b.tagName.toLowerCase() && !( - 1 !== b.href.toLowerCase().indexOf("javascript:") || b.getAttribute("data-ignore"))) {
                    var e = b.href,
                        g = location.protocol + "//" + location.hostname + ":" + location.port + location.pathname;
                    0 === e.indexOf(g) && (e = e.substring(g.length));
                    if ("#" === e || e.indexOf("#") === e.length - 1 || 0 === e.length && 0 === b.hash.length) return c.preventDefault();
                    g = /^((http|https|file):\/\/)/; - 1 !== b.href.indexOf(":") && g.test(b.href) && c.preventDefault();
                    g = b.getAttribute("data-transition"); ! g && 0 < a(b).closest("footer").length && (g = "none");
                    if (g && -1 !== g.indexOf(":dismiss")) return a.afui.dismissView(b, g);
                    e = 0 < b.hash.length ? b.hash: e;
                    a.afui.loadContent(e, !1, 0, g, b)
                }
            }
        },
        e = function(a, b) {
            void 0 === b && (b = 0);
            var e = 0,
                e = 0;
            b ^= -1;
            for (var f = 0,
                     g = a.length; f < g; f++) e = (b ^ a.charCodeAt(f)) & 255,
                e = "0x" + "00000000 77073096 EE0E612C 990951BA 076DC419 706AF48F E963A535 9E6495A3 0EDB8832 79DCB8A4 E0D5E91E 97D2D988 09B64C2B 7EB17CBD E7B82D07 90BF1D91 1DB71064 6AB020F2 F3B97148 84BE41DE 1ADAD47D 6DDDE4EB F4D4B551 83D385C7 136C9856 646BA8C0 FD62F97A 8A65C9EC 14015C4F 63066CD9 FA0F3D63 8D080DF5 3B6E20C8 4C69105E D56041E4 A2677172 3C03E4D1 4B04D447 D20D85FD A50AB56B 35B5A8FA 42B2986C DBBBC9D6 ACBCF940 32D86CE3 45DF5C75 DCD60DCF ABD13D59 26D930AC 51DE003A C8D75180 BFD06116 21B4F4B5 56B3C423 CFBA9599 B8BDA50F 2802B89E 5F058808 C60CD9B2 B10BE924 2F6F7C87 58684C11 C1611DAB B6662D3D 76DC4190 01DB7106 98D220BC EFD5102A 71B18589 06B6B51F 9FBFE4A5 E8B8D433 7807C9A2 0F00F934 9609A88E E10E9818 7F6A0DBB 086D3D2D 91646C97 E6635C01 6B6B51F4 1C6C6162 856530D8 F262004E 6C0695ED 1B01A57B 8208F4C1 F50FC457 65B0D9C6 12B7E950 8BBEB8EA FCB9887C 62DD1DDF 15DA2D49 8CD37CF3 FBD44C65 4DB26158 3AB551CE A3BC0074 D4BB30E2 4ADFA541 3DD895D7 A4D1C46D D3D6F4FB 4369E96A 346ED9FC AD678846 DA60B8D0 44042D73 33031DE5 AA0A4C5F DD0D7CC9 5005713C 270241AA BE0B1010 C90C2086 5768B525 206F85B3 B966D409 CE61E49F 5EDEF90E 29D9C998 B0D09822 C7D7A8B4 59B33D17 2EB40D81 B7BD5C3B C0BA6CAD EDB88320 9ABFB3B6 03B6E20C 74B1D29A EAD54739 9DD277AF 04DB2615 73DC1683 E3630B12 94643B84 0D6D6A3E 7A6A5AA8 E40ECF0B 9309FF9D 0A00AE27 7D079EB1 F00F9344 8708A3D2 1E01F268 6906C2FE F762575D 806567CB 196C3671 6E6B06E7 FED41B76 89D32BE0 10DA7A5A 67DD4ACC F9B9DF6F 8EBEEFF9 17B7BE43 60B08ED5 D6D6A3E8 A1D1937E 38D8C2C4 4FDFF252 D1BB67F1 A6BC5767 3FB506DD 48B2364B D80D2BDA AF0A1B4C 36034AF6 41047A60 DF60EFC3 A867DF55 316E8EEF 4669BE79 CB61B38C BC66831A 256FD2A0 5268E236 CC0C7795 BB0B4703 220216B9 5505262F C5BA3BBE B2BD0B28 2BB45A92 5CB36A04 C2D7FFA7 B5D0CF31 2CD99E8B 5BDEAE1D 9B64C2B0 EC63F226 756AA39C 026D930A 9C0906A9 EB0E363F 72076785 05005713 95BF4A82 E2B87A14 7BB12BAE 0CB61B38 92D28E9B E5D5BE0D 7CDCEFB7 0BDBDF21 86D3D2D4 F1D4E242 68DDB3F8 1FDA836E 81BE16CD F6B9265B 6FB077E1 18B74777 88085AE6 FF0F6A70 66063BCA 11010B5C 8F659EFF F862AE69 616BFFD3 166CCF45 A00AE278 D70DD2EE 4E048354 3903B3C2 A7672661 D06016F7 4969474D 3E6E77DB AED16A4A D9D65ADC 40DF0B66 37D83BF0 A9BCAE53 DEBB9EC5 47B2CF7F 30B5FFE9 BDBDF21C CABAC28A 53B39330 24B4A3A6 BAD03605 CDD70693 54DE5729 23D967BF B3667A2E C4614AB8 5D681B02 2A6F2B94 B40BBE37 C30C8EA1 5A05DF1B 2D02EF8D".substr(9 * e, 8),
                b = b >>> 8 ^ e;
            return (b ^ -1) >>> 0
        };
    a.afui = new g;
    a.afui.init = !0;
    a(window).trigger("afui:preinit");
    a(window).trigger("afui:init")
})(jQuery); (function(a) {
    a.fn.actionsheet = function(a) {
        for (var b, f = 0; f < this.length; f++) b = new h(this[f], a);
        return 1 === this.length ? b: this
    };
    var h = function(g, b) {
        if (this.el = "string" === typeof g || g instanceof String ? document.getElementById(g) : g) {
            if (this instanceof h) {
                if ("object" === typeof b) for (var f in b) this[f] = b[f]
            } else return new h(g, b);
            var e;
            f = function() {};
            if ("string" === typeof b) e = a("<div id='af_actionsheet'><div style='width:100%'>" + b + "<a href='javascript:;' class='cancel'>Cancel</a></div></div>");
            else if ("object" === typeof b) {
                e = a("<div id='af_actionsheet'><div style='width:100%'></div></div>");
                var c = a(e.children().get(0));
                b.push({
                    text: "Cancel",
                    cssClasses: "cancel"
                });
                for (var d = 0; d < b.length; d++) {
                    var m = a("<a href='javascript:;'>" + (b[d].text || "TEXT NOT ENTERED") + "</a>");
                    m[0].onclick = b[d].handler || f;
                    b[d].cssClasses && 0 < b[d].cssClasses.length && m.addClass(b[d].cssClasses);
                    c.append(m)
                }
            }
            a(g).find("#af_actionsheet").remove();
            a(g).find("#af_action_mask").remove();
            a(g).append(e);
            e.vendorCss("Transition", "all 0ms");
            this.el.style.overflow = "hidden";
            e.on("click", "a", this.sheetClickHandler.bind(this));
            this.activeSheet = e;
            e.cssTranslate("0," + e.height() + "px");
            a(g).append("<div id='af_action_mask' style='position:absolute;top:0px;left:0px;right:0px;bottom:0px;z-index:9998;background:rgba(0,0,0,.4)'/>");
            setTimeout(function() {
                    e.vendorCss("Transition", "all 300ms");
                    e.cssTranslate("0,0")
                },
                10);
            a("#af_action_mask").bind("touchstart touchmove touchend click",
                function(a) {
                    a.preventDefault();
                    a.stopPropagation()
                })
        } else window.alert("Could not find element for actionsheet " + g)
    };
    h.prototype = {
        activeSheet: null,
        sheetClickHandler: function() {
            this.hideSheet();
            return ! 1
        },
        hideSheet: function() {
            this.activeSheet.off("click", "a", this.sheetClickHandler);
            a(this.el).find("#af_action_mask").unbind("click").remove();
            this.activeSheet.vendorCss("Transition", "all 0ms");
            var g = this.activeSheet,
                b = this.el;
            setTimeout(function() {
                    g.vendorCss("Transition", "all 300ms");
                    g.cssTranslate("0," + (g.height() + 60) + "px");
                    setTimeout(function() {
                            g.remove();
                            g = null;
                            b.style.overflow = "none"
                        },
                        350)
                },
                10)
        }
    };
    a.afui.actionsheet = function(g) {
        return a(document.body).actionsheet(g)
    }
})(jQuery); (function(a) {
    a.afui.registerDataDirective("[data-grower]",
        function(h, g) {
            var b = a(h).closest("[data-grower]"),
                f = b.offset(),
                e = b.closest(".view"),
                c = g.target.hash || b.attr("data-grower");
            e.css("zIndex", "1");
            var d = a(c).closest(".view"),
                m = b.width() / window.innerWidth,
                l = b.height() / window.innerHeight,
                p = {
                    left: f.left,
                    top: f.top,
                    x: m,
                    y: l
                };
            a(c).trigger("panelgrowstart", [b.get(0)]);
            d.addClass("active").css("zIndex", "10");
            d.vendorCss("TransformOrigin", "0 0");
            d.data("growTransProps", p);
            d.vendorCss("TransitionDuration", "0");
            d.vendorCss("Transform", "translate3d(" + f.left + "px," + f.top + "px,0) scale(" + m + "," + l + ")");
            d.data("growTarget", b.closest(".panel"));
            d.data("growFrom", a(c).attr("id"));
            a.afui.loadContent(c, e, !1, "stretch");
            a(c).one("panelload",
                function() {
                    d.vendorCss("Transform", "");
                    a(c).trigger("panelgrowcomplete", [b.get(0)])
                })
        });
    a.afui.registerDataDirective("[data-grower-back]",
        function(h) {
            var g = a(h).closest(".view"),
                b = a("#" + g.data("growFrom"));
            b.trigger("panelgrowendstart");
            h = g.data("growTransProps");
            var f = "#" + g.data("growTarget").prop("id");
            a(f).closest(".view").addClass("active");
            g.addClass("animation-active");
            g.transition().end(function() {
                g.removeClass("active");
                b.trigger("panelgrowendstart");
                a.afui.loadContent(f, !1, !1, "none")
            }).run("translate3d(" + h.left + "px," + h.top + "px,0) scale(" + h.x + "," + h.y + ")", "300ms")
        })
})(jQuery); (function(a) {
    function h(a, b, c, e) {
        var d = Math.abs(a - b),
            f = Math.abs(c - e);
        return d >= f ? 0 < a - b ? "Left": "Right": 0 < c - e ? "Up": "Down"
    }
    function g() {
        b.last && Date.now() - b.last >= e && (b.el.trigger("longTap"), b = {})
    }
    var b = {},
        f, e = 750,
        c, d = !1,
        m = !1;
    a(document).ready(function() {
        var l;
        a(document.body).bind("touchstart",
            function(h) {
                h.originalEvent && (h = h.originalEvent);
                if (h.touches && 0 !== h.touches.length) {
                    var k = Date.now(),
                        r = k - (b.last || k);
                    h.touches && 0 !== h.touches.length && (b.el = a("tagName" in h.touches[0].target ? h.touches[0].target: h.touches[0].target.parentNode), f && clearTimeout(f), b.x1 = h.touches[0].pageX, b.y1 = h.touches[0].pageY, b.x2 = b.y2 = 0, 0 < r && 250 >= r && (b.isDoubleTap = !0), b.last = k, c = setTimeout(g, e), a.afui.useAutoPressed && !b.el.attr("data-ignore-pressed") && b.el.addClass("pressed"), l && (a.afui.useAutoPressed && !l.attr("data-ignore-pressed") && l[0] !== b.el[0]) && l.removeClass("pressed"), l = b.el, m = d = !1)
                }
            }).bind("touchmove",
            function(e) {
                e.originalEvent && (e = e.originalEvent);
                b.x2 = e.touches[0].pageX;
                b.y2 = e.touches[0].pageY;
                if (!m && (5 < Math.abs(b.x2 - b.x1) || 5 < Math.abs(b.y2 - b.y1))) {
                    var f = 5 < Math.abs(b.x2 - b.x1),
                        g = 5 < Math.abs(b.y2 - b.y1);
                    m = !0;
                    b.el.trigger("swipeStart", [e]);
                    b.el.trigger("swipeStart" + h(b.x1, b.x2, b.y1, b.y2), [b, e]);
                    var l = b.el.closest(".swipe, .swipe-reveal, .swipe-x, .swipe-y"),
                        n = b.el.closest(".x-scroll, .y-scroll, .scroll");
                    d = 0 !== b.el.closest(".swipe, .swipe-reveal").length;
                    0 !== n.parent(l).length ? d = !1 : f && 0 !== b.el.closest(".swipe-x").length ? d = !0 : g && 0 !== b.el.closest(".swipe-y").length && (d = !0)
                }
                a.os.android && m && d && e.preventDefault();
                clearTimeout(c)
            }).bind("touchend",
            function(c) {
                c.originalEvent && (c = c.originalEvent);
                if (b.el) if (a.afui.useAutoPressed && !b.el.attr("data-ignore-pressed") && b.el.removeClass("pressed"), b.isDoubleTap) b.el.trigger("doubleTap"),
                    b = {};
                else if ((0 < b.x2 || 0 < b.y2) && (30 < Math.abs(b.x1 - b.x2) || 30 < Math.abs(b.y1 - b.y2))) {
                    b.el.trigger("swipe");
                    c = h(b.x1, b.x2, b.y1, b.y2);
                    var e = ".x-scroll",
                        d = ".swipe-x";
                    if ("up" === c.toLowerCase() || "down" === c.toLowerCase()) e = ".y-scroll",
                        d = ".swipe-y";
                    d = b.el.closest(d);
                    e = b.el.closest(e); (0 === d.length || 0 === e.length || 0 === d.find(e).length) && b.el.trigger("swipe" + c);
                    b.x1 = b.x2 = b.y1 = b.y2 = b.last = 0
                } else "last" in b && (b.el.trigger("tap"), f = setTimeout(function() {
                        f = null;
                        b.el && b.el.trigger("singleTap");
                        b = {}
                    },
                    250))
            }).bind("touchcancel",
            function() {
                b.el && (a.afui.useAutoPressed && !b.el.attr("data-ignore-pressed")) && b.el.removeClass("pressed");
                b = {};
                clearTimeout(c)
            })
    });
    "swipe swipeLeft swipeRight swipeUp swipeDown doubleTap tap singleTap longTap".split(" ").forEach(function(b) {
        a.fn[b] = function(a) {
            return this.bind(b, a)
        }
    })
})(jQuery); (function(a) {
    var h = a.afui.setTitle;
    a.afui.animateHeader = function(g) {
        a.afui.setTitle = !1 !== g ?
            function(b, f, e, c) {
                var d;
                "string" === typeof b ? d = b: a(b).attr("data-title") ? d = a(b).attr("data-title") : a(b).attr("title") && (d = a(b).attr("title"));
                d && 0 !== d.length && (b = a(this.activeDiv).closest(".view").children("header").eq(0), e = e ? "header-unload": "header-load", f = b.find("h1").eq(0).html(), b.find("h1").eq(0).html(d).removeClass("header-unload header-load"), c || (b.find("h1").animation().run(e + "-to"), c = a("<h1>" + f + "</h1>"), b.append(c), c.animation().end(function() {
                    a(this).remove()
                }).run(e)))
            }: h
    }
})(jQuery); (function(a) {
    a.fn.popup = function(a) {
        return new g(this[0], a)
    };
    var h = [],
        g = function(b, e) {
            if (this.container = "string" === typeof b || b instanceof String ? document.getElementById(b) : b) try {
                if ("string" === typeof e || "number" === typeof e) e = {
                    message: e,
                    cancelOnly: "true",
                    cancelText: "OK"
                };
                this.id = e.id = e.id || a.uuid();
                this.addCssClass = e.addCssClass ? e.addCssClass: "";
                this.suppressTitle = e.suppressTitle || this.suppressTitle;
                this.title = e.suppressTitle ? "": e.title || "Alert";
                this.message = e.message || "";
                this.cancelText = e.cancelText || "Cancel";
                this.cancelCallback = e.cancelCallback ||
                    function() {};
                this.cancelClass = e.cancelClass || "button";
                this.doneText = e.doneText || "Done";
                this.doneCallback = e.doneCallback ||
                    function() {};
                this.doneClass = e.doneClass || "button";
                this.cancelOnly = e.cancelOnly || !1;
                this.onShow = e.onShow ||
                    function() {};
                this.autoCloseDone = void 0 !== e.autoCloseDone ? e.autoCloseDone: !0;
                h.push(this);
                1 === h.length && this.show()
            } catch(c) {
                console.log("error adding popup " + c)
            } else window.alert("Error finding container for popup " + b)
        };
    g.prototype = {
        id: null,
        addCssClass: null,
        title: null,
        message: null,
        cancelText: null,
        cancelCallback: null,
        cancelClass: null,
        doneText: null,
        doneCallback: null,
        doneClass: null,
        cancelOnly: !1,
        onShow: null,
        autoCloseDone: !0,
        suppressTitle: !1,
        show: function() {
            var b = this,
                e = a("<div id='" + this.id + "' class='afPopup hidden " + this.addCssClass + "'><header>" + this.title + "</header><div>" + this.message + "</div><footer><a href='javascript:;' class='" + this.cancelClass + "' id='cancel'>" + this.cancelText + "</a><a href='javascript:;' class='" + this.doneClass + "' id='action'>" + this.doneText + "</a><div style='clear:both'></div></footer></div>");
            a(this.container).append(e);
            e.bind("close",
                function() {
                    b.hide()
                });
            this.cancelOnly && (e.find("A#action").hide(), e.find("A#cancel").addClass("center"));
            e.find("A").each(function() {
                var c = a(this);
                c.bind("click",
                    function(a) {
                        "cancel" === c.attr("id") ? (b.cancelCallback.call(b.cancelCallback, b), b.hide()) : (b.doneCallback.call(b.doneCallback, b), b.autoCloseDone && b.hide());
                        a.preventDefault()
                    })
            });
            b.positionPopup();
            a.blockUI(0.5);
            e.bind("orientationchange",
                function() {
                    b.positionPopup()
                });
            e.find("header").show();
            e.find("footer").show();
            setTimeout(function() {
                    e.removeClass("hidden").addClass("show");
                    b.onShow(b)
                },
                50)
        },
        hide: function() {
            var b = this;
            a.query("#" + b.id).addClass("hidden");
            a.unblockUI(); ! a.os.ie && !a.os.android ? setTimeout(function() {
                    b.remove()
                },
                250) : b.remove()
        },
        remove: function() {
            var b = a.query("#" + this.id);
            b.unbind("close");
            b.find("BUTTON#action").unbind("click");
            b.find("BUTTON#cancel").unbind("click");
            b.unbind("orientationchange").remove();
            h.splice(0, 1);
            0 < h.length && h[0].show()
        },
        positionPopup: function() {
            var b = a.query("#" + this.id);
            b.css("top", window.innerHeight / 2.5 + window.pageYOffset - b[0].clientHeight / 2 + "px");
            b.css("left", window.innerWidth / 2 - b[0].clientWidth / 2 + "px")
        }
    };
    var b = !1;
    a.blockUI = function(f) {
        b || (f = f ? " style='opacity:" + f + ";'": "", a.query("BODY").prepend(a("<div id='mask'" + f + "></div>")), a.query("BODY DIV#mask").bind("touchstart",
            function(a) {
                a.preventDefault()
            }), a.query("BODY DIV#mask").bind("touchmove",
            function(a) {
                a.preventDefault()
            }), b = !0)
    };
    a.unblockUI = function() {
        b = !1;
        a.query("BODY DIV#mask").unbind("touchstart");
        a.query("BODY DIV#mask").unbind("touchmove");
        a("BODY DIV#mask").remove()
    };
    a.afui.registerDataDirective("[data-alert]",
        function(b) {
            b = a(b).attr("data-message");
            0 !== b.length && a(document.body).popup(b)
        });
    a.afui.popup = function(b) {
        return a(document.body).popup(b)
    }
})(jQuery); (function(a) {
    function h(a) {
        this.element = a;
        this.element.classList.remove("animation-reverse");
        this.keepClass = !1
    }
    function g(a) {
        this.element = a;
        this.element
    }
    a.fn.animation = function() {
        var a = this;
        this.each(function() {
            a = new h(this)
        });
        return a
    };
    var b = function(a) {
        this.element.removeEventListener("webkitAnimationEnd", this.endCBCache, !1);
        this.element.removeEventListener("animationend", this.endCBCache, !1);
        this.element.removeEventListener("MSAnimationEnd", this.endCBCache, !1);
        this.endcb && this.endcb.call(this.element, a);
        this.element.classList.remove("animation-reverse");
        this.element.classList.remove("animation-active");
        this.keepClass || this.element.classList.remove(this.animClass)
    };
    h.prototype = {
        element: null,
        animClass: null,
        runEnd: !1,
        keepClass: !1,
        keep: function() {
            this.keepClass = !0;
            return this
        },
        remove: function(a) {
            this.element.classList.remove(a);
            this.element.offsetWidth = this.element.offsetWidth;
            return this
        },
        endCBCache: null,
        run: function(a, c) {
            this.runEnd = !1;
            this.element.classList.add("animation-active");
            this.element.offsetWidth = this.element.offsetWidth;
            this.element.classList.add(a);
            this.animClass = a;
            var d = window.getComputedStyle(this.element, null),
                f = d.animation - c;
            f || (f = d.animationDuration);
            f || (f = d.MozAnimationDuration);
            f || (f = d.webkitAnimationDuration);
            f = parseFloat(f);
            if (0.01 >= f || isNaN(f)) this.runEnd = !0;
            this.endCBCache = b.bind(this);
            if (this.runEnd) return this.endCBCache(),
                this;
            this.element.addEventListener("webkitAnimationEnd", this.endCBCache, !1);
            this.element.addEventListener("animationend", this.endCBCache, !1);
            this.element.addEventListener("MSAnimationEnd", this.endCBCache, !1);
            return this
        },
        reverse: function() {
            this.element.classList.add("animation-reverse");
            return this
        },
        reRun: function(a) {
            this.remove(a);
            return this.run(a)
        },
        endcb: function() {},
        end: function(a) {
            this.endcb = a;
            return this
        }
    };
    a.fn.transition = function() {
        var a = this;
        this.each(function() {
            a = new g(this)
        });
        return a
    };
    var f = function(b) {
        clearTimeout(this.timer);
        this.element.removeEventListener("webkitTransitionEnd", this.endCBCache, !1);
        this.element.removeEventListener("transitionend", this.endCBCache, !1);
        this.element.removeEventListener("MSTransitionEnd", this.endCBCache, !1);
        this.endcb && this.endcb.call(this.element, b);
        this.keepEnd || (a(this.element).vendorCss("TransitionDuration", ""), a(this.element).vendorCss("Transform", ""))
    };
    g.prototype = {
        element: null,
        runEnd: !1,
        keepEnd: !1,
        keep: function() {
            this.keepEnd = !0;
            return this
        },
        endCBCache: null,
        timer: null,
        run: function(b, c) {
            this.endCBCache = f.bind(this);
            this.element.addEventListener("webkitTransitionEnd", this.endCBCache, !1);
            this.element.addEventListener("transitionend", this.endCBCache, !1);
            this.element.addEventListener("MSTransitionEnd", this.endCBCache, !1);
            a(this.element).vendorCss("TransitionDuration", c);
            a(this.element).vendorCss("Transform", b);
            this.timer = setTimeout(function() {
                this.endCBCache()
            }.bind(this), parseInt(c, 10) + 50);
            return this
        },
        endcb: function() {},
        end: function(a) {
            this.endcb = a;
            return this
        }
    }
})(jQuery); (function(a) {
    a.afui.ready(function() {
        setTimeout(function() {
                a("#splashscreen").remove()
            },
            250)
    })
})(jQuery); (function(a) {
    function h() {
        return this
    }
    var g = null,
        b, f = {
            push: function(b, c, d) {
                b = a(b).closest(".view").children().filter(":not(nav):not(aside)");
                d = d || g;
                for (var f = 0; f < b.length; f++) {
                    var h = a(b[f]).show().animation();
                    c ? h.remove("slide-" + d + "-out").reverse() : h.keep();
                    h.run("slide-" + d + "-out")
                }
            },
            cover: function() {},
            reveal: function(a, b) {
                return this.push(a, b)
            }
        };
    h.prototype = {
        defaultTransition: "slide",
        defaultAnimation: "cover",
        isTransitioning: !1,
        autoHide: function(a) {
            a.preventDefault();
            this.hide()
        },
        checkViewToClose: function(a) {
            this.autoHide(a)
        },
        autoHideCheck: null,
        selfCheckViewToClose: null,
        show: function(e, c, d) {
            if (!this.isTransitioning) {
                var h = this;
                g = "right" === c ? "right": "left";
                d = f[d] ? d: this.defaultAnimation;
                var l = document.getElementById(e.replace("#", ""));
                l && (b = l, l.classList.contains("active") || (this.isTransitioning = !0, this.autoHideCheck = this.autoHide.bind(this), a(l).closest(".view").children().filter(":not(nav):not(aside)").off("touchstart", this.autoHideCheck), l.classList.add(g), e = a(l).show(), c = "right" === g ? "left": "right", 0 < a(l).closest(".view").find(".slide-" + c + "-out").length && (a(l).closest(".view").find(".slide-" + c + "-out").removeClass("slide-" + c + "-out"), a(l).closest(".view").find("aside.active, nav.active").removeClass("left right active").hide()), "reveal" !== d ? e.css("zIndex", "999").animation().run("slide-" + g + "-in").end(function() {
                    this.classList.add("active");
                    h.isTransitioning = !1
                }) : e.animation().run("blank").end(function() {
                    a(this).css("zIndex", "999");
                    this.classList.add("active");
                    h.isTransitioning = !1
                }), l.activeAnimation = d, l.activePosition = g, l.toggled = !0, f[d](l, !1), setTimeout(function() {
                    a(l).closest(".view").children().filter(":not(nav):not(aside)").on("touchstart", h.autoHideCheck)
                }), this.selfCheckViewToClose = h.checkViewToClose.bind(this), a(l).bind("nestedviewunload", this.selfCheckViewToClose)))
            }
        },
        hide: function(e, c) {
            if (!this.isTransitioning) {
                var d = this,
                    g = e && document.getElementById(e.replace("#", "")) || b;
                a(g).unbind("nestedviewunload", this.selfCheckViewToClose);
                if (g && g.toggled) {
                    a(g).closest(".view").children().filter(":not(nav):not(aside)").off("touchstart", this.autoHideCheck);
                    var h = c || g.activePosition,
                        p = a(g).animation();
                    "reveal" === g.activeAnimation && a(g).css("zIndex", "1");
                    var k = "reveal" === g.activeAnimation ? "blank": "slide-" + h + "-in";
                    p.reverse().reRun(k).end(function() {
                        this.classList.remove("active");
                        this.classList.remove(h);
                        this.style.display = "none";
                        this.style.zIndex = "";
                        d.isTransitioning = !1
                    });
                    if (f[g.activeAnimation]) f[g.activeAnimation](g, !0);
                    g.toggled = !1;
                    b = null
                }
            }
        }
    };
    a.afui.drawer = new h;
    a.afui.registerDataDirective("[data-left-menu]:not([data-menu-close]),[data-right-menu]:not([data-menu-close])",
        function(b) {
            var c = a(b);
            b = c.attr("data-left-menu") ? "left": "right";
            var d = "left" === b ? c.attr("data-left-menu") : c.attr("data-right-menu"),
                c = c.attr("data-transition");
            this.drawer.show(d, b, c)
        });
    a.afui.registerDataDirective("[data-menu-close]",
        function(b) {
            var c = a(b),
                d = null;
            c.attr("data-left-menu") && (d = "left");
            c.attr("data-right-menu") && (d = "right");
            c = "left" === d ? c.attr("data-left-menu") : c.attr("data-right-menu");
            if (!c && (c = a(b).closest("nav").prop("id"), !c || 0 === c.length)) c = a(b).closest(".view").find("nav.active,aside.active").prop("id");
            this.drawer.hide(c, d)
        })
})(jQuery); (function(a) {
    var h, g = 0,
        b, f;
    a.afui.swipeThreshold = 0.3;
    a(document).on("swipeStartLeft", ".swipe-reveal",
        function(c, d, m) {
            m.preventDefault();
            h = a(c.target).closest(".swipe-content");
            g = d.x2;
            f = h.closest(".swipe-reveal").find(".swipe-hidden").width();
            0 === a.getCssMatrix(c.target).e && (h.bind("touchmove", e), h.one("touchend",
                function() {
                    h.unbind("touchmove", e);
                    Math.abs(b) / f < a.afui.swipeThreshold && (f = 0);
                    h.transition().keep().end(function() {
                        h = f = null
                    }).run("translate3d(" + -f + "px,0px,0)", "100ms")
                }))
        });
    a(document).on("swipeStartRight", ".swipe-reveal",
        function(c, d, m) {
            m.preventDefault();
            h = a(c.target).closest(".swipe-content");
            f = h.closest(".swipe-reveal").find(".swipe-hidden").width();
            0 === a(c.target).parents(".swipe-content").length && 0 === a.getCssMatrix(c.target).e || (g = d.x2 + f, h.bind("touchmove", e), h.one("touchend",
                function() {
                    h.unbind("touchmove", e);
                    1 - Math.abs(b) / f > a.afui.swipeThreshold && (f = 0);
                    h.transition().keep().end(function() {
                        h = f = null
                    }).run("translate3d(" + -f + "px,0px,0)", "100ms")
                }))
        });
    var e = function(a) {
        a = -(g - a.touches[0].pageX);
        a < -f ? a = "-" + f: 0 < a && (a = 0);
        b = a;
        h.cssTranslate(a + "px,0")
    }
})(jQuery); (function(a) {
    var h = !1;
    if (!a.os.supportsTouch) {
        try {
            document.createEvent("TouchEvent");
            return
        } catch(g) {}
        a.os.supportsTouch = !0;
        var b = function(a) {
                a.preventDefault();
                a.stopPropagation()
            },
            f = navigator.userAgent.match(/Phone/i) ? 2 : 7,
            e = function(a, c) {
                var d = c.tagName.toUpperCase(); - 1 < d.indexOf("SELECT") || ( - 1 < d.indexOf("OPTION") || -1 < d.indexOf("TEXTAREA") || -1 < d.indexOf("INPUT")) || b(a)
            },
            c = function(b, c, d, f) {
                d = d ? d: c.target;
                f || e(c, d);
                f = document.createEvent("MouseEvent");
                f.initEvent(b, !0, !0);
                f.initMouseEvent(b, !0, !0, window, c.detail, c.screenX, c.screenY, c.clientX, c.clientY, c.ctrlKey, c.shiftKey, c.altKey, c.metaKey, c.button, c.relatedTarget);
                f.touches = new a.feat.TouchList;
                f.changedTouches = new a.feat.TouchList;
                f.targetTouches = new a.feat.TouchList;
                var g = new a.feat.Touch;
                g.pageX = c.pageX;
                g.pageY = c.pageY;
                g.target = c.target;
                f.changedTouches._add(g);
                "touchend" !== b && (f.touches = f.changedTouches, f.targetTouches = f.changedTouches);
                f.mouseToTouch = !0;
                if (a.os.ie) for (c = c.target; null !== c;) c.hasAttribute("on" + b) && eval(c.getAttribute("on" + b)),
                    c = c.parentElement;
                d.dispatchEvent(f)
            },
            d = !1,
            m = null,
            l = 0,
            p = 0;
        window.navigator.msPointerEnabled ? (document.addEventListener("MSPointerDown",
            function(a) {
                d = !0;
                m = a.target;
                "a" === a.target.nodeName.toLowerCase() && "javascript:;" === a.target.href.toLowerCase() && (a.target.href = "");
                c("touchstart", a, null, !0);
                h = !1;
                l = a.clientX;
                p = a.clientY;
                return ! 0
            },
            !0), document.addEventListener("MSPointerUp",
            function(a) {
                if (d) return c("touchend", a, m, !0),
                    m = null,
                    d = !1,
                    !0
            },
            !0), document.addEventListener("MSPointerMove",
            function(a) {
                if (! (Math.abs(a.clientX - l) <= f || Math.abs(a.clientY - p) <= f) && d) return c("touchmove", a, m, !0),
                    h = !0
            },
            !0)) : (document.addEventListener("mousedown",
            function(a) {
                d = !0;
                m = a.target;
                "a" === a.target.nodeName.toLowerCase() && "javascript:;" === a.target.href.toLowerCase() && (a.target.href = "#");
                c("touchstart", a);
                h = !1;
                l = a.clientX;
                p = a.clientY
            },
            !0), document.addEventListener("mouseup",
            function(a) {
                d && (c("touchend", a, m), m = null, d = !1)
            },
            !0), document.addEventListener("mousemove",
            function(a) { ! (a.clientX === l && a.clientY === p) && d && (c("touchmove", a, m), h = !0)
            },
            !0));
        document.addEventListener("drag", b, !0);
        document.addEventListener("dragstart", b, !0);
        document.addEventListener("dragenter", b, !0);
        document.addEventListener("dragover", b, !0);
        document.addEventListener("dragleave", b, !0);
        document.addEventListener("dragend", b, !0);
        document.addEventListener("drop", b, !0);
        document.addEventListener("selectstart",
            function(a) {
                e(a, a.target)
            },
            !0);
        document.addEventListener("click",
            function(a) { ! a.mouseToTouch && a.target === m && b(a);
                h && (b(a), h = !1)
            },
            !0)
    }
})(jQuery, window); (function(a) {
    a.fn.toast = function(a) {
        return new h(this[0], a)
    };
    var h = function() {
        var g = function(b, f) {
            if (this.container = "string" === typeof b || b instanceof String ? document.getElementById(b) : b) {
                if ("string" === typeof f || "number" === typeof f) f = {
                    message: f
                };
                this.addCssClass = f.addCssClass ? f.addCssClass: "";
                this.message = f.message || "";
                this.delay = f.delay || this.delay;
                this.position = f.position || "";
                this.addCssClass += " " + this.position;
                this.type = f.type || "";
                this.container = a(this.container);
                0 === this.container.find(".afToastContainer").length && this.container.append("<div class='afToastContainer'></div>");
                this.container = this.container.find(".afToastContainer");
                this.container.removeClass("tr br tl bl tc bc").addClass(this.addCssClass); ! 1 === f.autoClose && (this.autoClose = !1);
                this.show()
            } else window.alert("Error finding container for toast " + b)
        };
        g.prototype = {
            addCssClass: null,
            message: null,
            delay: 5E3,
            el: null,
            container: null,
            timer: null,
            autoClose: !0,
            show: function() {
                var b = this;
                this.el = a("<div  class='afToast " + this.type + "'><div>" + this.message + "</div></div>").get(0);
                this.container.append(this.el);
                var f = a(this.el),
                    e = this.el.clientHeight;
                f.addClass("hidden");
                setTimeout(function() {
                        f.css("height", e);
                        f.removeClass("hidden")
                    },
                    20);
                this.autoClose && (this.timer = setTimeout(function() {
                        b.hide()
                    },
                    this.delay));
                f.bind("click",
                    function() {
                        b.hide()
                    })
            },
            hide: function() {
                var b = this;
                clearTimeout(this.timer);
                a(this.el).unbind("click").addClass("hidden");
                a(this.el).css("height", "0px"); ! a.os.ie && !a.os.android ? setTimeout(function() {
                        b.remove()
                    },
                    300) : b.remove()
            },
            remove: function() {
                a(this.el).remove()
            }
        };
        return g
    } ();
    a.afui.toast = function(g) {
        a(document.body).toast(g)
    };
    a.afui.registerDataDirective("[data-toast]",
        function(g) {
            var b = a(g);
            g = b.attr("data-message") || "";
            if (0 !== g.length) {
                var f = b.attr("data-position") || "tr",
                    e = b.attr("data-type"),
                    c = "false" === b.attr("data-auto-close") ? !1 : !0,
                    b = b.attr("data-delay") || 0;
                g = {
                    message: g,
                    position: f,
                    delay: b,
                    autoClose: c,
                    type: e
                };
                a(document.body).toast(g)
            }
        })
})(jQuery); (function(a) {
    a.fn.lockScreen = function(a) {
        for (var b, f = 0; f < this.length; f++) b = new h(this[f], a);
        return 1 === this.length ? b: this
    };
    var h = function(a, b) {
        if ("object" === typeof b) for (var f in b) this[f] = b[f]
    };
    h.prototype = {
        logo: "<div class='icon database big'></div>",
        roundKeyboard: !1,
        validatePassword: function() {},
        renderKeyboard: function() {
            for (var a = "",
                     b = 0; 8 > b; b += 3) {
                for (var a = a + "<div class='row'>",
                         f = 1; 3 >= f; f++) var e = b + f,
                         a = a + ("<div data-key='" + e + "'>" + e + "</div>");
                a += "</div>"
            }
            return a + "<div class='row'><div data-key='' class='grey blank'>&nbsp;</div><div data-key='0'>0</div><div data-key='delete' class='grey'><=</div></div>"
        },
        show: function() {
            if (!this.visible) {
                var g = "<div class='content flexContainer'><div class='password'>" + this.logo + "<input maxlength=4 type='password' placeholder='****' disabled></div><div class='error'>Invalid Password</div></div>",
                    g = g + ("<div class='keyboard flexContainer'>" + this.renderKeyboard() + "</div>"),
                    b = a("<div id='lockScreen'/>");
                b.html(g);
                this.roundKeyboard && (b.addClass("round"), b.find("input[type='password']").attr("placeholder", "\u25cc\u25cc\u25cc\u25cc"));
                this.lockscreen = b;
                a(document.body).append(b);
                var f = a("#lockScreen input[type='password']"),
                    e = this;
                a(b).on("click",
                    function(b) {
                        b = a(b.target);
                        if (0 !== b.length && (b = b.attr("data-key")))"delete" === b ? f.val(f.val().substring(0, f.val().length - 1)) : (4 > f.val().length && f.val(f.val() + b), 4 === f.val().length && (e.validatePassword(f.val()) ? e.hide() : (e.lockscreen.find(".error").css("visibility", "visible"), setTimeout(function() {
                                e.lockscreen.find(".error").css("visibility", "hidden");
                                f.val("")
                            },
                            1E3))))
                    });
                a(b).on("touchstart",
                    function(b) {
                        a(b.target).addClass("touched")
                    }).on("touchend",
                    function(b) {
                        a(b.target).removeClass("touched")
                    })
            }
        },
        hide: function() {
            this.lockscreen && this.lockscreen.remove()
        }
    }
})(jQuery);