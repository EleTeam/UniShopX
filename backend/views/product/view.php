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
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'image',
            'featured_image',
            'image_small',
            'name',
            'sort',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
            'price',
            'featured_price',
            'featured_position',
            'featured_position_sort',
            'app_featured_home',
            'app_featured_home_sort',
            'app_featured_image',
            'short_description',
            'meta_keywords',
            'meta_description',
            'is_audit',
            'remarks',
            'featured',
            'description:ntext',
            'category_id',
            'image_medium',
            'image_large',
            'app_featured_topic',
            'app_featured_topic_sort',
            'app_long_image1',
            'app_long_image2',
            'app_long_image3',
            'type_id',
            'app_long_image4',
            'app_long_image5',
            'status',
        ],
    ]) ?>

</div>
