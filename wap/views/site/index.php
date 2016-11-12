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