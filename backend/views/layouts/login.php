<?php
/**
 * ETShop-PHP-Yii2
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
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="/adminlte/others/html5shiv.min.js"></script>
    <script src="/adminlte/others/respond.min.js"></script>
    <![endif]-->
    <?php $this->head() ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<?php $this->beginBody() ?>
<div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <?= $content ?>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php include_once '_footer.php'?>
</div>
<!-- ./wrapper -->
</body>
<?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>