<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2017-01-16
 * @email 908601756@qq.com
 * @copyright Copyright © 2017年 EleTeam
 * @license The MIT License (MIT)
 */

use yii\helpers\Url;
use common\models\Cart;

/**
 * @var $this yii\web\View
 * @var $cart Cart
 * @var $total_price float
 * @var $cart_num int
 * @var $is_logged_in int
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
        <div class="center sliding">提交订单</div>
    </div>
</div>
<div class="page no-tabbar preorder" data-page="cart">
    <div class="page-content">
        <div class="shopping-group">
                <div class="list-block shoppingCar-list-block media-list">
                    <ul>
                        <?php foreach($cart->cartItems as $cartItem): ?>
                            <li class="item-content swipeout" data-cart-item-id="<?=$cartItem->id?>" data-product-id="<?=$cartItem->product->id?>">
                                <div class="swipeout-content item-content">
                                    <div class="pro-pic">
                                        <a class="pro-info" href="<?=Url::toRoute('/product/view?id=').$cartItem->product->id?>">
                                            <img src="<?=$cartItem->product->image_small?>" onerror="this.src='../image/no_image.jpg';" width="100">
                                        </a>
                                    </div>
                                    <div class="item-inner">
                                        <a class="pro-info" href="<?=Url::toRoute('/product/view?id=').$cartItem->product->id?>">
                                            <div class="title"><?=$cartItem->product->name?></div>
                                            <?php foreach($cartItem->productSku->productSpecs as $index => $productSpec): ?>
                                                <?php $productSpecValue = $cartItem->productSku->productSpecValues[$index]; ?>
                                                <div class="item-title-row">
                                                    <p class="type" data-spec-id="<?=$productSpec->id?>" data-spec-value-id="<?=$productSpecValue->id?>">
                                                        <?=$productSpec->name?>: <?=$productSpecValue->name?>
                                                    </p>
                                                </div>
                                            <?php endforeach; ?>
                                        </a>
                                        <div class="item-title-row oppRule_choose">
                                            <div class="price">x<?=$cartItem->count?> &nbsp;&nbsp;&nbsp; ¥<?=$cartItem->productSku->price?></div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <div class="seperator padding-none"></div>
                        <?php endforeach; ?>
                    </ul>
                </div>
        </div>
    </div>
    <div class="toolbar">
        <div class="toolbar-inner">
            <!--购物车底部结算模块-->
            <div class="list-block shoppingCar-list-block">
                <div class="item-content box">
                    <div class="box-flex">
                        <div class="item-inner">
                            <div>总计：<b class="price">￥<?=$total_price?></b></div>
                            <small class="font-gray-status">(免配送费)</small>
                        </div>
                    </div>
                    <div class="box-flex">
                        <a class="button button-fill" name="submitCart"
                            <?php if($is_logged_in): ?>
                                href="<?=Url::toRoute('/preorder')?>"
                            <?php else: ?>
                                href="<?=Url::toRoute('/user/login?reload_page=/cart')?>"
                            <?php endif; ?>
                        >提交订单(<span class="num"><?=$cart_num?></span>)</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>