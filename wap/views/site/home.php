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
 * @var $articles
 * @var $article common\models\CmsArticle
 */
?>
<div class="page" data-page="home">
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
        <div class="list-block cards-list">
            <ul>
                <?php foreach($articles as $article):?>
                    <li class="card">
                        <a href="<?=Url::toRoute('/article/view?id=').$article->id?>" data-ignore-cache="true">
                            <div class="card-header"><?=$article->title?></div>
                            <div class="card-content">
                                <div class="card-content-inner"><?=Html::img($article->image)?></div>
                            </div>
                        </a>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
</div>

