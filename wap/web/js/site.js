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
var viewTab1 = myApp.addView('#tab1', {dynamicNavbar:true});
var viewTab2 = myApp.addView('#tab2', {dynamicNavbar:true});
var viewTab3 = myApp.addView('#tab3', {dynamicNavbar:true});
var viewTab4 = myApp.addView('#tab4', {dynamicNavbar:true, dynamicPageUrl:true});

//viewTab1.router.loadPage('/user/login');

// 指示器模态框, 点击链接时, 等待页面返回
$$('.open-preloader').on('click', function(){
    //myApp.showIndicator();
    //如果有data-url则跳转页面
    //if($$(this).attr('data-url')){
    //    $$.ajax({
    //        url: $$(this).attr('data-url'),
    //        method: 'GET',
    //        success: function(html){
    //            if(result.status){
    //                console.log(1);
    //                var page = $$(this).attr('data-reload-page');
    //                mainView.router.reloadPage(page);
    //                console.log(2);
    //            }else{
    //                var toast = myApp.toast(result.message, '', {});
    //                toast.show(true);
    //            }
    //        }
    //    });
    //}
    //setTimeout(function () {
    //    myApp.hideIndicator();
    //}, 2000);

});

//首页-幻灯片
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

        $$.ajax({
            url: '/site/home-content',
            method: 'GET',
            success: function(html){
                $$('#tab-home-content').html(html);
            }
        });

//用户登录
myApp.onPageInit('user-login', function(page){
    $$('.user-login .login-btn').on('click', function(){
        var loginUrl = $$('.user-login .login-form').attr('action');
        var data = myApp.formToJSON($$('.user-login .login-form'));
        $$.ajax({
            url: loginUrl,
            method: 'POST',
            data: data,
            dataType: 'json',
            success: function(result){
                if(result.status){
                    console.log(1);
                    var page = $$(this).attr('data-reload-page');
                    mainView.router.reloadPage(page);
                    console.log(2);
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
        $$.ajax({
            url: signupUrl,
            method: 'POST',
            data: data,
            dataType: 'json',
            success: function(result){
                if(result.status){
                    var page = $$(this).attr('data-reload-page');
                    mainView.router.reloadPage(page);
                }else{
                    var toast = myApp.toast(result.message, '', {});
                    toast.show(true);
                }
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
