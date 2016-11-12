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

$this->title = Yii::t('app', 'Products');

/* @var $this yii\web\View */
/* @var $categories */
?>

    <?php foreach($categories as $category): ?>
        <?php foreach($category->products as $product): ?>
            <div class="row">
                <?= Html::a($product->name, ['product/view', 'id' => $product->id], ['class' => 'btn btn-primary']) ?>
            </div>
        <?php endforeach; ?>
    <?php endforeach; ?>

<!-- /.row -->