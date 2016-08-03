<?php
/**
 * ETShop-for-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2015-06-22
 * @email 908601756@qq.com
 * @copyright Copyright © 2015年 EleTeam
 * @license The MIT License (MIT)
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Products');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Product'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

<?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => Yii::t('app', 'Small Image'),
                'format' => ['image',['width'=>'30','height'=>'30',]],
                'value' => function($dataProvider){
                    return $dataProvider->image_small;
                }

            ],
            'name',
            // 'sort',
            // 'created_at',
            // 'create_by',
            // 'updated_at',
            // 'update_by',
            // 'price',
            // 'featured_price',
            // 'featured_position',
            // 'featured_position_sort',
            // 'app_featured_home',
            // 'app_featured_home_sort',
            // 'app_featured_image',
            // 'short_description',
            // 'meta_keywords',
            // 'meta_description',
            // 'is_audit',
            // 'remarks',
            // 'featured',
            // 'description:ntext',
            // 'category_id',
            // 'image_medium',
            // 'image_large',
            // 'app_featured_topic',
            // 'app_featured_topic_sort',
            // 'app_long_image1',
            // 'app_long_image2',
            // 'app_long_image3',
            // 'type',
            // 'app_long_image4',
            // 'app_long_image5',
            // 'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>
