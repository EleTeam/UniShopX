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
use common\models\Address;
use common\models\Cart;

/**
 * @var $this yii\web\View
 * @var $address Address
 * @var $cart Cart
 * @var $total_price float
 * @var $cart_num int
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
        <div class="list-block address-list-block">
            <ul>
                <input value="<?= $address ? $address->id : 0?>" name="address-id" type="hidden">
                <li class="row item-content">
                    <div class="col-10">
                        <i class="icon icon-address-pin"></i>
                    </div>
                    <div class="col-80">
                        <a href="<?=Url::toRoute('/address')?>" data-ignore-cache="true">
                            <div class="address-container">
                                <?php if($address): ?>
                                    <div class="item-inner row">
                                        <div class="item-title">收 货 人：<span><?=$address->fullname?></span></div>
                                        <div class="item-after"><span><?=$address->telephone?></span></div>
                                    </div>
                                    <div class="item-inner row">
                                        <div class="col-100">
                                            <span><?= $address->area ? $address->area->getPathNames4Print().' '.$address->detail : ''?></span>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="item-inner row">
                                        <div class="item-title">添加收货地址</div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </a>
                    </div>
                    <div class="col-10">
                        <i class="icon icon-right font-gray-light"></i>
                    </div>
                </li>
                <li class="line"></li>
            </ul>
        </div>
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
                        <a class="button button-fill" name="submitCart" href="<?=Url::toRoute('/order/add')?>">提交订单</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>