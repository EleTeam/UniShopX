<?php
/**
 * ETShop-PHP-Yii2
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
/* @var $this yii\web\View */
/* @var $searchModel common\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Category'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'featured',
            [
                'attribute' => Yii::t('app', 'Small Image'),
                'format' => ['image',['width'=>'30','height'=>'30',]],
                'value' => function($dataProvider){
                    return Yii::getAlias('@dataHost') . $dataProvider->image_small;
                }

            ],
            // 'name',
            // 'parent_id',
            // 'sort',
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',
            // 'short_description',
            // 'app_featured_home',
            // 'app_featured_home_sort',
            // 'parent_ids',
            // 'remarks',
            // 'meta_keywords',
            // 'meta_description',
            // 'href',
            // 'href_target',
            // 'image_medium',
            // 'image_large',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
