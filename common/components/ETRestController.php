<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2015-05-18
 * @email 908601756@qq.com
 * @copyright Copyright © 2015年 EleTeam
 * @license The MIT License (MIT)
 */

namespace common\components;

use common\models\Cart;
use common\models\User;
use Yii;
use yii\rest\Controller;
use yii\web\Response;

class ETRestController extends Controller
{
    /**
     * api返回的json
     * @param $status
     * @param $code
     * @param $message
     * @param $data
     * @param array $share
     * @return string
     * @apiVersion 1.0
     */
    private function jsonEncode($status, $data=[], $message='', $code=1, $share=[])
    {
        $status     = boolval($status);
        $data       = $data ? $data : (object)array();
        $message    = strval($message);
        $code       = intval($code);
        $share      = $share ? $share : (object)array();

        $result = [
            'status'     => $status,
            'code' => $code,
            'message'    => $message,
            'data'       => $data,
            'share'      => $share,
        ];

        //设置响应对象
        $response = Yii::$app->response;
        $response->format = Response::FORMAT_JSON;
        $response->data = $result;
    }

    protected function jsonSuccess($data=[], $message='', $code=1, $share=array())
    {
        $message = $message ? $message : '调用成功';
        $this->jsonEncode(true, $data, $message, $code, $share);
    }

    protected function jsonFail($data=array(), $message='', $code=0, $share=array())
    {
        $message = $message ? $message : '调用失败';
        $this->jsonEncode(false, $data, $message, $code, $share);
    }

    protected function isLoggedIn()
    {
        $user = User::findIdentityByAccessToken(@$_REQUEST['access_token']);
        return !!$user;
    }

    protected function getUserId()
    {
        $user = User::findIdentityByAccessToken(@$_REQUEST['access_token']);
        return $user ? $user->id : null;
    }

    protected function getUser()
    {
        return User::findIdentityByAccessToken(@$_REQUEST['access_token']);
    }

    protected function getAppCartCookieId()
    {
        return $this->getParam('app_cart_cookie_id') ? $this->getParam('app_cart_cookie_id') : Cart::genAppCartCookieId();
    }

    /**
     * 获取 $_REQUEST[$name], 包含get,post方式传过来的值
     * @param $name
     * @param null $defaultValue
     * @return mixed
     */
    protected function getParam($name, $defaultValue=null)
    {
        return isset($_REQUEST[$name]) ? $_REQUEST[$name] : $defaultValue;
    }
}