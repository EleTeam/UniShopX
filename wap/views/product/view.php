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
use common\models\ProductSpec;

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
<div class="page no-tabbar product-view" data-page="product-view">
    <div class="page-content">
        <!-- post提交的CSRF令牌验证 -->
        <input type="hidden" value="<?=Yii::$app->request->getCsrfToken()?>" name="_csrf" />
        <input type="hidden" value="<?=$product->id?>" name="product_id" />

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

            <div class="list-block">
                <ul>
                    <li class="open-model">
                        <a href="#" class="item-link item-content open-spec-modal" name="detail-spec">
                            <div class="item-inner" id="choose-spec-container">规格区</div>
                        </a>
                    </li>
                    <li class="open-model">
                        <a href="#" class="item-link item-content" name="detail-spec">
                            <div class="item-inner">加料区</div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- 顶部工具栏 -->
    <div class="toolbar">
        <div class="toolbar-inner shopping-bar box">
            <div class="shopcart">
                <a href="html/cart.html">
                    <img src="../image/shoppingcart3x.png">
                    <span class="bage font5 cart-num" id="product-cart-num">0</span>
                </a>
            </div>
            <div class="box box-flex open-model">
                <a href="#" class="btn btn-gold cart box-flex add-to-cart" data-url="<?=Url::toRoute('/cart/add-item')?>">加入购物车</a>
                <a href="#" class="btn btn-blue box-flex" id="direct-buy" name="detail-spec">立即购买</a>
            </div>
        </div>
    </div>

    <!-- 规格区弹出层 -->
    <div class="picker-modal choose-size modal-in spec-modal">
        <div class="product-title">
            <img class="product-img" src="<?=$product->image_small?>">
            <h3 class="font-gold">¥<span id="pro-detail-price" name="pro-detail-price">83.00</span></h3>
            <h5>库存<span id="pro-detail-stock">20</span>件</h5>
            <a href="#" class="close-choose-size close-spec-modal"><img src="../image/ic_close_btn.png"></a>
            <input name="skuid" type="hidden">
            <input name="specnames" type="hidden">
            <input name="leastNum" value="1" type="hidden">
        </div>
        <div class="size-list spec-box">
            <?php foreach($product->specsArray as $spec_id => $spec_values): ?>
                <?php
                    $spec = ProductSpec::findOneActive($spec_id);
                    if(!$spec){
                        continue;
                    }
                ?>
                <div class="size-item box spec-item">
                    <!-- 存储sku_id和spec_value_ids, 在site.js里根据选中的规格值组合成spec_value_id, 从而找到sku_id -->
                    <?php foreach($product->productSkus as $sku): ?>
                    <i style="display: none" class="skus" data-sku-id="<?=$sku->id?>" data-spec-value-ids="<?=$sku->spec_value_ids?>"></i>
                    <?php endforeach; ?>

                    <label class="title"><?=$spec->name?></label>
                    <div class="box-flex">
                        <?php foreach($spec_values as $spec_value_id => $spec_value_name): ?>
                        <!-- class="is-selected" 为被选择的规格值 -->
                        <span data-spec-value-id="<?=$spec_value_id?>" class="spec-value" name="spec-value"><?=$spec_value_name?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="size-item shop-count">
                <label>数量</label>
                <span name="plus">-</span>
                <input readonly="readonly" value="1" name="product-count" type="tel">
                <span name="add">+</span>
            </div>
            <div class="limit-tips">*限购<span></span>件，超出以结算价为准</div>
        </div>
        <div class="comfire box">
            <a href="#" class="btn btn-gold cart box-flex add-to-cart" data-url="<?=Url::toRoute('/cart/add-item')?>">加入购物车</a>
            <a href="#" class="btn btn-blue box-flex submit">立即购买</a>
        </div>
    </div>
</div>


