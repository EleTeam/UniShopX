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

/**********  公共函数 *************/
//返回首页



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





/////////////////////
// Callbacks to run specific code for specific pages, for example for About page:
myApp.onPageInit('about', function (page) {
    // run createContentPage func after link was clicked
    $$('.create-page').on('click', function () {
        createContentPage();
    });
});

// Generate dynamic page
var dynamicPageIndex = 0;
function createContentPage() {
	mainView.router.loadContent(
        '<!-- Top Navbar-->' +
        '<div class="navbar">' +
        '  <div class="navbar-inner">' +
        '    <div class="left"><a href="#" class="back link"><i class="icon icon-back"></i><span>Back</span></a></div>' +
        '    <div class="center sliding">Dynamic Page ' + (++dynamicPageIndex) + '</div>' +
        '  </div>' +
        '</div>' +
        '<div class="pages">' +
        '  <!-- Page, data-page contains page name-->' +
        '  <div data-page="dynamic-pages" class="page">' +
        '    <!-- Scrollable page content-->' +
        '    <div class="page-content">' +
        '      <div class="content-block">' +
        '        <div class="content-block-inner">' +
        '          <p>Here is a dynamic page created on ' + new Date() + ' !</p>' +
        '          <p>Go <a href="#" class="back">back</a> or go to <a href="services.html">Services</a>.</p>' +
        '        </div>' +
        '      </div>' +
        '    </div>' +
        '  </div>' +
        '</div>'
    );
	return;
}
