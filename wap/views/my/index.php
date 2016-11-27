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

/* @var $this yii\web\View */
/* @var $user common\models\User */
?>
<div class="page" data-page="my">
    <div class="page-content my">
        <!-- 头部登陆 -->
        <a href="<?=Yii::$app->user->isGuest ? Url::toRoute('user/login') : Url::toRoute('user/view')?>">
            <div class="login">
                <img src="../image/personal_bkg.jpg" alt="" class="loginbg">
                <img src="../image/profile_default.png" alt="" class="personal_logo">
                <div class="userinfo">
                    <div id="userLoginName" class="title"><?= $user ? $user->mobile : '点击去登录' ?></div>
                    <div id="userLevel" class="subtitle">余额: 0.00 元</div>
                </div>
                <img src="../image/personal_icon_arrow.png" alt="" class="person_arrow">
            </div>
        </a>

        <!-- 第一块 -->
        <div class="firstblock">
            <div class="item" tapmode="presshover" onclick="openOrderList()">
                <img src="../image/my_order_user_icon_normal.png" alt="" class="item_ico">
                <span>我的订单</span>
                <img src="../image/arrow.png" alt="" class="item_arrow">
            </div>
            <div class="h1"></div>
            <ul class="menu-list">
                <li>
                    <a tapmode="presshover" onclick="openOrderPendingPay()">
                        <img alt="" src="../image/icon_wallet.png">
                        <p>待付款</p>
                    </a>
                </li>
                <li>
                    <a tapmode="presshover" onclick="openOrderDelivering()">
                        <img alt="" src="../image/icon_car.png">
                        <p>待收货</p>
                    </a>
                </li>
                <li>
                    <a tapmode="presshover" onclick="openOrderFinished()">
                        <img alt="" src="../image/icon_review.png">
                        <p>交易完成</p>
                    </a>
                </li>
            </ul>
            <!--
            <div class="h1"></div>
            <div class="item" tapmode="presshover" onclick="openLogin()">
                <img src="../image/my_wallet_user_icon_normal.png" alt="" class="item_ico">
                <span>我的钱包</span>
                <img src="../image/arrow.png" alt="" class="item_arrow">
                <span class="fr hint">余额/返现/抵用券/会员卡</span>
            </div>
            -->
        </div>

        <!-- 第二块 -->
        <div class="secondblock">
            <div class="item" tapmode="presshover" onclick="openCouponList()">
                <img src="../image/my_coupon_user_icon_normal.png" alt="" class="item_ico">
                <span>优惠红包</span>
                <img src="../image/arrow.png" alt="" class="item_arrow">
            </div>
            <div class="h1"></div>
            <div class="item" tapmode="presshover" onclick="openCollectProductList()">
                <img src="../image/my_fans_icon_normal.png" alt="" class="item_ico">
                <span>我的收藏</span>
                <img src="../image/arrow.png" alt="" class="item_arrow">
            </div>
            <div class="h1"></div>
            <div class="item" tapmode="presshover" onclick="openHistoryProductList()">
                <img src="../image/my_history_user_icon_normal.png" alt="" class="item_ico">
                <span>最近浏览</span>
                <img src="../image/arrow.png" alt="" class="item_arrow">
            </div>
        </div>

        <!-- 第二块 -->
        <div class="h10"></div>
        <div class="secondblock">
            <div class="item" tapmode="presshover" onclick="openAboutMission()">
                <img src="../image/my_fans_icon_normal.png" class="item_ico">
                <span>使命感</span>
                <img src="../image/arrow.png" alt="" class="item_arrow">
            </div>
            <div class="h1"></div>
            <div class="item" tapmode="presshover" onclick="openAboutAddress()">
                <img src="../image/ic_address_40.png" class="item_ico">
                <span>门店地址</span>
                <img src="../image/arrow.png" alt="" class="item_arrow">
            </div>
            <div class="h1"></div>
            <div class="item" tapmode="presshover" onclick="openShare()">
                <img src="../image/my_review_user_icon_normal.png" alt="" class="item_ico">
                <span>微信分享</span>
                <img src="../image/arrow.png" alt="" class="item_arrow">
            </div>
        </div>

        <!-- 第三块 -->
        <div class="h10"></div>
        <div class="thirdblock">
            <div class="item" tapmode="presshover" onclick="openAboutSupport()">
                <img src="../image/my_favorite_user_icon_normal.png" class="item_ico">
                <span>技术支持</span>
                <img src="../image/arrow.png" alt="" class="item_arrow">
            </div>
            <div class="h1"></div>
            <div class="item" tapmode="presshover" onclick="openAboutUs()">
                <img src="../image/my_order_user_icon_normal.png" class="item_ico">
                <span>关于我们</span>
                <img src="../image/arrow.png" alt="" class="item_arrow">
            </div>
            <div class="h1"></div>
            <div class="item">
                <img src="../image/my_setting_user_icon_normal.png" alt="" class="item_ico">
                <span>设置</span>
                <img src="../image/arrow.png" alt="" class="item_arrow">
            </div>
            <div class="h70"></div>
        </div>
    </div>
</div>
