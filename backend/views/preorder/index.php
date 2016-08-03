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
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\PreorderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Preorders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="preorder-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p><?=Yii::t('app', 'Preorder Show Notice')?></p>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Preorder'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
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
            // 'ip',
            // 'user_id',
            // 'cart_id',
            // 'cookie_id',
            // 'total_count',
            // 'total_price',
            // 'is_ordered',
            // 'coupon_item_id',
            // 'coupon_item_total_price',
            // 'origin_total_price',
            // 'area_id',
            // 'area_name',
            // 'area_parent_id',
            // 'area_path_ids',
            // 'area_path_names',
            // 'area_simple_name',
            // 'area_zip_code',
            // 'address_fullname',
            // 'address_telephone',
            // 'address_detail',
            // 'address_id',
            // 'pay_type',
            // 'product_type',
            // 'rough_pay_type',
            // 'min_total_price_label',
            // 'store_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
