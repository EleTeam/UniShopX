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
        <div><?=$product->name?></div>
    </div>
</div>


