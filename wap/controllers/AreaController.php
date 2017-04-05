<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2017-04-06
 * @email 908601756@qq.com
 * @copyright Copyright © 2017年 EleTeam
 * @license The MIT License (MIT)
 */

namespace wap\controllers;

use common\helpers\AreaHelper;
use Yii;

/**
 * 地址控制器
 *
 * Class AddressController
 * @package wap\controllers
 */
class AreaController extends BaseController
{

    /**
     * 获得所有地址对象, json编码
     * @link http://local.m.eleteam.com/address/get-all-areas
     */
    public function actionGetAllAreas()
    {
        $areas = AreaHelper::getTree();
        //$areas = Area::findToTree();
        return $this->jsonSuccess(['areas'=>$areas]);
    }
}