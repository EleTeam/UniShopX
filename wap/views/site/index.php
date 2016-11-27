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

/**
 * @var $this \yii\web\View
 * @var $content string
 * @var $banners
 * @var $articles
 */

use yii\helpers\Html;
use wap\assets\AppAsset;
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
    <style type="text/css">
        .swiper-container {
            height: 180px;
        }
        .swiper-slide {
            background: #fff;
            position: relative;
        }
        .swiper-slide img {
            position: absolute;
            left:50%;
            top:50%;
            max-width: 100%;
            max-height: 100%;
            -webkit-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }
    </style>
</head>
<body>
<?php $this->beginBody() ?>

<!-- Status bar overlay for fullscreen mode-->
<div class="statusbar-overlay"></div>

<!-- Panels overlay-->
<div class="panel-overlay"></div>

<!-- Views-->
    <div class="views tabs toolbar-fixed">
        <!-- Tab 1 - View 1, active by default -->
        <div id="tab1" class="view tab active">
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="center sliding">月光茶人</div>
                </div>
            </div>
            <div class="pages navbar-through">
                <div data-page="home-1" class="page">
                    <div class="page-content" id="tab-home-content">
                        <div class="content-block">
                            <p>This is view 1</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tab 2 - View 2 -->
        <div id="tab2" class="view tab">
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="center sliding">View 2</div>
                </div>
            </div>
            <div class="pages navbar-through">
                <div data-page="home-2" class="page">
                    <div class="page-content">
                        <div class="content-block">
                            <p>This is view 2</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tab 3 - View 3 -->
        <div id="tab3" class="view tab">
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="center sliding">View 3</div>
                </div>
            </div>
            <div class="pages navbar-through">
                <div class="page" data-page="home-3">
                    <div class="page-content">
                        <div class="content-block">
                            <p>This is view 3</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tab 4 - View 4 -->
        <div id="tab4" class="view tab">
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="center sliding">我的</div>
                </div>
            </div>
            <div class="pages navbar-through">
                <div class="page" data-page="home-4">
                    <div class="page-content">
                        <!-- 头部登陆 -->
                        <a href="<?=Url::toRoute('user/login')?>" class="open-preloader">
                            <div class="login">
                                <img src="../image/personal_bkg.jpg" alt="" class="loginbg">
                                <img src="../image/profile_default.png" alt="" class="personal_logo">
                                <div class="userinfo">
                                    <div id="userLoginName" class="title">点击去登录</div>
                                    <div id="userLevel" class="subtitle">余额: 0.00 元</div>
                                </div>
                                <img src="../image/personal_icon_arrow.png" alt="" class="person_arrow">
                            </div>
                        </a>
                        <div class="list-block">
                            <!-- First group-->
                            <div class="list-group">
                                <ul>
                                    <li class="list-group-title">First group</li>
                                    <li class="item-content">
                                        <div class="item-media"><i class="icon icon-f7"></i></div>
                                        <div class="item-inner">
                                            <div class="item-title">Item title</div>
                                            <div class="item-after">Label</div>
                                        </div>
                                    </li>
                                    <li class="item-content">
                                        <div class="item-media"><i class="icon icon-f7"></i></div>
                                        <div class="item-inner">
                                            <div class="item-title">Item with badge</div>
                                            <div class="item-after"><span class="badge">5</span></div>
                                        </div>
                                    </li>
                                    ...
                                </ul>
                            </div>

                            <!-- Second group-->
                            <div class="list-group">
                                <ul>
                                    <li class="list-group-title">Second Group</li>
                                    <li class="item-content">
                                        <div class="item-media"><i class="icon icon-f7"></i></div>
                                        <div class="item-inner">
                                            <div class="item-title">Item title</div>
                                            <div class="item-after">Label</div>
                                        </div>
                                    </li>
                                    <li class="item-content">
                                        <div class="item-media"><i class="icon icon-f7"></i></div>
                                        <div class="item-inner">
                                            <div class="item-title">Item with badge</div>
                                            <div class="item-after"><span class="badge">5</span></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tab bar with tab links -->
        <div class="toolbar tabbar tabbar-labels">
            <div class="toolbar-inner">
                <a href="#tab1" class="tab-link active">
                    <i class="icon tabbar-demo-icon-1"></i>
                    <span class="tabbar-label">首页</span>
                </a>
                <a href="#tab2" class="tab-link">
                    <i class="icon tabbar-demo-icon-2"></i>
                    <span class="tabbar-label">分类</span>
                </a>
                <a  href="#tab3" class="tab-link">
                    <i class="icon tabbar-demo-icon-3"><span class="badge bg-red">5</span></i>
                    <span class="tabbar-label">购物车</span>
                </a>
                <a href="#tab4" class="tab-link">
                    <i class="icon tabbar-demo-icon-4"></i>
                    <span class="tabbar-label">我的</span>
                </a>
            </div>
        </div>
    </div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>




