// Initialize your app
var app = new Framework7();

// Export selectors engine
var $$ = Dom7;

// Add view
var mainView = app.addView('.view-main', {
    // Because we use fixed-through navbar we can enable dynamic navbar
    dynamicNavbar: true
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

//用户登录
app.onPageInit('user-login', function(page){
    $$('.user-login .login-btn').on('click', function(){
        var loginUrl = $$('.user-login .login-form').attr('action');
        var mobile = $$('.login-form .mobile').val();
        var password = $$('.login-form .password').val();
        var data = app.formToJSON($$('.user-login .login-form'));
        $$.ajax({
            url: loginUrl,
            method: 'POST',
            data: data,
            dataType: 'json',
            success: function(json){
                if(json.result){
                    var page = $$(this).attr('data-reload-page');
                    mainView.router.reloadPage(page);
                }else{
                    var toast = app.toast(json.message, '', {});
                    toast.show(true);
                }
            }
        });
    });
});

//用户注册
app.onPageInit('user-signup', function(page) {
    $$('.user-signup .signup-btn').on('click', function(){
        $$('.user-signup .signup-form').data();
    //$$('.user-signup .signup-btn').on('click', function(){

        //var signupUrl = $$(this).attr('data-signup-url');
        //$$.ajax({
        //    url: signupUrl,
        //    method: 'GET',
        //    success: function(html){
        //        $$('.list-block ul').append(html);
        //        homePage ++;
        //        homeLoading = false;
        //    }
        //});
        var page = $$(this).attr('data-reload-page');
        mainView.router.reloadPage(page);
    });
});





/////////////////////
// Callbacks to run specific code for specific pages, for example for About page:
app.onPageInit('about', function (page) {
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
