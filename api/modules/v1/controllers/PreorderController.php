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

namespace api\modules\v1\controllers;

use common\components\ETActiveRecord;
use common\components\ETRestController;
use common\models\Address;
use common\models\Cart;
use common\models\CartItem;
use common\models\Order;
use common\models\Preorder;
use common\models\PreorderItem;
use common\models\PreorderItemAttr;
use common\models\ProductAttrItem;
use Yii;
use common\models\Product;

/**
 * 预订单控制器
 * Class ProductController
 * @package api\modules\v1\controllers
 */
class PreorderController extends ETRestController
{
    public function actionView($id)
    {
        if(!$this->isLoggedIn()){
            return $this->jsonFail([], '您还没有登录');
        }

        $user_id = $this->getUserId();
        $preorder = Preorder::findOne(['id'=>$id, 'user_id'=>$user_id]);
        if(!$preorder){
            return $this->jsonFail([], "预购订单(ID:" + $id + ")不存在");
        }

        $addressArr = [];
        $address = Address::findDefault($user_id);
        if($address){
            $addressArr = $address->toArray();
            $addressArr['area'] = $address->area->toArray();
        }

        //前端提交后, 再次查看预订单所有这些数据可不返回
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

        return $this->jsonSuccess(['preorder'=>$preorderArr, 'address'=>$addressArr]);
    }

    /**
     * 通过购物车(is_selected字段)创建预备订单
     * @return string
     */
    public function actionAdd()
    {
        if(!$this->isLoggedIn()){
            return $this->jsonFail([], '您还没有登录');
        }

        $cartItems = CartItem::findByUserId($this->getUserId());
        if(!$cartItems){
            return $this->jsonFail([], '没有要购买的产品');
        }

        //创建预订单
        $preorder = new Preorder();
        $preorder->user_id = $this->getUserId();
        $preorder->is_ordered = Preorder::NO;
        //设置为用户最近用过的在线支付, @todo
        $preorder->pay_type = Order::PAY_TYPE_WX;
        $preorder->rough_pay_type = Order::payTypeToRough($preorder->pay_type);
        $preorder->total_price = 0;
        $preorder->total_count = 0;
        $preorder->origin_total_price = 0;
        if(!$preorder->save()){
            return $this->jsonFail([], '创建预订单失败');
        }

        //通过购物车创建预订单项
        foreach($cartItems as &$cartItem){
            //如果商品不存在, 要删除购物车项, @todo
//            if(!exist){
//                //
//            }
            $item = new PreorderItem();
            $product = $cartItem->product;
            $item->preorder_id = $preorder->id;
            $item->product_id = $product->id;
            $item->count = $cartItem->count;
            $item->image = ETActiveRecord::trimDataHost($product->image);
            $item->image_small = ETActiveRecord::trimDataHost($product->image_small);
            $item->featured_image = ETActiveRecord::trimDataHost($product->featured_image);
            $item->name = $product->name;
            $item->price = $product->turnToFinalPrice();
            $item->subtotal_price = $item->price * $item->count;
            $item->save();

            //添加购物车项的属性
            foreach($cartItem->cartItemAttrs as $cartItemAttr){
                $attr = new PreorderItemAttr();
                $attrItem = $cartItemAttr->attrItem;
                $attrItemValue = $cartItemAttr->attrItemValue;
                $attr->item_id = $item->id;
                $attr->attr_item_id = $attrItem->id;
                $attr->attr_item_name = $attrItem->name;
                $attr->attr_item_print_name = $attrItem->print_name;
                $attr->attr_item_sort = $attrItem->sort;
                $attr->attr_item_value_id = $attrItemValue->id;
                $attr->attr_item_value_name = $attrItemValue->name;
                $attr->attr_item_value_print_name = $attrItemValue->print_name;
                $attr->attr_item_value_sort = $attrItemValue->sort;
                $attr->attr_item_value_price = $attrItemValue->price;
                $attr->attr_item_value_is_standard = $attrItemValue->is_standard;
                $attr->save();
                //预订单项的价格 + 商品属性价格
                $item->price += $attrItemValue->price;
            }

            //重新保存预订单项的价格
            $item->subtotal_price = $item->price * $item->count;
            $item->save();

            //统计预订单价格和商品个数
            $preorder->total_count += $item->count;
            $preorder->total_price += $item->subtotal_price;
            $preorder->origin_total_price = $preorder->total_price;
        }

        //设置最少支付总额
        if($preorder->total_price < Order::MIN_TOTAL_PRICE){
            $preorder->total_price = Order::MIN_TOTAL_PRICE;
        }

        //重新保存预订单
        $preorder->save();

        //前端提交后, 再次查看预订单所有这些数据可不返回
        //preorder转为对应数组返回
//        $preorderArr = $preorder->toArray();
//        $itemsArr = [];
//        $items = $preorder->preorderItems;
//        foreach($items as $item){
//            $itemAttrsArr = [];
//            $itemAttrs = $item->preorderItemAttrs;
//            foreach($itemAttrs as $itemAttr){
//                $itemAttrsArr[] = $itemAttr->toArray();
//            }
//            $itemArr = $item->toArray();
//            $itemArr['preorderItemAttrs'] = $itemAttrsArr;
//            $itemsArr[] = $itemArr;
//        }
//        $preorderArr['preorderItems'] = $itemsArr;
//
//        return $this->jsonSuccess(['preorder'=>$preorderArr]);

        return $this->jsonSuccess(['preorder'=>$preorder]);
    }
}
