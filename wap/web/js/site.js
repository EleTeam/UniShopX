// Initialize your app
var myApp = new Framework7({
    // If it is webapp, we can enable hash navigation:
    pushState: true,

    // Hide and show indicator during ajax requests
    onAjaxStart: function (xhr) {
        myApp.showIndicator();
    },
    onAjaxComplete: function (xhr) {
        myApp.hideIndicator();
    }
});

// Export selectors engine
var $$ = Dom7;

/**
 * 模态提示框
 * @param title 提示标题
 * @param time  展示时间长, 单位毫秒
 */
function myAlert(title, time) {
    time = time || 2000;
    myApp.modal({'title': title});
    setTimeout(function () {
        myApp.closeModal();
    }, time);
}

// 必须初始化视图才能加载数据, 使用导航条穿透布局必须使用{dynamicNavbar:true}
var tabHomeView     = myApp.addView('#tab-home', {dynamicNavbar:true});
var tabCategoryView = myApp.addView('#tab-category', {dynamicNavbar:true});
var tabCartView     = myApp.addView('#tab-cart', {dynamicNavbar:true});
var tabMyView       = myApp.addView('#tab-my', {dynamicNavbar:true});

//点击工具栏重新加载页面
$$('#tab-home-icon').on('click', function(){
    var url = $$(this).attr('data-url');
    tabHomeView.router.load({url:url, animatePages:false, ignoreCache:true, reload:true});
});
$$('#tab-home-icon').trigger('click');

$$('#tab-category-icon').on('click', function(){
    var url = $$(this).attr('data-url');
    tabCategoryView.router.load({url:url, animatePages:false, ignoreCache:true, reload:true});
});

$$('#tab-cart-icon').on('click', function(){
    var url = $$(this).attr('data-url');
    tabCartView.router.load({url:url, animatePages:false, ignoreCache:true, reload:true});
});

$$('#tab-my-icon').on('click', function(){
    var url = $$(this).attr('data-url');
    tabMyView.router.load({url:url, animatePages:false, ignoreCache:true, reload:true});
});

//首页
myApp.onPageInit('home', function(page){
    //幻灯片
    var mySwiper = new Swiper('.swiper-container', {
        preloadImages: false,
        lazyLoading: true,
        pagination: '.swiper-pagination'
    });

    //首页-无限滚动(上拉刷新)
    var homeLoading = false;
    // Last loaded index
    var homePage = 2;
    // Attach 'infinite' event handler
    $$('.infinite-scroll').on('infinite', function(){
        // Exit, if loading in progress
        if (homeLoading)
            return;

        // Set loading flag
        homeLoading = true;
        var url = '/site/index-list?page=' + homePage;

        $$.ajax({
            url: url,
            method: 'GET',
            success: function(html){
                $$('.list-block ul').append(html);
                homePage ++;
                homeLoading = false;
            }
        });
    });
});

//分类首页
myApp.onPageInit('category', function(page) {
    // Attach 'infinite' event handler
    // Init slider and store its instance in mySwiper variable
    var taglist = $$(".taglist");
    var mySwiper = myApp.swiper('.swiper-container', {
        slidesPerView: "auto",
        autoHeight: true,
        freeMode: true,
        direction: 'vertical',
        onSlideChangeStart: function (swiper) {
            var index = swiper.activeIndex;
            taglist.find('.j-tag').removeClass('focus');
            taglist.find('.j-tag').eq(index).addClass("focus");
        }
    });
    taglist.on('click', '.j-tag', function(){
        taglist.find('.j-tag').removeClass('focus');
        $$(this).addClass('focus');
        var index = $$(this).index();
        mySwiper.slideTo(index);
    });
});

//购物车首页
myApp.onPageInit('cart', function(page){
    $$('#goShopping').on('click', function(){
        location.href = '/';
    });
});

//用户登录
myApp.onPageInit('user-login', function(page){
    $$('.user-login .login-btn').on('click', function(){
        var loginUrl = $$('.user-login .login-form').attr('action');
        var data = myApp.formToJSON($$('.user-login .login-form'));
        var reloadPage = $$(this).attr('data-reload-page');
        myApp.showIndicator();
        //tabMyView.router.reloadPage($$(this).attr('data-reload-page'));
        //$$('#tab-my-icon').trigger('click');
        $$.ajax({
            url: loginUrl,
            method: 'POST',
            data: data,
            dataType: 'json',
            success: function(result){
                myApp.hideIndicator();
                if(result.status){
                    //tabMyView.router.reloadPage(reloadPage);
                    //$$('#tab-my-icon').trigger('click');
                    tabMyView.router.back({url:reloadPage, animatePages:false, ignoreCache:true, reload:true, force:true});
                }else{
                    var toast = myApp.toast(result.message, '', {});
                    toast.show(true);
                }
            }
        });
    });
});

