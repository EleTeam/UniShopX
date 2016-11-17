// Initialize your app
var myApp = new Framework7();

// Export selectors engine
var $$ = Dom7;

// Add view
var mainView = myApp.addView('.view-main', {
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
