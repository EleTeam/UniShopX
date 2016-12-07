/*! uyac2.3 updated in 2016-12-02 */
define(function (require, exports, module) {
    var Constant = require("constant"), $$ = Constant.$$, Router = require("router");
    Template7.registerHelper("rif", function (v1, operator, v2, options) {
        switch (v1 = "undefined" != typeof this[v1] ? this[v1] : v1, v2 = "undefined" != typeof this[v2] ? this[v2] : v2, operator) {
            case"==":
                return v1 == v2 ? options.fn(this) : options.inverse(this);
            case"===":
                return v1 === v2 ? options.fn(this) : options.inverse(this);
            case"<":
                return parseInt(v1) < parseInt(v2) ? options.fn(this) : options.inverse(this);
            case"<=":
                return parseInt(v1) <= parseInt(v2) ? options.fn(this) : options.inverse(this);
            case">":
                return parseInt(v1) > parseInt(v2) ? options.fn(this) : options.inverse(this);
            case">=":
                return parseInt(v1) >= parseInt(v2) ? options.fn(this) : options.inverse(this);
            case"&&":
                return v1 && v2 ? options.fn(this) : options.inverse(this);
            case"||":
                return v1 || v2 ? options.fn(this) : options.inverse(this);
            case"!=":
                return v1 != v2 ? options.fn(this) : options.inverse(this);
            default:
                return options.inverse(this)
        }
    }), window.myApp = new Framework7({
        pushState: !0,
        animatePages: !1,
        preloadPreviousPage: !0,
        fastClicksDistanceThreshold: 45,
        modalTitle: " ",
        modalButtonOk: "确定",
        modalButtonCancel: "取消",
        modalButtonClose: "关闭",
        modalPreloaderTitle: "加载中...",
        dynamicNavbar: !0,
        template7Pages: !0,
        modalUsernamePlaceholder: "用户名",
        modalPasswordPlaceholder: "密码",
        imagesLazyLoadSequential: !1,
        imagesLazyLoadPlaceholder: "1",
        swipeBackPage: !1,
        allowDuplicateUrls: !0,
        uniqueHistoryIgnoreGetParameters: !0,
        fastClicks: !0,
        materialPageLoadDelay: 1e4,
        smartSelectSearchbar: !0,
        imagesLazyLoadThreshold: 50,
        actionsCloseByOutside: !1,
        template7Data: {
            common: {
                monthNames: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
                monthNamesShort: ["一", "二", "三", "四", "五", "六", "七", "八", "九", "十", "十一", "十二"],
                dayNames: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"],
                dayNamesShort: ["日", "一", "二", "三", "四", "五", "六"]
            },
            commParams: {
                phone: "400-9896-888",
                $_devid: "UYACWAP",
                $_API_PRIVATEKEY_WAP: "AFcWxV21C7fd0v3bYYYRCpSSRl31AJldvA6DkGbzvR348ppFI41b8Oc",
                _apiversion: "3.0.0"
            }
        },
        onPageInit: function (app, page) {
            localStorage.device = JSON.stringify(app.device)
        },
        onAjaxStart: function (xhr) {
            myApp.showIndicator()
        },
        ajaxError: function (xhr) {
            myApp.showIndicator()
        },
        onAjaxComplete: function (xhr) {
            myApp.hideIndicator()
        }
    });
    var mainView = null;
    exports.init = function () {
        mainView = myApp.addView(".view-main", {dynamicNavbar: !0});
        var queryObj = $$.parseUrlQuery(location.search), pageName = queryObj.action;
        if (localStorage.removeItem("platCookies"), localStorage.removeItem("yqadvert"), queryObj.LTINFO && (localStorage.platCookies = queryObj.LTINFO), queryObj.YqAdvert) {
            var cookies = queryObj.YqAdvert.replace("$", "=");
            localStorage.yqadvert = cookies;
            var date = new Date, expireDays = 30;
            date.setTime(date.getTime() + 24 * expireDays * 3600 * 1e3), document.cookie = "yqadvert=" + cookies + ";expires=" + date.toGMTString()
        }
        if (location.search && pageName) {
            var timeStamp = Date.parse(new Date);
            "index" == pageName && mainView.router.loadPage("html/uyac-product.html?v=" + timeStamp)
        }
        Router.router(mainView)
    }
});