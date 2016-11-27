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
<style type="text/css">
    /* 头部登陆 */
    .login {background-image: url('../image/personal_bkg.jpg');background-repeat: no-repeat; background-size: contain;position: relative;height:100px;}
    .loginbg {/*position: absolute;*/ width: 100%;}
    .login .personal_logo {position: absolute; top:30px; width: 70px; left: 70px;}
    .person_arrow {position: absolute;height: 20px; right: 10px; top:40px;}
    .login .userinfo {position: absolute; top:30px; margin-left: 150px;}
    .login .userinfo .title {font-size: 20px; color: #fff;}
    .login .userinfo .subtitle {font-size: 14px; color: #fff;border: 1px solid #fff;display: inline-block;padding: 3px;border-radius: 4px;margin-top: 5px;}
</style>
<div data-page="category-index" class="page">
    <div class="page-content">
        <!-- 头部登陆 -->
        <a href="<?=Url::toRoute('user/login')?>">
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