//用户注册
myApp.onPageInit('user-signup', function(page) {
    $$('.user-signup .signup-btn').on('click', function(){
        var signupUrl = $$('.user-signup .signup-form').attr('action');
        var data = myApp.formToJSON($$('.user-signup .signup-form'));
        var reloadPage = $$(this).attr('data-reload-page');
        myApp.showIndicator();
        $$.ajax({
            url: signupUrl,
            method: 'POST',
            data: data,
            dataType: 'json',
            success: function(result){
                myApp.hideIndicator();
                if(result.status){
                    tabMyView.router.back({url:reloadPage, animatePages:false, ignoreCache:true, reload:true, force:true});
                }else{
                    var toast = myApp.toast(result.message, '', {});
                    toast.show(true);
                }
            }
        });
    });
});

//设置页
myApp.onPageInit('my-setting', function(){
    $$('.my-setting .logout-btn').on('click', function(){
        var logoutUrl = $$('.my-setting .logout-form').attr('action');
        var data = myApp.formToJSON($$('.my-setting .logout-form'));
        var reloadPage = $$(this).attr('data-reload-page');
        myApp.showIndicator();
        $$.ajax({
            url: logoutUrl,
            method: 'POST',
            dataType: 'json',
            data: data,
            success: function(result){
                myApp.hideIndicator();
                if(result.status){
                    tabMyView.router.back({url:reloadPage, animatePages:false, ignoreCache:true, reload:true, force:true});
                }else{
                    var toast = myApp.toast(result.message, '', {});
                    toast.show(true);
                }
            }
        });
    });
});

//用户信息
myApp.onPageInit('user-view', function(){
    $$('.user-view .back-btn').on('click', function(){
        var reloadPage = $$(this).attr('data-reload-page');
        myApp.showIndicator();
        $$.ajax({
            url: '/user/view',
            method: 'GET',
            success: function(result){
                myApp.hideIndicator();
                tabMyView.router.back({url:reloadPage, animatePages:false, ignoreCache:true, reload:true, force:true});//{pageName:'my', animatePages:false, ignoreCache:true, reload:true, force:true});
            }
        });
    });
});

//商品详情
myApp.onPageInit('product-view', function(page){
    //幻灯片
    var mySwiper = new Swiper('.swiper-container', {
        preloadImages: false,
        lazyLoading: true,
        pagination: '.swiper-pagination'
    });
    //打开规格层
    $$('.open-spec-modal').on('click', function(){
        //$$('.product-view').append('<div class="modal-overlay modal-overlay-visible"></div>');
        myApp.pickerModal('.spec-modal');
    });
    //关闭规格层
    $$('.close-spec-modal').on('click', function(){
        myApp.closeModal();
    });
    //选择规格值, class="is_selected" 为被选择的规格值
    $$('[name="spec-value"]').on('click', function(){
        $$(this).parent().find('[name="spec-value"]').each(function(){
            $$(this).removeClass('is-selected');
        });
        $$(this).addClass('is-selected');
    });
    //添加入购物车
    $$('.add-to-cart').on('click', function(){
        var product_id = $$('input[name="product_id"]').val();
        var count = $$('[name="product-count"]').val();
        var url = $$(this).attr('data-url');

        //根据选中的规格值组合成spec_value_ids, 从而找到sku_id
        var spec_value_ids = '_';
        $$('.spec-box').find('[name="spec-value"]').each(function(){
            if($$(this).hasClass('is-selected')){
                spec_value_ids += $$(this).attr('data-spec-value-id') + '_';
            }
        });
        var sku_id = '';
        $$('.skus').each(function(){
            if(spec_value_ids == $$(this).attr('data-spec-value-ids')){
                sku_id = $$(this).attr('data-sku-id');
            }
        });

        if(!sku_id){
            alert('请选择规格');
            return;
        }

        var _csrf = $$('input[name="_csrf"]').val();
        var data = 'product_id=' + product_id + '&sku_id=' + sku_id + '&count=' + count + '&_csrf=' + _csrf;

        myApp.showIndicator();
        $$.ajax({
            url: url,
            method: 'POST',
            data: data,
            dataType: 'json',
            success: function(json){
                myApp.hideIndicator();
                if(json.status) {
                    $$('#product-cart-num').html(json.data.cart_num);
                    //关闭规格层
                    myApp.closeModal();
                    myAlert('成功加入购物车');
                }else{
                    alert(json.message);
                }
            }
        });
    });
    //直接购买
});
