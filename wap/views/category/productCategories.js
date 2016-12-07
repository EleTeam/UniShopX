/*! uyac2.3 updated in 2016-12-02 */
define(function (require, exports, module) {
    function pageInit(page, mainView) {
        Common.openToolKit(page, mainView);
        var mainObj = $("#product-categories"), req = {
            _apiname: "Product.Productindex.categoryList",
            category_id: 0
        }, data = ajaxData(req);
        if (data) {
            for (var i = 0, len = data.length; len > i; i++) {
                var tab_link = '<a href="#tab_' + i + '"class="tab-link">' + data[i].f_categoryname + "</a>", img = '<img src="' + data[i].f_mobileimage + '">';
                mainObj.find(".v-tabs-left").append(tab_link);
                var html = '<div class="swiper-slide" style="height:auto;">' + img + '<div class="categoryGoods row">';
                if (data[i].children) {
                    for (var j = 0, lenChild = data[i].children.length; lenChild > j; j++) {
                        var item = data[i].children;
                        html += '<div class="col-33" data-id="' + item[j].id + '" data-categoriesName="' + item[j].f_categoryname + '"><img style="width:50%;" src="' + item[j].f_mobileimage + '"><div class="font7">' + item[j].f_categoryname + "</div></div>"
                    }
                    html += "</div></div>", mainObj.find(".swiper-wrapper").append(html), mainObj.find(".tab-link").eq(0).addClass("active")
                }
            }
            var mySwiper = myApp.swiper("#uyacLista", {
                slidesPerView: "auto",
                autoHeight: !0,
                direction: "vertical",
                spaceBetween: 10,
                height: 500,
                onSlideChangeStart: function (swiper) {
                    var index = swiper.activeIndex;
                    mainObj.find(".tab-link").eq(index).addClass("active").siblings().removeClass("active")
                }
            })
        }
        mainObj.on("click", ".tab-link", function () {
            $(this).addClass("active").siblings().removeClass("active");
            var tabIndex = $(this).index();
            mySwiper.slideTo(tabIndex)
        }), mainObj.on("click", ".col-33", function () {
            mainView.router.loadPage("html/uyac-search-result.html?categories=1&id=" + $$(this).attr("data-id") + "&categoriesName=" + $$(this).attr("data-categoriesName"))
        })
    }

    var $ = require("$"), Common = require("common"), Constant = require("constant"), $$ = Constant.$$;
    Constant.rootPath, myApp.template7Data.commParams;
    exports.pageInit = pageInit
});