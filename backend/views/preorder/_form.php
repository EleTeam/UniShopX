<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2016-08-02
 * @email 908601756@qq.com
 * @copyright Copyright © 2016年 EleTeam
 * @license The MIT License (MIT)
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Preorder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="preorder-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <?= $form->field($model, 'ip')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'cart_id')->textInput() ?>

    <?= $form->field($model, 'cookie_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total_count')->textInput() ?>

    <?= $form->field($model, 'total_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_ordered')->textInput() ?>

    <?= $form->field($model, 'coupon_item_id')->textInput() ?>

    <?= $form->field($model, 'coupon_item_total_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'origin_total_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'area_id')->textInput() ?>

    <?= $form->field($model, 'area_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'area_parent_id')->textInput() ?>

    <?= $form->field($model, 'area_path_ids')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'area_path_names')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'area_simple_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'area_zip_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address_fullname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address_telephone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address_detail')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address_id')->textInput() ?>

    <?= $form->field($model, 'pay_type')->textInput() ?>

    <?= $form->field($model, 'product_type')->textInput() ?>

    <?= $form->field($model, 'rough_pay_type')->textInput() ?>

    <?= $form->field($model, 'min_total_price_label')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'store_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
