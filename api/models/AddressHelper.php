<?php
/**
 * ETShop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2016-08-08
 * @email 908601756@qq.com
 * @copyright Copyright © 2016年 EleTeam
 * @license The MIT License (MIT)
 */

namespace api\models;

use common\models\Address;

class AddressHelper extends Address
{
    /**
     * 获取用户的默认地址
     * @param $user_id
     * @return array
     */
    public static function findDefaultArr($user_id)
    {
        $addressArr = [];
        $address = Address::findDefault($user_id);
        if($address){
            $addressArr = $address->toArray();
            $addressArr['area'] = $address->area->toArray();
            $addressArr['area']['path_names_4print'] = $address->area->getPathNames4Print();
        }
        return $addressArr;
    }
}