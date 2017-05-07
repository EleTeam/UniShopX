<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2016-08-08
 * @email 908601756@qq.com
 * @copyright Copyright © 2016年 EleTeam
 * @license The MIT License (MIT)
 */

namespace api\models;

use common\models\Preorder;

class PreorderHelper extends Preorder
{
    /**
     * 获取用户的订单
     * @param $id
     * @param $user_id
     * @return null|Preorder
     * @throws \yii\db\Exception
     */
    public static function findPreorderArr($id, $user_id)
    {
        $preorder = Preorder::findOne(['id'=>$id, 'user_id'=>$user_id]);
        if(!$preorder){
            throw new \yii\db\Exception("预购订单(ID:$id)不存在");
        }

        //preorder转为对应数组返回
        $preorderArr = $preorder->toArray();
        $itemsArr = [];
        $items = $preorder->preorderItems;
        foreach($items as $item){
            $itemAttrsArr = [];
            $itemAttrs = $item->preorderItemAttrs;
            foreach($itemAttrs as $itemAttr){
                $itemAttrsArr[] = $itemAttr->toArray();
            }
            $itemArr = $item->toArray();
            $itemArr['preorderItemAttrs'] = $itemAttrsArr;
            $itemsArr[] = $itemArr;
        }
        $preorderArr['preorderItems'] = $itemsArr;

        return $preorderArr;
    }
}