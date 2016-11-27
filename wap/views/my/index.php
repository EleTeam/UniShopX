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

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $user common\models\User */
?>
<div class="page" data-page="my">
    <div class="page-content my">
        <!-- 头部登陆 -->
        <a href="<?=Yii::$app->user->isGuest ? Url::toRoute('user/login') : Url::toRoute('user/view')?>">
            <div class="login">
                <img src="../image/personal_bkg.jpg" alt="" class="loginbg">
                <img src="../image/profile_default.png" alt="" class="personal_logo">
                <div class="userinfo">
                    <div id="userLoginName" class="title"><?= $user ? $user->mobile : '点击去登录' ?></div>
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
