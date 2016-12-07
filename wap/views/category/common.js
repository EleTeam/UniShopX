/*! uyac2.3 updated in 2016-12-02 */
define(function (require, exports, module) {
    function validateMobile(mobile) {
        return mobile = mobile.trim(), "" == mobile.length ? (_Alert("请输入手机号码！"), !1) : 11 != mobile.length ? (_Alert("请输入有效的手机号码！"), !1) : !0
    }

    function checkIdcard(num) {
        if (num = num.toUpperCase(), !num)return {flag: !1, tips: "身份证号码不能为空！"};
        if (!/(^\d{15}$)|(^\d{17}([0-9]|X)$)/.test(num))return {flag: !1, tips: "输入的身份证号长度不对，或者号码不符合规定！"};
        var len, re;
        if (len = num.length, 15 == len) {
            re = new RegExp(/^(\d{6})(\d{2})(\d{2})(\d{2})(\d{3})$/);
            var bGoodDay, arrSplit = num.match(re), dtmBirth = new Date("19" + arrSplit[2] + "/" + arrSplit[3] + "/" + arrSplit[4]);
            if (bGoodDay = dtmBirth.getYear() == Number(arrSplit[2]) && dtmBirth.getMonth() + 1 == Number(arrSplit[3]) && dtmBirth.getDate() == Number(arrSplit[4])) {
                var i, arrInt = new Array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2), arrCh = new Array("1", "0", "X", "9", "8", "7", "6", "5", "4", "3", "2"), nTemp = 0;
                for (num = num.substr(0, 6) + "19" + num.substr(6, num.length - 6), i = 0; 17 > i; i++)nTemp += num.substr(i, 1) * arrInt[i];
                return num += arrCh[nTemp % 11], {flag: !0, tips: ""}
            }
            return {flag: !1, tips: "输入的身份证号里出生日期不对！"}
        }
        if (18 == len) {
            re = new RegExp(/^(\d{6})(\d{4})(\d{2})(\d{2})(\d{3})([0-9]|X)$/);
            var bGoodDay, arrSplit = num.match(re), dtmBirth = new Date(arrSplit[2] + "/" + arrSplit[3] + "/" + arrSplit[4]);
            if (bGoodDay = dtmBirth.getFullYear() == Number(arrSplit[2]) && dtmBirth.getMonth() + 1 == Number(arrSplit[3]) && dtmBirth.getDate() == Number(arrSplit[4]), !bGoodDay)return {
                flag: !1,
                tips: "输入的身份证号里出生日期不对！"
            };
            var i, arrInt = new Array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2), arrCh = new Array("1", "0", "X", "9", "8", "7", "6", "5", "4", "3", "2"), nTemp = 0;
            for (i = 0; 17 > i; i++)nTemp += num.substr(i, 1) * arrInt[i]
        }
        return {flag: !0, tips: ""}
    }

    function unique(arr) {
        for (var elem, result = [], hash = {}, i = 0; null != (elem = arr[i]); i++)hash[elem] || (result.push(elem), hash[elem] = !0);
        return result
    }

    function uniqueArr(arr) {
        var unique = {};
        return arr.forEach(function (gpa) {
            unique[JSON.stringify(gpa)] = gpa
        }), arr = Object.keys(unique).map(function (u) {
            return JSON.parse(u)
        })
    }

    function _Alert(tips, hs) {
        var hs = hs || 1500;
        myApp.showPreloaderWithoutIcon(tips), setTimeout(function () {
            myApp.hidePreloader()
        }, hs)
    }

    function openToolKit(page, mainView, flg) {
        var floatLogoHtml = '<a href="#" class="floatButton div-fixed" id="floatButtonMore"><img src="/img/icon/ic_more_menu_homepage.png"></a><div class="floatLogo box"><div class="logo text-center"><img src="img/icon/logo.png" /></div><div class="box-flex"><div class="row"><div class="col-60"><div>雅活荟</div><div class="floatLogo-font">开启全新生活体验</div></div><div class="col-40"><span name="downloadApp" id="downloadApp">立即下载</span></div></div></div><div class=""><img src="img/icon/ic_close.png" class="floatLogo-icolse"></div></div>';
        ("undefined" == typeof flg || flg) && 0 == $$(".pages").find(".floatButton").length && $$(".pages").append(floatLogoHtml), $$(".pages").on("click", "#floatButtonMore", function (e) {
            $$(".toolkit").remove(), myApp.actions([]), $$(".actions-modal").addClass("toolkit");
            var html = '<div class="actions-modal-group row"><div class="actions-modal-button col-33" name="uyac-product"><i class="icon icon-home"></i><h5>首页</h5></div><div class="actions-modal-button col-33" name="productCategories"><i class="icon icon-cate"></i><h5>分类</h5></div><div class="actions-modal-button col-33" name="cart"><i class="icon icon-cart"></i><h5>购物车</h5></div></div>';
            html += '<div class="actions-modal-group row"><div class="actions-modal-button col-33" name="uyac-mine"><i class="icon icon-mine"></i><h5>我的</h5></div><div class="actions-modal-button col-33" name="uyac-search"><i class="icon icon-search"></i><h5>搜索</h5></div><div class="actions-modal-button col-33" name="downloadApp"><i class="icon icon-download"></i><h5>下载APP</h5></div></div>', html += '<div class="actions-modal-group row"><span class="actions-modal-button col-100 modal-cancel" name="cancel"><i class="icon icon-closed"></i></span></div>', $$(".actions-modal").html(html), $$(".actions-modal-button").on("click", function () {
                var btnName = $$(this).attr("name"), urlPath = window.location.href;
                urlPath = urlPath.split("#!/")[1], urlPath = urlPath.split("/")[1], urlPath = urlPath.split("?")[0];
                var htmlName = urlPath.substring(0, urlPath.length - 5);
                if (htmlName != btnName) {
                    var url = "";
                    if ("downloadApp" == btnName)downloadApp(); else {
                        switch (btnName) {
                            case"uyac-product":
                                url = "html/uyac-product.html";
                                break;
                            case"uyac-mine":
                                url = "html/uyac-mine.html";
                                break;
                            case"cart":
                                url = "html/cart.html";
                                break;
                            case"productCategories":
                                url = "html/productCategories.html";
                                break;
                            case"uyac-search":
                                url = "html/uyac-search.html?tabIndex=1"
                        }
                        mainView.router.loadPage(url)
                    }
                    myApp.closeModal(), $(".modal-overlay").remove()
                }
            })
        })
    }

    function rollBackToTop($btn, $obj) {
        var timer = null;
        $obj.scroll(function () {
            $(this).scrollTop() > 2e3 ? $btn.show(300) : $btn.hide(300)
        }), $btn.click(function () {
            timer = setInterval(function () {
                var backtop = $obj.scrollTop(), speedtop = backtop / 7;
                $obj.scrollTop(backtop - speedtop), 0 == backtop && clearInterval(timer)
            }, 40)
        })
    }

    function downloadApp() {
        window.open(downloadUrl)
    }

    function getCookie(name) {
        var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
        return (arr = document.cookie.match(reg)) ? unescape(arr[2]) : ""
    }

    function hideDivFixed() {
        $$("input").focus(function (event) {
            $$(".div-fixed").css({position: "static"}), $$(".user-agree").hide()
        }), $$("input").blur(function (event) {
            $$(".div-fixed").css({position: "absolute"}), $$(".user-agree").show()
        })
    }

    function inputMatch($value, $REP, $callbackTrue, $callbackFalse) {
        var r = $value.match($REP);
        null == r ? $callbackFalse() : $callbackTrue()
    }

    function addAndplus(objIpt, objPlus, objAdd, maxNum) {
        var txtNo = parseInt(objIpt.val());
        objAdd.on("click", function () {
            1 > txtNo || (maxNum ? maxNum > txtNo && (txtNo += 1, objIpt.val(txtNo)) : (txtNo += 1, objIpt.val(txtNo)))
        }), objPlus.on("click", function () {
            2 > txtNo || (txtNo -= 1, objIpt.val(txtNo))
        })
    }

    function loadToPage(mainObj, obj, mainView) {
        for (var i in obj)!function (i) {
            if (obj[i] instanceof Array) {
                if (obj[i].length)for (var j = 0, len = obj[i].length; len > j; j++)!function (j) {
                    mainObj.on("click", obj[i][j], function () {
                        localStorage._mtoken;
                        mainView.router.loadPage(i)
                    })
                }(j)
            } else mainObj.on("click", obj[i], function () {
                isLogin(mainView) && mainView.router.loadPage(i)
            })
        }(i)
    }

    function scrollTop() {
        var timer = null, $btn = $("a[name=backTopBtn]"), $obj = $btn.siblings(".page-content");
        $obj.scroll(function () {
            $$(this).scrollTop() > 1e3 ? $btn.show(300) : $btn.hide(300)
        }), $btn.click(function () {
            timer = setInterval(function () {
                var backtop = $obj.scrollTop(), speedtop = backtop / 7;
                $obj.scrollTop(backtop - speedtop), 0 == backtop && clearInterval(timer)
            }, 40)
        })
    }

    function callPhone(phone, _container) {
        _container.on("click", "#callService", function () {
            "" == phone && (phone = $$(this).find("i").data("tel"));
            var buttons1 = [{
                text: "商家热线：" + phone, bold: !0, onClick: function () {
                    window.location.href = "tel:" + phone
                }
            }, {
                text: "客服热线：400-6803-888", bold: !0, onClick: function () {
                    window.location.href = "tel:400-6803-888"
                }
            }], buttons2 = [{text: "取消"}], groups = "";
            phone || buttons1.remove(0), groups = [buttons1, buttons2], myApp.actions(groups), $$(".actions-modal-group").addClass("uyac-actions-modal"), $$(".modal-overlay").css({top: "0"})
        })
    }

    function getFromContent(obj) {
        var result = {};
        return obj.find("input").each(function () {
            var _name = $(this).attr("name"), _val = $(this).val();
            result[_name] = _val
        }), result
    }

    function isLogin(mainView) {
        var token = localStorage._mtoken, openId = localStorage.openId, res = ajaxData({
            _apiname: "OrderService.getBlance",
            _mtoken: token
        }, !0, mainView);
        if (104 != parseInt(res.code) && 400 != parseInt(res.code))return !0;
        var ua = window.navigator.userAgent.toLowerCase();
        if ("micromessenger" != ua.match(/MicroMessenger/i) || openId)localStorage.removeItem("_mtoken"), localStorage.removeItem("openId"), mainView.router.loadPage("html/uyac-login.html?islogin='true'"); else {
            var href = window.location.href;
            if ("login" == href.match(/login/i))href = "http://m.yahuohui.com"; else {
                if ("code" == href.match(/code/i)) {
                    var strs = new Array;
                    strs = href.split("&code");
                    var url1 = strs[0];
                    strs = href.split("&state=123");
                    var url2 = strs[strs.length - 1];
                    href = url1 + url2
                }
                var htmStr = href.split("#!/")[1];
                href += htmStr.indexOf("?") > -1 && htmStr.indexOf("scanCode") < 0 ? "&from=scanCode" : "?from=scanCode"
            }
            window.location.href = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" + appid + "&redirect_uri=" + escape(href) + "&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect"
        }
    }

    function poupBindPhone(flg) {
        var token = localStorage._mtoken, url = window.location.href;
        if ("code" == url.match(/code/i) && !token) {
            var strs = new Array;
            strs = url.split("&code=");
            var WXcode = strs[1].split("&state")[0], res = ajaxData({
                _apiname: "ThirdLogin.weixinWapReturnUrl",
                code: WXcode
            });
            if (40029 == res.code)return;
            var mtoken = res._mtoken, openId = res.openid;
            localStorage.openId = openId, localStorage._mtoken = mtoken, void 0 != flg || mtoken || require.async("../../template/bindPhone.tpl", function (templateHtml) {
                var compiledTemplate = Template7.compile(templateHtml), html = compiledTemplate();
                myApp.popup(html), $$("#bindphoneContainer").on("click", "#getCodeBtn,#sendAgainBtn", function () {
                    var phoneNo = $$("#bindPhoneInpt").val();
                    validateMobile(phoneNo) && sendMsgFunc(phoneNo)
                }), $$("#bindphoneContainer").find("input").on("input propertychange", function () {
                    var phoneNo = $$("#bindPhoneInpt").val(), codeNo = $$("#bindCode").val(), submitPhoneBtn = $$("#submitPhoneBtn");
                    "" === phoneNo || "" === codeNo ? submitPhoneBtn.find(".confirm-blue").hide().next().show() : submitPhoneBtn.find(".confirm-blue").show().next().hide()
                }), $$("#submitPhoneBtn").find(".btn-blue").click(function () {
                    var phoneNo = $$("#bindPhoneInpt").val(), codeNo = $$("#bindCode").val(), res = ajaxData({
                        _apiname: "Login.fastLogin",
                        f_mobile: phoneNo,
                        code: codeNo,
                        f_fromtype: 4,
                        f_openid: openId,
                        _devid: "UYACWAP"
                    }, !0);
                    200 == res.code && (_Alert("手机号码绑定成功！"), localStorage._mtoken = res.data._mtoken, myApp.closeModal("#bindphoneContainer"))
                })
            })
        }
    }

    function sendMsgFunc(phoneNo) {
        function showTime() {
            return time -= 1, $$("#sendAgainBtn").addClass("div-hide"), $$("#timesContainer").css("display", "inline-block").children("span").css("display", "inline-block").text(time + "s"), $$("#getCodeBtn").hide(), 0 === time ? ($$("#sendAgainBtn").removeClass("div-hide"), void $$("#timesContainer").find("span").hide()) : void setTimeout(function () {
                showTime()
            }, 1e3)
        }

        var params = {
            _apiname: "Sms.smsSend",
            _devid: "UYACWAP",
            mobile: phoneNo
        }, res = ajaxData(params, !0), code = res.code;
        if ("200" === code) {
            var time = 60;
            showTime()
        } else _Alert(res.msg)
    }

    function back(page, mainView, $container) {
        var inviteCode = page.query.inviteCode, from = page.query.from;
        $container || ($container = $$("body")), ("share" == from || "app" == from || "scanCode" == from) && $container.find(".btn-link-back").hide(), $container.on("click", "#backBtn", function () {
            var fromHistory = page.fromPage.fromPage || "";
            fromHistory ? mainView.router.back() : inviteCode ? mainView.router.loadPage("html/uyac-product.html") : "php" == from ? history.go(-1) : mainView.router.loadPage("html/uyac-product.html")
        })
    }

    function webChatShare(customShare) {
        var ua = window.navigator.userAgent.toLowerCase();
        if ("micromessenger" == ua.match(/MicroMessenger/i)) {
            var str = window.location.href, strs = new Array;
            strs = str.split("://")[1];
            var url = strs.split("#")[0], params = {
                _apiname: "Weixin.wapshare",
                url: url
            }, shareParams = {
                title: customShare.title || "雅活荟全球精选生活平台",
                desc: customShare.content,
                link: customShare.url,
                imgUrl: customShare.image
            };
            myApp.showIndicator(), $$.ajax({
                method: "post",
                url: path,
                dataType: "json",
                data: params,
                success: function (res) {
                    myApp.hideIndicator(), "200" == res.code && (wx.config({
                        debug: !1,
                        appId: res.data.appId,
                        timestamp: res.data.timestamp,
                        nonceStr: res.data.nonceStr,
                        signature: res.data.signature,
                        jsApiList: ["onMenuShareTimeline", "onMenuShareAppMessage", "onMenuShareQQ", "onMenuShareQZone", "onMenuShareWeibo"]
                    }), wx.ready(function () {
                        wx.onMenuShareTimeline({
                            title: shareParams.desc,
                            link: shareParams.link,
                            imgUrl: shareParams.imgUrl,
                            success: function () {
                            },
                            cancel: function () {
                            }
                        }), wx.onMenuShareAppMessage({
                            title: shareParams.title,
                            desc: shareParams.desc,
                            link: shareParams.link,
                            imgUrl: shareParams.imgUrl,
                            success: function () {
                            },
                            cancel: function () {
                            }
                        }), wx.onMenuShareQQ({
                            title: shareParams.title,
                            desc: shareParams.desc,
                            link: shareParams.link,
                            imgUrl: shareParams.imgUrl,
                            success: function () {
                            },
                            cancel: function () {
                            }
                        }), wx.onMenuShareQZone({
                            title: shareParams.title,
                            desc: shareParams.desc,
                            link: shareParams.link,
                            imgUrl: shareParams.imgUrl,
                            success: function () {
                            },
                            cancel: function () {
                            }
                        }), wx.onMenuShareWeibo({
                            title: shareParams.title,
                            desc: shareParams.desc,
                            link: shareParams.link,
                            imgUrl: shareParams.imgUrl,
                            success: function () {
                            },
                            cancel: function () {
                            }
                        })
                    }), wx.error(function (res) {
                    }))
                },
                error: function () {
                    myApp.hideIndicator()
                }
            })
        }
    }

    function encryptNo() {
        var len = bankNum.length;
        return bankNum.substring(0, 4) + " **** **** **** " + bankNum.substring(len - 4, len)
    }

    function countdown(sends, funs) {
        var timer = setTimeout(function () {
            sends -= 1;
            var tims = 0;
            "function" == typeof funs && (tims = sends % 60, funs(tims)), 0 == sends ? clearTimeout(timer) : countdown(sends, funs)
        }, 1e3)
    }

    function getTimeCprNowadays(timeStr) {
        var myDate = new Date, timeShow = "", time = "";
        if (!timeStr || !timeStr.indexOf(" "))return timeStr;
        time = timeStr.split(" ");
        var time_fullyear = time[0], time_hour = time[1], fullyearArray = time_fullyear.split("-"), hourArray = time_hour.split(":");
        return timeShow = fullyearArray[0] < myDate.getFullYear() ? time_fullyear : fullyearArray[1] < myDate.getMonth() + 1 ? fullyearArray[1] + "-" + fullyearArray[2] : myDate.getDate() - fullyearArray[2] == 1 ? "昨天" : myDate.getDate() - fullyearArray[2] > 1 ? fullyearArray[1] + "-" + fullyearArray[2] : hourArray[0] < myDate.getHours() ? myDate.getHours() - hourArray[0] + "小时前" : hourArray[1] < myDate.getMinutes() ? myDate.getMinutes() - hourArray[1] + "分钟前" : "刚刚"
    }

    function getTimeStr(str) {
        var time_str = str.replace(/-/g, "/");
        return time_str
    }

    var $ = require("$"), Constant = require("constant"), $$ = Constant.$$, path = Constant.rootPath, servePath = Constant.servePath, downloadUrl = Constant.downloadUrl, appid = Constant.appid, _url = servePath + "/api.php";
    window.ajaxData = function (paramsJson, flg, mainView) {
        paramsJson._apiversion = "3.0.0";
        var data = null, ret = null;
        return window.XMLHttpRequest ? xmlhttp = new XMLHttpRequest : window.ActiveXObject && (xmlhttp = new ActiveXObject("Microsoft.XMLHTTP")), $$.ajax({
            type: "get",
            url: _url + "?_apiname=Ck.wab&m=" + 1e5 * Math.random(),
            async: !1,
            dataType: "script",
            success: function (res) {
                var func = eval("[" + res + "]")[0];
                ret = func.call()
            }
        }), myApp.showIndicator(), $$.ajax({
            method: "post",
            url: path,
            dataType: "json",
            async: !1,
            data: $.extend({}, ret, paramsJson),
            success: function (res) {
                data = 200 == res.code ? flg ? res : res.data : res, myApp.hideIndicator()
            },
            error: function () {
                myApp.hideIndicator(), myApp.alert("请求失败，请稍后重试!", "")
            }
        }), data
    }, window.AjaxUtil = {
        options: {
            method: "get", url: "", params: {}, type: "text", callback: function () {
            }
        }, createRequest: function () {
            var xmlhttp;
            try {
                xmlhttp = new ActiveXObject("Msxml2.XMLHTTP")
            } catch (e) {
                try {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP")
                } catch (e) {
                    try {
                        xmlhttp = new XMLHttpRequest, xmlhttp.overrideMimeType && xmlhttp.overrideMimeType("text/xml")
                    } catch (e) {
                        alert("您的浏览器不支持Ajax")
                    }
                }
            }
            return xmlhttp
        }, setOptions: function (newOptions) {
            for (var pro in newOptions)this.options[pro] = newOptions[pro]
        }, formateParameters: function () {
            var paramsArray = [], params = this.options.params;
            for (var pro in params) {
                var paramValue = params[pro];
                "GET" === this.options.method.toUpperCase() && (paramValue = encodeURIComponent(params[pro])), paramsArray.push(pro + "=" + paramValue)
            }
            return paramsArray.join("&")
        }, readystatechange: function (xmlhttp) {
            var returnValue;
            if (4 == xmlhttp.readyState && 200 == xmlhttp.status) {
                switch (this.options.type) {
                    case"xml":
                        returnValue = xmlhttp.responseXML;
                        break;
                    case"json":
                        var jsonText = xmlhttp.responseText;
                        jsonText && (returnValue = eval("(" + jsonText + ")"));
                        break;
                    default:
                        returnValue = xmlhttp.responseText
                }
                returnValue ? this.options.callback.call(this, returnValue) : this.options.callback.call(this)
            }
        }, request: function (options) {
            var ajaxObj = this;
            ajaxObj.setOptions.call(ajaxObj, options);
            var xmlhttp = ajaxObj.createRequest.call(ajaxObj);
            xmlhttp.onreadystatechange = function () {
                ajaxObj.readystatechange.call(ajaxObj, xmlhttp)
            };
            var formateParams = ajaxObj.formateParameters.call(ajaxObj), method = ajaxObj.options.method, url = ajaxObj.options.url;
            "GET" === method.toUpperCase() && (url += "?" + formateParams), xmlhttp.open(method, url, !0), "GET" === method.toUpperCase() ? xmlhttp.send(null) : "POST" === method.toUpperCase() && (xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"), xmlhttp.send(formateParams))
        }
    }, window.FormatPhoneNum = function (phoneNum) {
        return phoneNum ? phoneNum.substring(0, 3) + "****" + phoneNum.substring(7, 11) : ""
    }, window.FormatIdCard = function (Id) {
        if (Id) {
            var len = Id.length;
            return Id.substring(0, 3) + "**** **** ****" + Id.substring(len - 4, len)
        }
        return ""
    }, window.FormatBankNum = function (bankNum) {
        if (bankNum) {
            var len = bankNum.length;
            return bankNum.substring(0, 4) + "**** **** ****" + bankNum.substring(len - 4, len)
        }
        return ""
    }, Array.prototype.remove = function (index) {
        if (isNaN(index) || index > this.length)return !1;
        for (var i = 0, n = 0; i < this.length; i++)this[i] != this[index] && (this[n++] = this[i]);
        this.length -= 1
    }, $$(".pages").off("click").on("click", "span[name=downloadApp]", function (e) {
        downloadApp()
    }), $$(".pages").off("click").on("click", ".floatLogo-icolse", function (e) {
        $$(this).parent().parent().hide()
    }), exports.getTimeCprNowadays = getTimeCprNowadays, exports.FormatPhoneNum = FormatPhoneNum, exports.FormatBankNum = FormatBankNum, exports.unique = unique, exports.uniqueArr = uniqueArr, exports._Alert = _Alert, exports.rollBackToTop = rollBackToTop, exports.openToolKit = openToolKit, exports.inputMatch = inputMatch, exports.hideDivFixed = hideDivFixed, exports.addAndplus = addAndplus, exports.loadToPage = loadToPage, exports.validateMobile = validateMobile, exports.checkIdcard = checkIdcard, exports.callPhone = callPhone, exports.scrollTop = scrollTop, exports.getFromContent = getFromContent, exports.getCookie = getCookie, exports.isLogin = isLogin, exports.downloadApp = downloadApp, exports.back = back, exports.webChatShare = webChatShare, exports.poupBindPhone = poupBindPhone, exports.countdown = countdown, exports.getTimeStr = getTimeStr
});