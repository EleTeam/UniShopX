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

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $name;
?>
<div class="navbar">
    <div class="navbar-inner">
        <div class="left">
            <a href="#" class="back link">
                <i class="icon icon-back"></i>
                <span>返回</span>
            </a>
        </div>
        <div class="center sliding">页面不存在</div>
    </div>
</div>
<div class="page no-tabbar" data-page="site-error">
    <div class="page-content site-error">
        <h1>访问页面不存在</h1>
        <button class="go-to-home" data-reload-page="<?=Url::toRoute('/home')?>">点击去首页</button>
    </div>
</div>