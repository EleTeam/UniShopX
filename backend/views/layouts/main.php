<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2015-06-22
 * @email 908601756@qq.com
 * @copyright Copyright © 2015年 EleTeam
 * @license The MIT License (MIT)
 */

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <LINK rel="Bookmark" href="/favicon.ico" >
    <LINK rel="Shortcut Icon" href="/favicon.ico" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="/huiadmin/lib/html5.js"></script>
    <script type="text/javascript" src="/huiadmin/lib/respond.min.js"></script>
    <script type="text/javascript" src="/huiadmin/lib/PIE_IE678.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="/huiadmin/static/h-ui/css/H-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="/huiadmin/static/h-ui.admin/css/H-ui.admin.css" />
    <link rel="stylesheet" type="text/css" href="/huiadmin/lib/Hui-iconfont/1.0.7/iconfont.css" />
    <link rel="stylesheet" type="text/css" href="/huiadmin/lib/icheck/icheck.css" />
    <link rel="stylesheet" type="text/css" href="/huiadmin/static/h-ui.admin/skin/default/skin.css" id="skin" />
    <link rel="stylesheet" type="text/css" href="/huiadmin/static/h-ui.admin/css/style.css" />
    <!--[if IE 6]>
    <script type="text/javascript" src="/huiadmin/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <!-- jquery文件放在头部引用，是为了可以在controller下的页面写用到jquery的js和php+js混合写脚本 -->
    <script type="text/javascript" src="/huiadmin/lib/jquery/1.9.1/jquery.min.js"></script>
</head>
<body>
<?php $this->beginBody() ?>
<div class="page-container">
    <?=$content?>
</div>
<script type="text/javascript" src="/huiadmin/lib/layer/2.1/layer.js"></script>
<script type="text/javascript" src="/huiadmin/lib/icheck/jquery.icheck.min.js"></script>
<script type="text/javascript" src="/huiadmin/lib/jquery.validation/1.14.0/jquery.validate.min.js"></script>
<script type="text/javascript" src="/huiadmin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/huiadmin/lib/jquery.validation/1.14.0/messages_zh.min.js"></script>
<script type="text/javascript" src="/huiadmin/static/h-ui/js/H-ui.js"></script>
<script type="text/javascript" src="/huiadmin/static/h-ui.admin/js/H-ui.admin.js"></script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>