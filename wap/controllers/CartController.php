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
        $cartItemsArr = [];
        $cart_num = 0;
        $total_price = 0;
        $app_cart_cookie_id = $this->getAppCartCookieId();

        $cart = Cart::myCart($this->getUserId(), $app_cart_cookie_id);
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
            'cart' => $cart,
            'total_price' => $total_price,

        ]);
    }
}