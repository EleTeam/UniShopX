<?php
/**
 * ETShop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2016-08-08
 * @email 908601756@qq.com
 * @copyright Copyright © 2016年 EleTeam
 * @license The MIT License (MIT)
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\OrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'created_by') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'address_detail') ?>

    <?php // echo $form->field($model, 'address_fullname') ?>

    <?php // echo $form->field($model, 'address_telephone') ?>

    <?php // echo $form->field($model, 'area_id') ?>

    <?php // echo $form->field($model, 'area_name') ?>

    <?php // echo $form->field($model, 'area_parent_id') ?>

    <?php // echo $form->field($model, 'area_path_ids') ?>

    <?php // echo $form->field($model, 'area_path_names') ?>

    <?php // echo $form->field($model, 'area_simple_name') ?>

    <?php // echo $form->field($model, 'area_zip_code') ?>

    <?php // echo $form->field($model, 'cart_id') ?>

    <?php // echo $form->field($model, 'cookie_id') ?>

    <?php // echo $form->field($model, 'ip') ?>

    <?php // echo $form->field($model, 'preorder_id') ?>

    <?php // echo $form->field($model, 'serial_no') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'total_price') ?>

    <?php // echo $form->field($model, 'total_count') ?>

    <?php // echo $form->field($model, 'print_count') ?>

    <?php // echo $form->field($model, 'coupon_item_id') ?>

    <?php // echo $form->field($model, 'coupon_item_total_price') ?>

    <?php // echo $form->field($model, 'origin_total_price') ?>

    <?php // echo $form->field($model, 'address_id') ?>

    <?php // echo $form->field($model, 'has_paid') ?>

    <?php // echo $form->field($model, 'pay_type') ?>

    <?php // echo $form->field($model, 'notice') ?>

    <?php // echo $form->field($model, 'rough_pay_type') ?>

    <?php // echo $form->field($model, 'status_id') ?>

    <?php // echo $form->field($model, 'op_transaction_id') ?>

    <?php // echo $form->field($model, 'status_union') ?>

    <?php // echo $form->field($model, 'min_total_price_label') ?>

    <?php // echo $form->field($model, 'paid_date') ?>

    <?php // echo $form->field($model, 'store_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
