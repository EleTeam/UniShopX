<?php
namespace appback\controllers;

use appback\helpers\AccessControl;
use Yii;
use yii\web\Controller;

/**
 * Base controller
 */
class BaseController extends Controller
{
    public function behaviors()
    {
        return [
            // 允许vue前端的域名或ip跨域请求, 在http头加入如：Access-Control-Allow-Origin http://localhost:8081
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
                'cors' => [
                    'Origin' => Yii::$app->params['cors_origin'],
                    'Access-Control-Request-Method' => ['GET', 'POST'],
                    'Access-Control-Request-Headers' => ['*'],
                ],
            ],
            // 访问控制
            'access' => [
                'class' => AccessControl::class,
                'allowActions' => ['site/login', 'site/error',] //不需要控制的action
            ]
        ];
    }

    /**
     * 获取当前后台用户id, User.id
     * @return string
     */
    public function getUserId()
    {
        return Yii::$app->user->id;
    }
}
