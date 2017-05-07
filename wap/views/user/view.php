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

/**
 * @var $user \common\models\User
 */
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
        <div class="center sliding">用户信息</div>
    </div>
</div>
<div class="page no-tabbar" data-page="user-view">
    <div class="page-content user-view">
        <div>用户ID: <?=$user->id?></div>
        <div>手机号: <?=$user->mobile?></div>
        <div class="back-btn" data-reload-page="<?=Url::toRoute('/my')?>">返回</div>
    </div>
</div>
