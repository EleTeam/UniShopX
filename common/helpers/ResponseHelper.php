<?php
namespace common\helpers;

use common\consts\ResponseCode;
use Yii;
use yii\web\Response;

class ResponseHelper
{
    /**
     * 返回操作成功的响应对象，用在vue前端接口
     * @param array $data
     * @param string $msg
     * @return \yii\web\Response
     */
    public static function success($data = [], $msg = '操作成功')
    {
        return static::_return($data, $msg, ResponseCode::SUCCESS);
    }

    /**
     * 返回操作失败的响应对象，用在vue前端接口
     * @param array $data
     * @param string $msg
     * @param int $code
     * @return \yii\web\Response
     */
    public static function fail($data = [], $msg = '操作失败', $code = ResponseCode::FAIL)
    {
        return static::_return($data, $msg, $code);
    }

    private static function _return($data, $msg, $code)
    {
        $response = Yii::$app->response;
        $response->statusCode = 200; // http总是正常返回

        // 这种方式设置无效，必须在Controller::behaviors()上设置才有效
        // 允许vue前端的域名或ip跨域请求, 在http头加入如：Access-Control-Allow-Origin http://localhost:8081
//        $response->attachBehaviors([
//            'corsFilter' => [ // appmch允许规定的域名/ip跨域请求
//                'class' => \yii\filters\Cors::class,
//                'cors' => [
//                    'Origin' => Yii::$app->params['cors_origin'],
//                    'Access-Control-Request-Method' => ['GET', 'POST'],
//                    'Access-Control-Request-Headers' => ['*'],
//                ],
//            ]
//        ]);

        $response->format = Response::FORMAT_JSON;
        $response->data = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
        ];
        return $response;
    }
}