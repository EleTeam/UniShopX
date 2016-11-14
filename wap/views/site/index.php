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

/* @var $this yii\web\View */
/* @var $banners */
?>

<style>
    .swiper-container {
        width: 100%;
        height: 180px;
    }
</style>

<!-- Slider -->
<div class="swiper-container" data-space-between='10' data-height="10px">
    <div class="swiper-wrapper">
        <?php foreach($banners as $banner): ?>
        <div class="swiper-slide"><?=Html::img($banner->image)?></div>
        <?php endforeach; ?>
    </div>
    <div class="swiper-pagination"></div>
</div>

<style>
    .facebook-card .card-header {
        display: block;
        padding: 10px;
    }
    .facebook-card .facebook-avatar {
        float: left;
    }
    .facebook-card .facebook-name {
        margin-left: 44px;
        font-size: 14px;
        font-weight: 500;
    }
    .facebook-card .facebook-date {
        margin-left: 44px;
        font-size: 13px;
        color: #8e8e93;
    }
    .facebook-card .card-footer {
        background: #fafafa;
    }
    .facebook-card .card-footer a {
        color: #81848b;
        font-weight: 500;
    }
    .facebook-card .card-content img {
        display: block;
    }
    .facebook-card .card-content-inner {
        padding: 15px 10px;
    }
</style>

<div class="content-block-title">Facebook Cards</div>

<div class="card facebook-card">
    <div class="card-header no-border">
        <div class="facebook-avatar"><img src="..." width="34" height="34"></div>
        <div class="facebook-name">John Doe</div>
        <div class="facebook-date">Monday at 3:47 PM</div>
    </div>
    <div class="card-content"><img src="..." width="100%"></div>
    <div class="card-footer no-border">
        <a href="#" class="link">Like</a>
        <a href="#" class="link">Comment</a>
        <a href="#" class="link">Share</a>
    </div>
</div>

<div class="card facebook-card">
    <div class="card-header">
        <div class="facebook-avatar"><img src="..." width="34" height="34"></div>
        <div class="facebook-name">John Doe</div>
        <div class="facebook-date">Monday at 2:15 PM</div>
    </div>
    <div class="card-content">
        <div class="card-content-inner">
            <p>What a nice photo i took yesterday!</p>
            <img src="..." width="100%">
            <p class="color-gray">Likes: 112    Comments: 43</p>
        </div>
    </div>
    <div class="card-footer">
        <a href="#" class="link">Like</a>
        <a href="#" class="link">Comment</a>
        <a href="#" class="link">Share</a>
    </div>
</div>