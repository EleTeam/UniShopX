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
        <?php if($cart && $cart->cartItems): ?>
            <div class="shoppingCarMod">
                <div class="shopping-group">
                    <div class="list-block shoppingCar-list-block media-list">
                        <ul>
                            <?php foreach($cart->cartItems as $cartItem): ?>
                            <li class="item-content swipeout" data-cart-item-id="<?=$cartItem->id?>" data-product-id="<?=$cartItem->product->id?>">
                                <div class="swipeout-content item-content">
                                    <label class="label-checkbox">
                                        <input name="my-checkbox" data-id="6711471333122342" type="checkbox">
                                        <div class="item-media"><i class="icon icon-form-checkbox"></i></div>
                                    </label>
                                    <div class="pro-pic" data-id="6711471333122342">
                                        <a class="pro-info">
                                            <img src="<?=$cartItem->product->image_small?>" onerror="this.src='../image/no_image.jpg';" width="100">
                                        </a>
                                    </div>
                                    <div class="item-inner">
                                        <div class="title" data-id="6711471333122342"><?=$cartItem->product->id?></div>
                                        <div class="item-title-row">
                                            <p class="type" data-id="6711471333122342">色号:MB自然肤色  </p>
                                        </div>
                                        <div class="item-title-row oppRule_choose">
                                            <div class="price" data-id="6711471333122342">¥ <?=$cartItem->productSku->price?></div>
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
        <?php else: ?>
            <div class="cart-empty" style="display: block;">
                <div class="empty-tips">
                    <div>
                        <a href="html/uyac-login.html">
                            登录后可同步账户购物车中的商品
                        </a>
                    </div>
                    <div class="float-right">
                        <a href="html/uyac-login.html"><i class="icon icon-right"></i></a>
                    </div>
                </div>
                <div class="noPro">
                    <img src="../image/ic_cart_empty.png">
                    <div>购物车没有商品哦~</div>
                    <div id="goShopping"><a href="#" class="">去逛逛</a></div>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>