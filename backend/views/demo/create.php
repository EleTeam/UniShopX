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


/* @var $this yii\web\View */
/* @var $model common\models\Demo */

$this->title = Yii::t('app', 'Create Demo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Demos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="demo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
