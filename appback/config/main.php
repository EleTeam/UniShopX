<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-appback',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'appback\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-appback',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableSession' => false,
            'enableAutoLogin' => false,
//            'identityCookie' => ['name' => '_identity-appback', 'httpOnly' => true],
        ],
//        'session' => [
//            // this is the name of the session cookie used for login on the appback
//            'name' => 'advanced-appback',
//        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            // uncomment if you want to cache RBAC items hierarchy
            // 'cache' => 'cache',
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
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    // 不要用这种方式，因为AccessControl::beforeAction()无法设置跨域，必须在Controller::behaviors()上设置才有效
    /*
    'as access' => [ // 授权控制
        'class' => 'appback\helpers\AccessControl',
        'allowActions' => ['site/login', 'site/error',] //不需要控制的action
    ],
    */
    'params' => $params,
];
