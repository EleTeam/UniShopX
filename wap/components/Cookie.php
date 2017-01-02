<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2016-01-02
 * @email 908601756@qq.com
 * @copyright Copyright © 2016年 EleTeam
 * @license The MIT License (MIT)
 */

namespace wap\components;

use Yii;
use yii\base\Component;

/**
 * Cookie类管理Wap项目定义的cookie
 */
class Cookie extends Component
{
    /**
     * 临时购物车的cookie, 用于非登录用户保存购物车信息
     */
    const APP_CART_COOKIE_ID = 'app_cart_cookie_id';

    /**
     * 获取客户端的app_cart_cookie_id
     */
    public static function getAppCartCookieId()
    {
        $cookies = Yii::$app->request->cookies;
        return $cookies->getValue(self::APP_CART_COOKIE_ID);
    }

    /**
     * 设置客户端的app_cart_cookie_id
     *
     * @param $value
     */
    public static function setAppCartCookieId($value)
    {
        $cookie = new \yii\web\Cookie([
            'name' => self::APP_CART_COOKIE_ID,
            'value' => $value,
            'expire' => time() + 365 * 24 * 3600, //保存一年
        ]);
        $cookies = Yii::$app->response->cookies;
        $cookies->add($cookie);
    }
}
