<?php
/**
 * ETShop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2015-08-04
 * @email 908601756@qq.com
 * @copyright Copyright © 2016年 EleTeam
 * @license The MIT License (MIT)
 */

namespace api\modules\v1\controllers;

use common\models\Address;
use common\models\Area;
use Yii;
use common\components\ETRestController;

/**
 * 地域控制器
 * Class AreaController
 * @package api\modules\v1\controllers
 */
class AreaController extends ETRestController
{
    public function actionFindPrefixAreaChainedAreas()
    {
        $prefixArea = Area::findOnePrefixArea();
        $chainedAreas = Area::findChainedAreas($prefixArea->id);
        $chainedAreasArr = [];
        foreach($chainedAreas as $areaChildren){
            $childrenArr = [];
            foreach($areaChildren['children'] as $child){
                $childrenArr[] = $child->toArray();
            }
            $item = [
                'area' => $areaChildren['area']->toArray(),
                'children' => $childrenArr,
            ];
            $chainedAreasArr[] = $item;
        }

        $data = [
            'prefixArea' => $prefixArea->toArray(),
            'chainedAreas' => $chainedAreasArr,
        ];

        return $this->jsonSuccess($data);
    }
}