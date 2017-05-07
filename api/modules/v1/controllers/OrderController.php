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

namespace api\modules\v1\controllers;

use common\components\ETActiveRecord;
use common\components\ETRestController;
use common\models\Address;
use common\models\CartItem;
use common\models\Order;
use common\models\OrderItem;
use common\models\Preorder;
use common\models\PreorderItem;
use common\models\PreorderItemAttr;
use common\models\ProductAttrItem;
use Yii;
use common\models\Product;

/**
 * 订单控制器
 * Class OrderController
 * @package api\modules\v1\controllers
 */
class OrderController extends ETRestController
{
    /**
     * 查看订单列表
     */
    public function actionIndex()
    {
        if(!$this->isLoggedIn()){
            return $this->jsonFail([], '您还没有登录');
        }

        $user_id = $this->getUserId();
        $orders = Order::find()
            ->where('user_id=:user_id and status=:status', [':user_id'=>$user_id, ':status'=>Order::STATUS_ACTIVE])
            ->orderBy('id desc')
            ->limit(30)
            ->all();

        return $this->jsonSuccess(['orders'=>$orders]);
    }

    /**
     * 查看待付款订单列表
     */
    public function actionListPendingPay()
    {
        if(!$this->isLoggedIn()){
            return $this->jsonFail([], '您还没有登录');
        }

        $user_id = $this->getUserId();
        $orders = Order::find()
            ->where('user_id=:user_id and status=:status', [':user_id'=>$user_id, ':status'=>Order::STATUS_ACTIVE])
            ->orderBy('id desc')
            ->limit(30)
            ->all();

        return $this->jsonSuccess(['orders'=>$orders]);
    }

    /**
     * 查看待收货订单列表
     */
    public function actionListDelivering()
    {
        if(!$this->isLoggedIn()){
            return $this->jsonFail([], '您还没有登录');
        }

        $user_id = $this->getUserId();
        $orders = Order::find()
            ->where('user_id=:user_id and status=:status', [':user_id'=>$user_id, ':status'=>Order::STATUS_ACTIVE])
            ->orderBy('id desc')
            ->limit(30)
            ->all();

        return $this->jsonSuccess(['orders'=>$orders]);
    }

    /**
     * 查看交易完成订单列表
     */
    public function actionListFinished()
    {
        if(!$this->isLoggedIn()){
            return $this->jsonFail([], '您还没有登录');
        }

        $user_id = $this->getUserId();
        $orders = Order::find()
            ->where('user_id=:user_id and status=:status', [':user_id'=>$user_id, ':status'=>Order::STATUS_ACTIVE])
            ->orderBy('id desc')
            ->limit(30)
            ->all();

        return $this->jsonSuccess(['orders'=>$orders]);
    }

    public function actionView($id)
    {
        if(!$this->isLoggedIn()){
            return $this->jsonFail([], '您还没有登录');
        }

        $user_id = $this->getUserId();
    }

    /**
     * 将预备订单转化为订单
     */
    public function actionCreate()
    {
        if(!$this->isLoggedIn()){
            return $this->jsonFail([], '您还没有登录');
        }

        $preorder_id = $this->getParam('preorder_id');
        $address_id = $this->getParam('address_id');
        $notice = $this->getParam('notice');
        $user_id = $this->getUserId();

        if(empty($address_id)){
            return $this->jsonFail([], '请选择收货地址');
        }

        $address = Address::findOne(['id'=>$address_id, 'user_id'=>$user_id]);
        if(!$address){
            return $this->jsonFail(['address'=>$address], '收货地址不存在');
        }

        /**
         * Preorder
         */
        $preorder = Preorder::findOne(['id'=>$preorder_id, 'user_id'=>$user_id]);
        if(!$preorder){
            return $this->jsonFail(['preorder'=>$preorder], '预订单不存在');
        }

        if(empty($preorder->pay_type)){
            return $this->jsonFail([], '请选择支付方式');
        }

        //保存订单
        $order = new Order();
        $orderData = $preorder->toArray();
        unset($orderData['id']);
        if(!($order->load($orderData, '') && $order->save())){
            return $this->jsonFail(['orderData'=>$orderData], '保存订单失败');
        }

        //保存订单项
        $item = new OrderItem();
//        foreach($preorder->item)

        return $this->jsonSuccess($order);
    }
}
