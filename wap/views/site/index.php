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
        <div id="tab-home" class="view tab active">
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="center">月光茶人</div>
                </div>
            </div>
            <div class="pages navbar-through toolbar-through">
                <div class="page" data-page="home">
                    <div class="page-content">
                        <!-- ajax load -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Tab 2 - View 2 -->
        <div id="tab-category" class="view tab">
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="center">分类</div>
                </div>
            </div>
            <div class="pages navbar-through toolbar-through">
                <div class="page" data-page="category">
                    <div class="page-content">
                        <!-- ajax load -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Tab 3 - View 3 -->
        <div id="tab-cart" class="view tab">
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="center">购物车</div>
                </div>
            </div>
            <div class="pages navbar-through toolbar-through">
                <div class="page" data-page="cart">
                    <div class="page-content">
                        <!-- ajax load -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Tab 4 - View 4 -->
        <div id="tab-my" class="view tab">
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="center">我的</div>
                </div>
            </div>
            <div class="pages navbar-through toolbar-through">
                <div class="page" data-page="my">
                    <div class="page-content">
                        <!-- ajax load -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Tab bar with tab links -->
        <div class="toolbar tabbar tabbar-labels">
            <div class="toolbar-inner">
                <a class="tab-link active" href="#tab-home" id="tab-home-icon" data-url="<?=Url::toRoute('/site/home')?>">
                    <i class="icon tabbar-demo-icon-1"></i>
                    <span class="tabbar-label">首页</span>
                </a>
                <a class="tab-link" href="#tab-category" id="tab-category-icon" data-url="<?=Url::toRoute('/category')?>">
                    <i class="icon tabbar-demo-icon-2"></i>
                    <span class="tabbar-label">分类</span>
                </a>
                <a class="tab-link" href="#tab-cart" id="tab-cart-icon" data-url="<?=Url::toRoute('/cart')?>">
                    <i class="icon tabbar-demo-icon-3"><span class="badge bg-red">5</span></i>
                    <span class="tabbar-label">购物车</span>
                </a>
                <a class="tab-link" href="#tab-my" id="tab-my-icon" data-url="<?=Url::toRoute('/my')?>">
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




