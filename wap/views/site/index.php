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
 * @var $this yii\web\View
 * @var $banners
 * @var $articles
 */
?>

<style type="text/css">
    .swiper-container {
        height: 180px;
    }
    .swiper-slide {
        background: #fff;
        position: relative;
    }
    .swiper-slide img {
        position: absolute;
        left:50%;
        top:50%;
        max-width: 100%;
        max-height: 100%;
        -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }
</style>

<!-- Page, data-page contains page name-->
<div data-page="index" class="page">
    <!-- Scrollable page content-->
    <div class="page-content infinite-scroll">
        <!-- Swiper Slider -->
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php foreach($banners as $banner): ?>
                    <div class="swiper-slide">
                        <img data-src="<?=$banner->image?>" class="swiper-lazy">
                        <div class="preloader"></div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination color-white"></div>
        </div>


        <style>
            .card-content-inner {
                text-align: center;
            }
            .card-content-inner img {
                width: 100%;
                max-height: 300px;
            }
        </style>

        <div class="list-block cards-list"><ul>
            <?php foreach($articles as $article):?>
                <li class="card">
                    <a href="<?=Url::toRoute('/article/view?id=').$article->id?>">
                        <div class="card-header"><?=$article->title?></div>
                        <div class="card-content">
                            <div class="card-content-inner"><?=Html::img($article->image)?></div>
                        </div>
                    </a>
                </li>
            <?php endforeach;?>
        </ul></div>
    </div>
</div>

