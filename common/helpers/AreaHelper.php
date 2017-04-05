<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2017-04-05
 * @email 908601756@qq.com
 * @copyright Copyright © 2017年 EleTeam
 * @license The MIT License (MIT)
 */

namespace common\helpers;

use common\models\Area;
use Yii;

/**
 * 地址模型助手基类
 *  一般调用模型数据并缓存
 */
class AreaHelper extends BaseHelper
{
    const Cache_Key_Area_Tree = 'area_tree';

    /**
     * 获得树形结构的地区
     *
     * @return array
     */
    public static function getTree()
    {
        $areas = Yii::$app->cache->get(self::Cache_Key_Area_Tree);
        if(!$areas) {
            $areas = Area::findToTree();
            Yii::$app->cache->set(self::Cache_Key_Area_Tree, $areas);
        }
        return $areas;
    }
}
