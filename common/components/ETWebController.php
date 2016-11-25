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

use Yii;
use yii\web\Controller;

class ETWebController extends Controller
{
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
}
