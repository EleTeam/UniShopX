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

$isLocal = null;
$redisConfig = null;
if(strpos($_SERVER['HTTP_HOST'], 'local.') === 0){
    $isLocal = true;
    $redisConfig = [
        'class' => 'yii\redis\Connection',
        'hostname' => '127.0.0.1',
        'port' => 6379,
        'database' => 0,
    ];
}else{
    $redisConfig = [
        'class' => 'yii\redis\Connection',
        'hostname' => '120.24.54.172',
        'port' => 6379,
        'database' => 0,
    ];
}

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'redis' => $redisConfig,
        'cache' => [
            'class' => 'yii\redis\Cache',
        ],
        'session' => [
            'class' => 'yii\redis\Session',
        ],
    ],
];
