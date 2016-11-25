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
</head>
<body>
<?php $this->beginBody() ?>

<!-- Status bar overlay for fullscreen mode-->
<div class="statusbar-overlay"></div>

<!-- Panels overlay-->
<div class="panel-overlay"></div>

<!-- Views-->
<div class="views">
    <!-- Your main view, should have "view-main" class-->
    <div class="view view-main">
        <!-- Top Navbar-->
        <div class="navbar">
            <div class="navbar-inner">
                <div class="center sliding">月光茶人</div>
            </div>
        </div>

        <!-- Pages, because we need fixed-through navbar and toolbar, it has additional appropriate classes-->
        <div class="pages navbar-through toolbar-through">
            <?= $content ?>
        </div>

        <!-- Bottom Toolbar-->
        <div class="toolbar tabbar tabbar-labels">
            <div class="toolbar-inner">
                <a href="<?=Url::toRoute('/')?>" class="tab-link <?php echo $this->context->id == 'site' ? 'active' : '' ?>">
                    <i class="icon tabbar-demo-icon-1"></i>
                    <span class="tabbar-label">首页</span>
                </a>
                <a href="<?=Url::toRoute('/category')?>" class="tab-link <?php echo $this->context->id == 'category' ? 'active' : '' ?>">
                    <i class="icon tabbar-demo-icon-2"></i>
                    <span class="tabbar-label">分类</span>
                </a>
                <a  href="<?=Url::toRoute('/cart')?>" class="tab-link <?php echo $this->context->id == 'cart' ? 'active' : '' ?>">
                    <i class="icon tabbar-demo-icon-3"><span class="badge bg-red">5</span></i>
                    <span class="tabbar-label">购物车</span>
                </a>
                <a href="<?=Url::toRoute('/my')?>" class="tab-link <?php echo $this->context->id == 'my' ? 'active' : '' ?>">
                    <i class="icon tabbar-demo-icon-4"></i>
                    <span class="tabbar-label">我的</span>
                </a>
            </div>
        </div>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
