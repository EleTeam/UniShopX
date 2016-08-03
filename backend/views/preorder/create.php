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


/* @var $this yii\web\View */
/* @var $model common\models\Preorder */

$this->title = Yii::t('app', 'Create Preorder');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Preorders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="preorder-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
