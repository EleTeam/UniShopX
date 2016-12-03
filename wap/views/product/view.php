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

/**
 * @var $this yii\web\View
 * @var $product common\models\Product
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
        <div class="center sliding">商品详情</div>
    </div>
</div>
<div class="page no-tabbar" data-page="product-view">
    <div class="page-content product-view">
        <div id="main">
            <!-- Swiper Slider -->
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php if($product->app_long_image1): ?>
                        <div class="swiper-slide">
                            <img data-src="<?= $product->app_long_image1 ?>" class="swiper-lazy">
                            <div class="preloader"></div>
                        </div>
                    <?php endif; ?>
                    <?php if($product->app_long_image2): ?>
                        <div class="swiper-slide">
                            <img data-src="<?= $product->app_long_image2 ?>" class="swiper-lazy">
                            <div class="preloader"></div>
                        </div>
                    <?php endif; ?>
                    <?php if($product->app_long_image3): ?>
                        <div class="swiper-slide">
                            <img data-src="<?= $product->app_long_image3 ?>" class="swiper-lazy">
                            <div class="preloader"></div>
                        </div>
                    <?php endif; ?>
                    <?php if($product->app_long_image4): ?>
                        <div class="swiper-slide">
                            <img data-src="<?= $product->app_long_image4 ?>" class="swiper-lazy">
                            <div class="preloader"></div>
                        </div>
                    <?php endif; ?>
                    <?php if($product->app_long_image5): ?>
                        <div class="swiper-slide">
                            <img data-src="<?= $product->app_long_image5 ?>" class="swiper-lazy">
                            <div class="preloader"></div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="swiper-pagination color-white"></div>
            </div>

            <!-- 3.  -->
            <div class="brief inwrap hightitem">
                <div class="title">
                    <?= $product->name ?>
                    <div style="float:right; padding-right:20px;">
                        <?php if($product->featured_price > 0): ?>
                        <span class="price">¥<?= $product->featured_price ?>&nbsp;&nbsp;</span>
                        <del class="o-price">¥<?= $product->price ?></del>
                        <?php else: ?>
                        <span class="price">¥<?= $product->price ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="describe"><?= $product->short_description ?></div>
            </div>

            <!-- 规格 -->
            <div class="select-title">规格</div>
            <div class="tuandetail hightitem inwrap">
            </div>

            <!-- 加料 -->
        </div>

        <div id="nav">
            <ul>
                <li data-productId="{{=it.product.id}}" data-hasCollected="true" class="active"><a class="collect">收藏</a></li>
                <li><a id="cartIcon" class="cart"><i class="shake" id="cart-num">3</i>购物车</a></li>
                <li class="add-cart"><a id="addToCart">加入购物车</a></li>
            </ul>
        </div>
    </div>
</div>


