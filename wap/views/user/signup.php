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
<style type="text/css">
    .loginmore {margin-top: 20px;}
    .loginmore span {color: #0078ff;}
    .loginmore .forget {margin-left: 10px; color:red;}
    .loginmore .phone {margin-right: 10px;float: right;}
</style>
<!-- Top Navbar-->
<div class="navbar">
    <div class="navbar-inner">
        <div class="left">
            <a href="#" class="back link">
                <i class="icon icon-back"></i>
                <span>返回</span>
            </a>
        </div>
        <div class="center sliding">用户登录</div>
    </div>
</div>
<div class="page" data-page="user-signup">
    <div class="page-content login-screen-content">
        <div class="divider"></div>
            <form action="/app/user/login-post" id="user-login-form">
                <div class="item email"><img src="../image/login01.png" alt=""><input type="tel" placeholder="手机号" name="username"></div>
                <div class="item passwd"><img src="../image/login02.png" alt=""><input type="password" placeholder="密码" name="password"></div>
                <div class="btn" tapmode="buyhover" onclick="submitUserLoginForm()">登  录</div>
            </form>
            <div class="loginmore">
                <span class="forget" tapmode="presshover" onclick="openUserForgetPassword()" style="color:red;">忘记密码？</span>
                <span class="phone" tapmode="presshover" onclick="openUserRegister()">立即注册</span>
            </div>
    </div>
</div>
