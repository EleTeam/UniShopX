<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2017-01-19
 * @email 908601756@qq.com
 * @copyright Copyright © 2017年 EleTeam
 * @license The MIT License (MIT)
 */

use yii\helpers\Url;
use common\models\Address;

/**
 * @var $this yii\web\View
 * @var $addresses Address[]
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
        <div class="center sliding">收货地址</div>
    </div>
</div>
<div class="page no-tabbar address" data-page="address">
    <div class="page-content">
        <?php if($addresses): ?>
            <?php foreach($addresses as $address): ?>
            <div class="list-block">
                <ul>
                    <li class="swipeout">
                        <div class="swipeout-content item-content">
                            <div class="card" data-addressid="8127" data-cityid="110100">
                                <div class="card-header">
                                    <div class="box-flex">
                                        <span><?=$address->fullname?></span>
                                        <?php if($address->is_default): ?>
                                        <span class="address-default">默认地址</span>
                                        <?php endif;?>
                                    </div>
                                    <div class="box-flex text-right"><?=$address->telephone?></div>
                                </div>
                                <div class="card-content">
                                    <div class="card-content-inner font-gray-light"><?= $address->area ? $address->area->getPathNames4Print().' '.$address->detail : ''?></div>
                                </div>
                            </div>
                        </div>
                        <div class="swipeout-actions-right">
                            <a href="#" class="action1 swipeout-delete">删除</a>
                        </div>
                    </li>
                </ul>
            </div>
            <?php endforeach;?>
        <?php else: ?>
            <p class="font-gray-status no-address">您还没有添加过任何地址哦!</p>
        <?php endif; ?>
    </div>
    <div class="addressToolbar toolbar">
        <div class="toolbar-inner box">
            <a href="" class="btn btn-blue box-flex">添加收货地址</a>
        </div>
    </div>
</div>