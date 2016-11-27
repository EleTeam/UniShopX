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
/* @var $banners */
?>
<!-- Top Navbar-->
<div class="navbar">
    <div class="navbar-inner">
        <div class="left">
            <a href="#" class="back link">
                <i class="icon icon-back"></i>
                <span>返回</span>
            </a>
        </div>
        <div class="center sliding">用户注册</div>
    </div>
</div>
<div class="page no-tabbar" data-page="user-signup">
    <div class="page-content user-signup">
        <form class="signup-form" action="<?=Url::toRoute('user/signup')?>">
            <input name="_csrf" type="hidden" value="<?=Yii::$app->request->csrfToken?>">
            <div class="item username"><img src="../image/login01.png" alt=""><input type="tel" placeholder="手机号" name="mobile"></div>
            <div class="item password"><img src="../image/login03.png" alt=""><input type="tel" placeholder="验证码: 8888" name="code"></div>
            <div class="item password"><img src="../image/login02.png" alt=""><input type="password" placeholder="设置登录密码" name="password"></div>
            <div class="btn signup-btn" data-reload-page="<?=Url::toRoute('/my')?>">注 册</div>
        </form>
    </div>
</div>
