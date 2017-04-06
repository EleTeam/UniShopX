<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2017-04-06
 * @email 908601756@qq.com
 * @copyright Copyright © 2017年 EleTeam
 * @license The MIT License (MIT)
 */

use yii\helpers\Url;
use common\models\Order;

/**
 * @var $this yii\web\View
 * @var $order Order
 */
?>
<!-- Top Navbar-->
<div class="navbar">
    <div class="navbar-inner">
        <div class="left">
            <!--
            <a href="#" class="back link">
                <i class="icon icon-back"></i>
                <span>返回</span>
            </a>
            -->
        </div>
        <div class="center sliding">订单提交成功</div>
    </div>
</div>
<div class="page no-tabbar order-success" data-page="order-success">
    <div class="page-content">
        <div class="bar"></div>
        <div class="show-tip success-tip">
            <div class="tip-text-wrap"><i></i><span class="tip-text">订单待支付</span></div>
            <div class="success-text"><?=$order->area_path_names?> <?=$order->address_detail?></div>
            <div class="success-text"><?=$order->address_fullname?> <?=$order->address_telephone?></div>
        </div>
        <div class="bar"></div>
        <div class="desc">
            <ul class="list order-info-list">
                <li class="list-item order-info-list-item"><span class="title-main">订单号：</span><span class="order-info"><?=$order->serial_no?></span></li>
                <li class="list-item order-info-list-item"><span class="title-main">订单总额：</span><span class="order-info">￥<?=$order->total_price?>元</span></li>
                <li class="list-item order-info-list-item"><span class="title-main">付款方式：</span><span class="order-info"></span></li>
                <!-- 注意不能使用 it.order.hasPaidString 的值，因为支付平台通知服务器是否付款成功是异步的 -->
                <li class="list-item order-info-list-item" style="border-bottom: 1px solid #f0f0f0;">
                    <span class="title-main">是否付款：</span><span class="order-info">
		    					未付款
	    				</span>
                </li>
            </ul>
            <div class="bar"></div>
            <div class="recommend">
                <ul id="recommendList2" class="recommend-list">
                    <li class="recommend-list-item">
                        <a href="#" class="app-link order-query js-goto-order" data-reload-page="<?=Url::toRoute('/my')?>">查看订单</a>
                    </li>
                    <li class="recommend-list-item">
                        <a href="#" class="app-link finish-index js-goto-home" data-reload-page="<?=Url::toRoute('/')?>">去首页</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!--
    <div class="toolbar">
        <div class="toolbar-inner">
            <!--购物车底部结算模块-- >
            <div class="list-block shoppingCar-list-block">
                <div class="item-content box">
                    <div class="box-flex">
                        <div class="item-inner">
                            <div>总计：<b class="price">￥<?=$order->total_price?></b></div>
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
    -->
</div>