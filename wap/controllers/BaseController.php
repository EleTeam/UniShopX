<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2016-11-10
 * @email 908601756@qq.com
 * @copyright Copyright © 2016年 EleTeam
 * @license The MIT License (MIT)
 */

namespace wap\controllers;

use common\models\User;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use common\models\Cart;

/**
 * Wap项目的根控制器
 *
 * Class BaseController
 * @package wap\controllers
 */
class BaseController extends Controller
{
    public $layout = false;

    public function init()
    {
        parent::init();
        $this->setLanguage();
    }

    /**
     * Set the language displayed on the current site
     */
    public function setLanguage()
    {
        if(isset($_GET['lang']) && $_GET['lang'] != "") {
            // By passing a parameter to change the language
            Yii::$app->language = htmlspecialchars($_GET['lang']);

            // get the cookie collection (yii\web\CookieCollection) from the "response" component
            $cookies = Yii::$app->response->cookies;
            // add a new cookie to the response to be sent
            $cookies->add(new \yii\web\Cookie([
                'name' => 'lang',
                'value' => htmlspecialchars($_GET['lang']),
                'expire' => time() + (365 * 24 * 60 * 60),
            ]));
        }
        elseif (isset(Yii::$app->request->cookies['lang']) &&
            Yii::$app->request->cookies['lang']->value != "") {
            // COOKIE in accordance with the language type to set the language
            Yii::$app->language = Yii::$app->request->cookies['lang']->value;
        }
//        elseif (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
//            // According to the browser language to set the language
//            $lang = explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
//            Yii::$app->language = $lang[0];
//        }
        else {
            Yii::$app->language = 'zh-CN';
        }
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

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
    protected function jsonEncode($status, $data=[], $message='', $code=1, $share=[])
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

    protected function getAppCartCookieId()
    {
        return $this->getParam('app_cart_cookie_id') ? $this->getParam('app_cart_cookie_id') : Cart::genAppCartCookieId();
    }

    protected function getUser()
    {
        if(Yii::$app->user->isGuest){
            return null;
        }else{
            return User::findOne(Yii::$app->user->id);
        }
    }
}
