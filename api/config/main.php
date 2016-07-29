<?php
/**
 * ETShop-for-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2015-06-10
 * @email 908601756@qq.com
 * @copyright Copyright © 2015年 EleTeam
 * @license The MIT License (MIT)
 */

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => ['class' => 'api\modules\v1\Module'],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false, // for api
            'enableSession' => false, // for api
            'loginUrl' => null, // for api
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            //'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
//            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
//                [
//                    'class' => 'yii\rest\UrlRule',
//                    'controller' => ['v1/user', 'v1/category', 'v1/product'],
//                ],
//                'OPTIONS v1/auth/login' => 'v1/auth/login',
//                'POST v1/auth/login'    => 'v1/auth/login',
//                'OPTIONS v1/auth/logout' => 'v1/auth/logout',
//                'POST v1/auth/logout'    => 'v1/auth/logout',
            ],
        ],
    ],
    'params' => $params,
];
