<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2016-11-28
 * @email 908601756@qq.com
 * @copyright Copyright © 2016年 EleTeam
 * @license The MIT License (MIT)
 */

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $user common\models\User */
?>
<div class="navbar">
    <div class="navbar-inner">
        <div class="left">
            <a href="#" class="back link">
                <i class="icon icon-back"></i>
                <span>返回</span>
            </a>
        </div>
        <div class="center sliding">设置</div>
    </div>
</div>
<div class="page" data-page="my-setting">
    <div class="page-content my-setting">
        <div class="h10"></div>
        <div class="firstblock">
            <div class="item">
                <span>清除缓存</span>
                <img src="../image/arrow.png" alt="" class="item_arrow">
            </div>
        </div>
        <!--
    <div class="firstblock">
        <div class="item" tapmode="presshover" onclick="openLogin()">
            <span>图片设置</span>
            <img src="../image/arrow.png" alt="" class="item_arrow">
        </div>
        <div class="h1"></div>
        <div class="item" tapmode="presshover" onclick="openLogin()">
            <span>消息提醒设置</span>
            <img src="../image/arrow.png" alt="" class="item_arrow">
        </div>
        <div class="h1"></div>
        <div class="item" tapmode="presshover" onclick="clearCache()">
            <span>清除缓存</span>
            <img src="../image/arrow.png" alt="" class="item_arrow">
        </div>
    </div>

        -->


        <!-- 第二块 -->
        <!--
        <div class="h10"></div>
        <div class="secondblock">
            <div class="h1"></div>
            <div class="item" tapmode="presshover" onclick="openLogin()">
                <span>自动下载安装包</span>
                <span class="fr hint">仅Wi-Fi网络</span>
            </div>
        </div>
        -->

        <div class="h10"></div>
        <div class="thirdBlock">
            <form class="logout-form" action="<?=Url::toRoute('/user/logout')?>">
                <input name="_csrf" type="hidden" value="<?=Yii::$app->request->csrfToken?>">
                <div class="item logout-btn" data-reload-page="<?=Url::toRoute('/my')?>">
                    <span>退出登录</span>
                    <img src="../image/arrow.png" alt="" class="item_arrow">
                </div>
            </form>
        </div>
    </div>
</div>
