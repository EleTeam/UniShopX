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
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'redactor' => [
            'class' => 'yii\redactor\RedactorModule',
            'uploadDir' => '@data/uploads/public/editor',
            'uploadUrl' => '@imghost/uploads/public/editor',
            'imageAllowExtensions' => ['jpg','jpeg','png','gif','bmp'],
            //'widgetClientOptions' => ['plugins' => ['clips', 'fontcolor','imagemanager'], 'lang'=>'zh_cn'],
            'widgetClientOptions' => ['plugins' => ['fontcolor'], 'lang'=>'zh_cn'],
        ],

        //加载RBAC权限管理模块, http://local.eleteambackend.ygcr8.com/admin
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'left-menu',//yii2-admin的导航菜单
        ],
    ],
    'components' => [
        //用户登录配置, Yii::$app->user;
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'enableSession' => true,
            'loginUrl' => ['user/login'],
        ],
//        'admin' => [
//            'class' => 'yii\web\User',
//            'identityClass' => 'app\modules\credit\models\AdminUser',
//            'enableAutoLogin' => true,
//            'identityCookie' => ['name' => '__Manage_identity', 'httpOnly' => true],
//            'idParam' => '__Manage',
//            'loginUrl' => ['credit/public/login'],
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
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\PhpManager'
            'defaultRoles'=> ['guest'],
        ],
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            //'site/*',//允许访问的节点，可自行添加
            'admin/*',//允许所有人访问admin节点及其子节点
//                '*',
            'some-controller/some-action',
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ]
    ],
    'params' => $params,
];
