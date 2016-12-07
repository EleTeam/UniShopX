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

$this->title = Yii::t('app', 'Products');

/**
 * @var $this yii\web\View
 * @var $categories array
 * @var $category common\models\ProductCategory
 * @var $product common\models\Product
 */
?>
<div class="navbar">
    <div class="navbar-inner">
        <div class="center sliding">分类</div>
    </div>
</div>
<div class="page" data-page="category">
    <div class="page-content category mti">
        <div id="menuwrap" class="menuwrap">
            <!-- 左栏 -->
            <div id="asidewrap" class="asidewrap">
                <div class="taglist"
                     style="transition-timing-function: cubic-bezier(0.1, 0.57, 0.1, 1); transition-duration: 0ms; transform: translate(0px, 0px) translateZ(0px);">
                    <?php foreach ($categories as $key => $category): ?>
                        <div id="tag100" class="j-tag tag <?php if ($key == 0): ?>focus<?php endif; ?>" data-key="100">
                            <div class="tag-inner">
                                <span class="tag-text"><img class="tag-icon" src="../image/icon_hot.png" alt=""><?= $category->name ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div><!-- /左栏 -->
            <!-- 右栏 -->
            <div id="mainwrap" class="mainwrap">
                <div class="foodlistwrap"
                     style="transition-timing-function: cubic-bezier(0.1, 0.57, 0.1, 1); transition-duration: 0ms; transform: translate(0px, 0px) translateZ(0px);">
                    <!-- Swiper Slider -->
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                    <?php foreach ($categories as $key => $category): ?>
                            <div class="swiper-slide" style="height: auto">
                        <div id="foodlist100" class="j-foodlist foodlist" data-tagid="100">
                            <h3 class="foodlist-label"><?= $category->name ?></h3>
                            <ul>
                                <?php foreach ($category->products as $key2 => $product): ?>
                                    <li class="j-fooditem fooditem food128646664" data-spuid="128646664" data-skuid="137125422"
                                        data-actv-type="0" data-actv-n="0" data-actv-x="1"
                                        data-price="10" data-origin="10" data-stock="9999" data-attrs="24727306">
                                        <div class="food-content1 clearfix">
                                            <a href="<?= Url::toRoute(['/product/view', 'id'=>$product->id]) ?>">
                                                <div class="food-pic-wrap">
                                                    <img class="j-food-pic food-pic" src="<?= $product->image_small ?>" style="height: 62px;">
                                                </div>
                                            </a>
                                            <div class="food-cont">
                                                <a href="<?= Url::toRoute(['/product/view', 'id'=>$product->id]) ?>">
                                                    <div class="j-foodname foodname"><?= $product->name ?></div>
                                                    <div class="food-desc"><?= $product->short_description ?></div>
                                                    <div class="food-content1-sub">
                                                        <span>月售&nbsp;953</span>&nbsp;&nbsp;&nbsp;<span class="food-good">赞&nbsp;21</span>
                                                    </div>
                                                </a>
                                                <div class="j-item-console foodop clearfix">
                                                    <a class="j-add-item add-food" href="javascript:;">
                                                        <i class="icon i-add-food j-add-inner"></i>
                                                    </a>
                                                    <span class="j-item-num foodop-num">0</span>
                                                    <a class="j-remove-item remove-food" href="javascript:;">
                                                        <i class="icon i-remove-food"></i>
                                                    </a>
                                                </div>
                                                <div class="food-price-region">
                                                    <?php if($product->featured_price > 0): ?>
                                                        <span class="food-price">¥<?= $product->featured_price ?>&nbsp;&nbsp;</span>
                                                        <del class="food-price-gray">¥<?= $product->price ?></del>
                                                    <?php else: ?>
                                                        <span class="food-price"><?=$product->featured_price?>¥<?= $product->price ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                                </div>
                    <?php endforeach; ?>
                            </div>
                        </div>
                </div>
            </div><!-- /右栏 -->
        </div>
    </div>
</div>