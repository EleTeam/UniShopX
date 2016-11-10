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

/* @var $this yii\web\View */
/* @var $banners */
?>

    <?php foreach($banners as $banner): ?>
        <div class="row">
            <?= Html::img($banner->image) ?>
        </div>
    <?php endforeach; ?>
