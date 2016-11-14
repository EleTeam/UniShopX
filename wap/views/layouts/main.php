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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

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
            <a class="tab-item <?php echo $this->context->id == 'site' ? 'active' : '' ?>" href="<?=Url::toRoute('/')?>">
                <span class="icon icon-home"></span>
                <span class="tab-label">首页</span>
            </a>
            <a class="tab-item <?php echo $this->context->id == 'category' ? 'active' : '' ?>" href="<?=Url::toRoute('/category')?>">
                <span class="icon icon-menu"></span>
                <span class="tab-label">分类</span>
            </a>
            <a class="tab-item <?php echo $this->context->id == 'cart' ? 'active' : '' ?>" href="<?=Url::toRoute('/cart')?>"">
                <span class="icon icon-cart"></span>
                <span class="tab-label">购物车</span>
            </a>
            <a class="tab-item <?php echo $this->context->id == 'my' ? 'active' : '' ?>" href="<?=Url::toRoute('/my')?>"">
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

<?php $this->endBody() ?>

<script>
    $.init();
</script>

</body>
</html>
<?php $this->endPage() ?>
