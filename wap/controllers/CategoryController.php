<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2016-11-10
 * @email 908601756@qq.com
 * @copyright Copyright © 2016 EleTeam
 * @license The MIT License (MIT)
 */

namespace wap\controllers;

use common\models\ProductCategory;
use Yii;

/**
 * 广告控制器
 *
 * Class BannerController
 * @package wap\controllers
 */
class CategoryController extends BaseController
{
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