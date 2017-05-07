<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2015-06-22
 * @email 908601756@qq.com
 * @copyright Copyright © 2015年 EleTeam
 * @license The MIT License (MIT)
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'image') ?>

    <?= $form->field($model, 'featured_image') ?>

    <?= $form->field($model, 'image_small') ?>

    <?= $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'sort') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'featured_price') ?>

    <?php // echo $form->field($model, 'featured_position') ?>

    <?php // echo $form->field($model, 'featured_position_sort') ?>

    <?php // echo $form->field($model, 'app_featured_home') ?>

    <?php // echo $form->field($model, 'app_featured_home_sort') ?>

    <?php // echo $form->field($model, 'app_featured_image') ?>

    <?php // echo $form->field($model, 'short_description') ?>

    <?php // echo $form->field($model, 'meta_keywords') ?>

    <?php // echo $form->field($model, 'meta_description') ?>

    <?php // echo $form->field($model, 'is_audit') ?>

    <?php // echo $form->field($model, 'remarks') ?>

    <?php // echo $form->field($model, 'featured') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'category_id') ?>

    <?php // echo $form->field($model, 'image_medium') ?>

    <?php // echo $form->field($model, 'image_large') ?>

    <?php // echo $form->field($model, 'app_featured_topic') ?>

    <?php // echo $form->field($model, 'app_featured_topic_sort') ?>

    <?php // echo $form->field($model, 'app_long_image1') ?>

    <?php // echo $form->field($model, 'app_long_image2') ?>

    <?php // echo $form->field($model, 'app_long_image3') ?>

    <?php // echo $form->field($model, 'type_id') ?>

    <?php // echo $form->field($model, 'app_long_image4') ?>

    <?php // echo $form->field($model, 'app_long_image5') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
