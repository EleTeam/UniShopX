<?php
/**
 * ETShop-for-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2016-08-02
 * @email 908601756@qq.com
 * @copyright Copyright © 2016年 EleTeam
 * @license The MIT License (MIT)
 */

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Preorder */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Preorders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="preorder-view">

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
            'created_at',
            'created_by',
            'status',
            'updated_at',
            'updated_by',
            'ip',
            'user_id',
            'cart_id',
            'cookie_id',
            'total_count',
            'total_price',
            'is_ordered',
            'coupon_user_id',
            'coupon_user_total_price',
            'origin_total_price',
            'area_id',
            'area_name',
            'area_parent_id',
            'area_path_ids',
            'area_path_names',
            'area_simple_name',
            'area_zip_code',
            'address_fullname',
            'address_telephone',
            'address_detail',
            'address_id',
            'pay_type',
            'product_type',
            'rough_pay_type',
            'min_total_price_label',
            'store_id',
        ],
    ]) ?>

</div>
