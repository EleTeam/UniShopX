<?php
/**
 * ETShop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2015-08-30
 * @email 908601756@qq.com
 * @copyright Copyright © 2016年 EleTeam
 * @license The MIT License (MIT)
 */

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\CmsArticle */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cms Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-article-view">

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
            'category_id',
            'title',
            'link',
            'color',
            'image',
            'keywords',
            'description',
            'weight',
            'weight_date',
            'hits',
            'posid',
            'custom_content_view',
            'view_config:ntext',
            'created_by',
            'created_at',
            'updated_by',
            'updated_at',
            'remarks',
            'status',
        ],
    ]) ?>

</div>
