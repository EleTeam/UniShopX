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

use common\models\Cart;
use Yii;
use yii\db\Exception as DbException;

/**
 * 购物车控制器
 *
 * Class CartController
 * @package wap\controllers
 */
class CartController extends BaseController
{
    /**
     * 购物车首页
     */
    public function actionIndex()
    {
//        $cartItemsArr = [];
//        $cart_num = 0;
//        $total_price = 0;
//        $app_cart_cookie_id = $this->getAppCartCookieId();
//
//        $cart = Cart::myCart($this->getUserId(), $app_cart_cookie_id);
//        if($cart) {
//            $items = Cart::findItems($cart->id);
//            foreach($items as $cartItem){
//                $cartItemsArr[] = $cartItem->toArray([], ['product']);
//            }
//            $total_price = Cart::sumTotalPriceByItems($items);
//            $cart_num = Cart::sumCartNumByItems($items);
//        }

//        $data = [
//            'cart' => $cart,
//            'couponItems' => null,
//            'cart_num' => $cart_num,
//            'total_price' => $total_price,
//            'is_logged_in' => $this->isLoggedIn(),
//            'app_cart_cookie_id' => $app_cart_cookie_id,
//        ];
        return $this->render('index', [
//            'cart' => $cart,
//            'total_price' => $total_price,

        ]);
    }

    /**
     * 添加产品到购物车，如果app_cart_cookie_id为空则生成唯一的它
     * attributes 的格式是 itemId_itemValueId, 如 1_2,2_10,3_15
     */
    public function actionAddItem()
    {
        $sku_id = $this->getParam('sku_id');
        $product_id = $this->getParam('product_id');
        $count = $this->getParam('count');
        $app_cart_cookie_id = $this->getAppCartCookieId();

        try {
            $cart = Cart::addItemBy($this->getUserId(), $app_cart_cookie_id, $product_id, $sku_id, $count);
            $cart_num = $cart->sumCartNum($cart->id);
        } catch (DbException $e) {
            return $this->jsonFail([], $e->getMessage());
        }

        $data = [
            'is_logged_in' => $this->isLoggedIn(),
            'app_cart_cookie_id' => $app_cart_cookie_id,
            'cart_num' => $cart_num,
        ];
        return $this->jsonSuccess($data);
    }

    /**
     * 格式化的属性和属性值转换为数组
     * @param $attributes 的格式是 itemId_itemValueId, 如 1_2,2_10,3_15
     * @return array 的格式 [$item_id=>$value_id, 1=>2, ...]
     * @todo 暂时没用的属性
     */
    protected function attributesToKeyValues($attributes)
    {
        if(empty($attributes))
            return [];

        $attrs = [];
        $attrStrs = explode(',', $attributes);
        foreach($attrStrs as $attrStr){
            $parts = explode('_', $attrStr);
            $attrs[$parts[0]] = $parts[1];
        }

        return $attrs;
    }
}