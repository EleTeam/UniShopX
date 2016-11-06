<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2016-09-30
 * @email 908601756@qq.com
 * @copyright Copyright © 2016年 EleTeam
 * @license The MIT License (MIT)
 */

namespace wap\controllers;

use common\components\ETWebController;
use common\models\ProductCategory;
use Yii;

/**
 * Site controller
 */
class SiteController extends ETWebController
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $categories = ProductCategory::find()
            ->where('status = :status and id != :id',
                [':status'=>ProductCategory::STATUS_ACTIVE, ':id'=>ProductCategory::ROOT_LEVEL_ID])
            ->with(['products'])
            ->all();

        return $this->render('index', [
            'categories' => $categories,
        ]);
    }
}
