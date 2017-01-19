<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2017-01-16
 * @email 908601756@qq.com
 * @copyright Copyright © 2017年 EleTeam
 * @license The MIT License (MIT)
 */

namespace wap\controllers;

use common\models\Cart;
use common\models\Address;
use Yii;
use yii\db\Exception as DbException;

/**
 * 订单确认页控制器
 *
 * Class PreorderController
 * @package wap\controllers
 */
class PreorderController extends BaseController
{
    /**
     * 订单确认页
     *
     */
    public function actionIndex()
    {
        $cart_num = 0;
        $total_price = 0;
        $app_cart_cookie_id = $this->getAppCartCookieId();

        $cart = Cart::myCart($this->getUserId(), $app_cart_cookie_id);
        if($cart) {
            $total_price = Cart::sumTotalPriceByItems($cart->cartItems);
            $cart_num = Cart::sumCartNumByItems($cart->cartItems);
        }

        $address = Address::findDefault($this->getUserId());

        return $this->render('index', [
            'cart' => $cart,
            'total_price' => $total_price,
            'cart_num' => $cart_num,
            'address' => $address,
        ]);
    }
}