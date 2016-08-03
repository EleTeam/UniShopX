<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

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
            'address_detail',
            'address_fullname',
            'address_telephone',
            'area_id',
            'area_name',
            'area_parent_id',
            'area_path_ids',
            'area_path_names',
            'area_simple_name',
            'area_zip_code',
            'cart_id',
            'cookie_id',
            'ip',
            'preorder_id',
            'serial_no',
            'user_id',
            'total_price',
            'total_count',
            'print_count',
            'coupon_user_id',
            'coupon_user_total_price',
            'origin_total_price',
            'address_id',
            'has_paid',
            'pay_type',
            'notice',
            'rough_pay_type',
            'status_id',
            'op_transaction_id',
            'status_union',
            'min_total_price_label',
            'paid_date',
            'store_id',
        ],
    ]) ?>

</div>
