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
use yii\web\JsExpression;
use xj\uploadify\Uploadify;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-8\">{input} {error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <div class="form-group field-product-image">
        <label for="product-image" class="col-lg-2 control-label"><?=Yii::t('app', 'Image')?></label>
        <div class="col-lg-8">
            <input type="hidden" value="<?=$model->image?>" name="Product[image]" class="form-control" id="product-image">
            <img id="show-product-image" src="<?=$model->image?>" class="" width="80" height="80" style="margin-right:10px;"/>
            <?php
            echo Html::fileInput('image', $model->image, ['id' => 'image']);
            echo Uploadify::widget([
                'url' => yii\helpers\Url::to(['s-upload']),
                'id' => 'image',
                'csrf' => true,
                'renderTag' => false,
                'jsOptions' => [
                    'width' => 100,
                    'height' => 30,
                    'onUploadError' => new JsExpression(<<<EOF
function(file, errorCode, errorMsg, errorString) {
    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
}
EOF
                    ),
                    'onUploadSuccess' => new JsExpression(<<<EOF
function(file, data, response) {
    data = JSON.parse(data);
    if (data.error) {
        console.log(data.msg);
    } else {
        $('#show-product-image').attr('src', data.fileUrl);
        $('#product-image').val(data.filePath);
        //console.log(data.fileUrl);
    }
}
EOF
                    ),
                ]
            ]);
            ?>
            <div class="help-block"></div>
        </div>
    </div>

    <div class="form-group field-product-image_small">
        <label for="product-image_small" class="col-lg-2 control-label"><?=Yii::t('app', 'Small Image')?></label>
        <div class="col-lg-8">
            <img id="show-product-image_small" src="<?=$model->image_small?>" class="" width="80" height="80" style="margin-right:10px;"/>
            <?php
            echo Html::fileInput('image_small', $model->image, ['id' => 'image_small']);
            echo Uploadify::widget([
                'url' => yii\helpers\Url::to(['s-upload']),
                'id' => 'image_small',
                'csrf' => true,
                'renderTag' => false,
                'jsOptions' => [
                    'width' => 100,
                    'height' => 30,
                    'onUploadError' => new JsExpression(<<<EOF
function(file, errorCode, errorMsg, errorString) {
    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
}
EOF
                    ),
                    'onUploadSuccess' => new JsExpression(<<<EOF
function(file, data, response) {
    data = JSON.parse(data);
    if (data.error) {
        console.log(data.msg);
    } else {
        console.log(data.fileUrl);
    }
}
EOF
                    ),
                ]
            ]);
            ?>
            <div class="help-block"></div>
        </div>
    </div>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'featured_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'featured_position')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'featured_position_sort')->textInput() ?>

    <?= $form->field($model, 'app_featured_home')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'app_featured_home_sort')->textInput() ?>

    <?= $form->field($model, 'app_featured_image')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'short_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_audit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'remarks')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'featured')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <?= $form->field($model, 'category_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image_medium')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image_large')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'app_featured_topic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'app_featured_topic_sort')->textInput() ?>

    <?= $form->field($model, 'app_long_image1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'app_long_image2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'app_long_image3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'app_long_image4')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'app_long_image5')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
