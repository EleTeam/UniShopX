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
use common\models\Cart;

/**
 * @var $this yii\web\View
 * @var $cart Cart
 * @var $total_price float
 * @var $cart_num int
 * @var $is_logged_in int
 */
?>
<div class="navbar">
    <div class="navbar-inner">
        <div class="center sliding">购物车</div>
    </div>
</div>
<div class="page" data-page="cart">
    <div class="page-content cart">
        <?php if(!$is_logged_in): ?>
            <div class="cart-empty" style="display: block;">
                <div class="empty-tips">
                    <div>
                        <a href="<?=Url::toRoute('/user/login?reload_page=/cart')?>">
                            登录后可同步账户购物车中的商品
                        </a>
                    </div>
                    <div class="float-right">
                        <a href="<?=Url::toRoute('/user/login?reload_page=/cart')?>"><i class="icon icon-right"></i></a>
                    </div>
                </div>
                <?php if(!($cart && $cart->cartItems)): ?>
                <div class="noPro">
                    <img src="../image/ic_cart_empty.png">
                    <div>购物车没有商品哦~</div>
                    <div id="goShopping"><a href="#" class="">去逛逛</a></div>
                </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php if($cart && $cart->cartItems): ?>
            <div class="shoppingCarMod">
                <div class="shopping-group">
                    <div class="list-block shoppingCar-list-block media-list">
                        <ul>
                            <?php foreach($cart->cartItems as $cartItem): ?>
                            <li class="item-content swipeout" data-cart-item-id="<?=$cartItem->id?>" data-product-id="<?=$cartItem->product->id?>">
                                <div class="swipeout-content item-content">
                                    <label class="label-checkbox">
                                        <input name="cart-ids" value="<?=$cart->id?>" type="checkbox"
                                               <?php if($cartItem->is_selected): ?>checked="checked"<?php endif; ?>>
                                        <div class="item-media"><i class="icon icon-form-checkbox"></i></div>
                                    </label>
                                    <div class="pro-pic">
                                        <a class="pro-info">
                                            <img src="<?=$cartItem->product->image_small?>" onerror="this.src='../image/no_image.jpg';" width="100">
                                        </a>
                                    </div>
                                    <div class="item-inner">
                                        <div class="title"><?=$cartItem->product->name?></div>
                                        <?php foreach($cartItem->productSku->productSpecs as $index => $productSpec): ?>
                                            <?php $productSpecValue = $cartItem->productSku->productSpecValues[$index]; ?>
                                            <div class="item-title-row">
                                                <p class="type" data-spec-id="<?=$productSpec->id?>" data-spec-value-id="<?=$productSpecValue->id?>">
                                                    <?=$productSpec->name?>: <?=$productSpecValue->name?>
                                                </p>
                                            </div>
                                        <?php endforeach; ?>
                                        <div class="item-title-row oppRule_choose">
                                            <div class="price">¥ <?=$cartItem->productSku->price?></div>
                                            <div class="choose text-center" data-stock="199">
                                                <a href="#" class="plus" name="plus" data-cartid="70011">-</a>
                                                <input readonly="readonly" class="num_value" value="<?=$cartItem->count?>" type="text">
                                                <a href="#" class="add" name="add" data-cartid="70011">+</a>
                                            </div>
                                            <input name="leastNum" value="1" type="hidden">
                                        </div>

                                    </div>
                                </div>
                                <div class="swipeout-actions-right">
                                    <a href="#" class="action1">
                                        <!-- <i class="fa fa-trash-o fa-2x"></i> -->
                                        删除
                                    </a>
                                </div>
                            </li>
                            <div class="seperator padding-none"></div>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>
    <div class="toolbar shoppingCarToolbar">
        <div class="toolbar-inner">
            <!--购物车底部结算模块-->
            <div class="list-block shoppingCar-list-block">
                <div class="item-content box">
                    <div class="box-flex">
                        <label class="label-checkbox">
                            <input name="my-checkbox" type="checkbox">
                            <div class="item-media">
                                <i class="icon icon-form-checkbox"></i>&nbsp;
                                <span class="check-all-btn">全选</span>
                            </div>
                        </label>
                    </div>
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
                            >结算(<span class="num"><?=$cart_num?></span>)</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>