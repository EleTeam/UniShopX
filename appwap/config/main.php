<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-appwap',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'appwap\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-appwap',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableSession' => false,
            'enableAutoLogin' => false,
//            'identityCookie' => ['name' => '_identity-appwap', 'httpOnly' => true],
        ],
//        'session' => [
//            // this is the name of the session cookie used for login on the appwap
//            'name' => 'advanced-appwap',
//        ],
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
    'params' => $params,
];
