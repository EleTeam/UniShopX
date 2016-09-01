<?php
/**
 * ETShop-PHP-Yii2
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
/* @var $model common\models\CategorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'featured') ?>

    <?= $form->field($model, 'image') ?>

    <?= $form->field($model, 'featured_image') ?>

    <?= $form->field($model, 'image_small') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'parent_id') ?>

    <?php // echo $form->field($model, 'sort') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'short_description') ?>

    <?php // echo $form->field($model, 'app_featured_home') ?>

    <?php // echo $form->field($model, 'app_featured_home_sort') ?>

    <?php // echo $form->field($model, 'parent_ids') ?>

    <?php // echo $form->field($model, 'remarks') ?>

    <?php // echo $form->field($model, 'meta_keywords') ?>

    <?php // echo $form->field($model, 'meta_description') ?>

    <?php // echo $form->field($model, 'href') ?>

    <?php // echo $form->field($model, 'href_target') ?>

    <?php // echo $form->field($model, 'image_medium') ?>

    <?php // echo $form->field($model, 'image_large') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
