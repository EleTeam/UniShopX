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

use common\models\Order;
use common\models\CartItem;
use common\models\Address;
use common\models\OrderItem;
use common\components\ETActiveRecord;
use Yii;

/**
 * 订单确控制器
 *
 * Class OrderController
 * @package wap\controllers
 */
class OrderController extends BaseController
{
    /**
     * 订单提交, 通过购物车(is_selected字段)创建订单
     * @return string
     */
    public function actionCreate()
    {
        if(!$this->isLoggedIn()){
            return $this->jsonFail([], '您还没有登录');
        }

        $address_id = Yii::$app->request->post('address_id');
        $notice = Yii::$app->request->post('notice');
        $pay_type = Yii::$app->request->post('pay_type');
        $user_id = $this->getUserId();

        if(empty($address_id)){
            return $this->jsonFail([], '请选择收货地址');
        }

        $address = Address::findOne(['id'=>$address_id, 'user_id'=>$user_id]);
        if(!$address){
            return $this->jsonFail(['address'=>$address], '收货地址不存在');
        }

        $area = $address->area;
        if(!$area){
            return $this->jsonFail(['address'=>$address], '地区不存在, 请选择其它收货地址');
        }

//        if(!$pay_type){
//            return $this->jsonFail([], '请选择支付方式');
//        }

        $cartItems = CartItem::findByUserId($this->getUserId());
        if(!$cartItems){
            return $this->jsonFail([], '没有要购买的产品');
        }

        //@todo 注意用事务处理

        //通过购物车创建订单
        /* @var $cartItem CartItem */
        $total_count = 0;
        $total_price = 0;
        foreach($cartItems as &$cartItem){
            //如果商品不存在, 要删除购物车项, @todo
//            if(!exist){
//                //
//            }
            $productSku = $cartItem->productSku;
            $product = $cartItem->product;
            $item = new OrderItem();
            $item->product_id = $product->id;
            $item->count = $cartItem->count;
            $item->image = ETActiveRecord::trimDataHost($product->image);
            $item->image_small = ETActiveRecord::trimDataHost($product->image_small);
            $item->featured_image = ETActiveRecord::trimDataHost($product->featured_image);
            $item->name = $product->name;
            $item->price = $product->turnToFinalPrice();
            $item->subtotal_price = $item->price * $item->count;
            if($productSku){
                $item->sku_id = $productSku->id;
                $item->spec_ids = $productSku->spec_ids;
                $item->spec_value_ids = $productSku->spec_value_ids;
                $item->code = $productSku->code;
                $item->type_id = $product->type_id;
                $item->sku_price = $productSku->price;
            }
            $item->subtotal_price = $item->price * $item->count;
            $item->save();

            //添加购物车项的属性
//            foreach($cartItem->cartItemAttrs as $cartItemAttr){
//                $attr = new PreorderItemAttr();
//                $attrItem = $cartItemAttr->attrItem;
//                $attrItemValue = $cartItemAttr->attrItemValue;
//                $attr->item_id = $item->id;
//                $attr->attr_item_id = $attrItem->id;
//                $attr->attr_item_name = $attrItem->name;
//                $attr->attr_item_print_name = $attrItem->print_name;
//                $attr->attr_item_sort = $attrItem->sort;
//                $attr->attr_item_value_id = $attrItemValue->id;
//                $attr->attr_item_value_name = $attrItemValue->name;
//                $attr->attr_item_value_print_name = $attrItemValue->print_name;
//                $attr->attr_item_value_sort = $attrItemValue->sort;
//                $attr->attr_item_value_price = $attrItemValue->price;
//                $attr->attr_item_value_is_standard = $attrItemValue->is_standard;
//                $attr->save();
//                //预订单项的价格 + 商品属性价格
//                $item->price += $attrItemValue->price;
//            }
//
//            //重新保存预订单项的价格
//            $item->subtotal_price = $item->price * $item->count;
//            $item->save();

            //统计订单价格和商品个数
            $total_count += $item->count;
            $total_price += $item->subtotal_price;

            //标志该购物车项
            $cartItem->is_ordered = CartItem::YES;
            $cartItem->save();
        }

        //创建预订单
        $order = new Order();
        $order->user_id = $user_id;
        $order->pay_type = $pay_type;
        $order->rough_pay_type = Order::payTypeToRough($pay_type);
        $order->total_price = $total_price;
        $order->total_count = $total_count;
        $order->origin_total_price = $total_price; //@todo 注意减去优惠(如代金券, 积分抵扣, 节日立减等)的价格
        $order->notice = $notice;
        $order->address_id = $address->id;
        $order->address_detail = $address->detail;
        $order->address_fullname = $address->fullname;
        $order->address_telephone = $address->telephone;
        $order->area_id = $area->id;
        $order->area_parent_id = $area->parent_id;
        $order->area_name = $area->name;
        $order->area_simple_name = $area->simple_name;
        $order->area_path_ids = $area->path_ids;
        $order->area_path_names = $area->path_names;
        $order->area_zip_code = $area->zip_code;
        $order->status = Order::YES;
        $order->is_paid = Order::NO;
        $order->serial_no = $order->genSerialNum();
        //设置最少支付总额
        if($order->total_price < Order::MIN_TOTAL_PRICE){
            $order->total_price = Order::MIN_TOTAL_PRICE;
        }
        if(!$order->save()){
            return $this->jsonFail([], '创建订单失败:'.$order->errorsToString());
        }

        return $this->jsonSuccess(['order'=>$order]);
    }

    /**
     * 订单提交成功后的页面
     */
    public function actionSuccess()
    {
        $order_id = Yii::$app->request->get('order_id');
        $order = Order::findOne(['id'=>$order_id, 'user_id'=>$this->getUserId()]);
        return $this->render('success', [
            'order' => $order,
        ]);
    }
}