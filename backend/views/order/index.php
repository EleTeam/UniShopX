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
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Orders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Order'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'created_at',
            'created_by',
            'status',
            'updated_at',
            // 'updated_by',
            // 'address_detail',
            // 'address_fullname',
            // 'address_telephone',
            // 'area_id',
            // 'area_name',
            // 'area_parent_id',
            // 'area_path_ids',
            // 'area_path_names',
            // 'area_simple_name',
            // 'area_zip_code',
            // 'cart_id',
            // 'cookie_id',
            // 'ip',
            // 'preorder_id',
            // 'serial_no',
            // 'user_id',
            // 'total_price',
            // 'total_count',
            // 'print_count',
            // 'coupon_item_id',
            // 'coupon_item_total_price',
            // 'origin_total_price',
            // 'address_id',
            // 'has_paid',
            // 'pay_type',
            // 'notice',
            // 'rough_pay_type',
            // 'status_id',
            // 'op_transaction_id',
            // 'status_union',
            // 'min_total_price_label',
            // 'paid_date',
            // 'store_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
