<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2016-09-30
 * @email 908601756@qq.com
 * @copyright Copyright © 2016年 EleTeam
 * @license The MIT License (MIT)
 */

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use wap\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <link rel="shortcut icon" href="/favicon.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?php /*
<!-- page集合的容器，里面放多个平行的.page，其他.page作为内联页面由路由控制展示 -->
<div class="page-group">
    <!-- 单个page ,第一个.page默认被展示-->
    <div class="page">
        <!-- 标题栏 -->
        <header class="bar bar-nav">
            <h1 class="title">月光茶人</h1>
        </header>

        <!-- 工具栏 -->
        <nav class="bar bar-tab">
            <a class="tab-item external <?php echo $this->context->id == 'site' ? 'active' : '' ?>" href="<?=Url::toRoute('/')?>">
                <span class="icon icon-home"></span>
                <span class="tab-label">首页</span>
            </a>
            <a class="tab-item external <?php echo $this->context->id == 'category' ? 'active' : '' ?>" href="<?=Url::toRoute('/category')?>">
                <span class="icon icon-menu"></span>
                <span class="tab-label">分类</span>
            </a>
            <a class="tab-item external <?php echo $this->context->id == 'cart' ? 'active' : '' ?>" href="<?=Url::toRoute('/cart')?>"">
                <span class="icon icon-cart"></span>
                <span class="tab-label">购物车</span>
            </a>
            <a class="tab-item external <?php echo $this->context->id == 'my' ? 'active' : '' ?>" href="<?=Url::toRoute('/my')?>"">
                <span class="icon icon-me"></span>
                <span class="tab-label">我的</span>
            </a>
        </nav>

        <!-- 这里是页面内容区 -->
        <div class="content">
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>
</div>
*/?>

<!-- Status bar overlay for fullscreen mode-->
<div class="statusbar-overlay"></div>
<!-- Panels overlay-->
<div class="panel-overlay"></div>
<!-- Left panel with reveal effect-->
<div class="panel panel-left panel-reveal">
    <div class="content-block">
        <p>Left panel content goes here</p>
    </div>
</div>
<!-- Right panel with cover effect-->
<div class="panel panel-right panel-cover">
    <div class="content-block">
        <p>Right panel content goes here</p>
    </div>
</div>
<!-- Views-->
<div class="views">
    <!-- Your main view, should have "view-main" class-->
    <div class="view view-main">
        <!-- Top Navbar-->
        <div class="navbar">
            <div class="navbar-inner">
                <!-- We have home navbar without left link-->
                <div class="center sliding">Awesome App</div>
                <div class="right">
                    <!-- Right link contains only icon - additional "icon-only" class--><a href="#" class="link icon-only open-panel"> <i class="icon icon-bars"></i></a>
                </div>
            </div>
        </div>
        <!-- Pages, because we need fixed-through navbar and toolbar, it has additional appropriate classes-->
        <div class="pages navbar-through toolbar-through">
            <!-- Page, data-page contains page name-->
            <div data-page="index" class="page">
                <!-- Scrollable page content-->
                <div class="page-content">
                    <div class="content-block-title">Welcome To My Awesome App</div>
                    <div class="content-block">
                        <div class="content-block-inner">
                            <p>Couple of worlds here because my app is so awesome!</p>
                            <p>Duis sed erat ac eros ultrices pharetra id ut tellus. Praesent rhoncus enim ornare ipsum aliquet ultricies. Pellentesque sodales erat quis elementum sagittis.</p>
                        </div>
                    </div>
                    <div class="content-block-title">What about simple navigation?</div>
                    <div class="list-block">
                        <ul>
                            <li><a href="about.html" class="item-link">
                                    <div class="item-content">
                                        <div class="item-inner">
                                            <div class="item-title">About</div>
                                        </div>
                                    </div></a></li>
                            <li><a href="services.html" class="item-link">
                                    <div class="item-content">
                                        <div class="item-inner">
                                            <div class="item-title">Services</div>
                                        </div>
                                    </div></a></li>
                            <li><a href="form.html" class="item-link">
                                    <div class="item-content">
                                        <div class="item-inner">
                                            <div class="item-title">Form</div>
                                        </div>
                                    </div></a></li>
                        </ul>
                    </div>
                    <div class="content-block-title">Side panels</div>
                    <div class="content-block">
                        <div class="row">
                            <div class="col-50"><a href="#" data-panel="left" class="button open-panel">Left Panel</a></div>
                            <div class="col-50"><a href="#" data-panel="right" class="button open-panel">Right Panel</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bottom Toolbar-->
        <div class="toolbar">
            <div class="toolbar-inner"><a href="#" class="link">Link 1</a><a href="#" class="link">Link 2</a></div>
        </div>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
