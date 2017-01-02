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
        $cart_num = 0;
        $total_price = 0;
        $app_cart_cookie_id = $this->getAppCartCookieId();

        $cart = Cart::myCart($this->getUserId(), $app_cart_cookie_id);
        if($cart) {
            $total_price = Cart::sumTotalPriceByItems($cart->cartItems);
            $cart_num = Cart::sumCartNumByItems($cart->cartItems);
        }

        return $this->render('index', [
            'cart' => $cart,
            'total_price' => $total_price,
            'cart_num' => $cart_num,
            'is_logged_in' => $this->isLoggedIn(),
        ]);
    }

    /**
     * 添加产品到购物车，如果app_cart_cookie_id为空则生成唯一的它
     * attributes 的格式是 itemId_itemValueId, 如 1_2,2_10,3_15
     */
    public function actionAddItem()
    {
        $sku_id = Yii::$app->request->post('sku_id');
        $product_id = Yii::$app->request->post('product_id');
        $count = Yii::$app->request->post('count');
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