<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2015-06-10
 * @email 908601756@qq.com
 * @copyright Copyright © 2015年 EleTeam
 * @license The MIT License (MIT)
 */

namespace api\modules\v1\controllers;

use common\models\ProductCategory;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;

class DemoController extends ActiveController
{
    public $modelClass = 'common\models\ProductCategory';

    public function actions()
    {
        $actions = parent::actions();

        // 禁用"delete" 和 "create" 操作
        unset($actions['delete'], $actions['create'], $actions['update']);

        // 使用"prepareDataProvider()"方法自定义数据provider
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProviderForIndex'];

        return $actions;
    }

    // 为"index"操作准备和返回数据provider
    public function prepareDataProviderForIndex()
    {
        $query = ProductCategory::findFirstLevels('id, name');
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        return $dataProvider;
    }
}