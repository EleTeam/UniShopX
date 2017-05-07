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
$dbConfig = null;
if(strpos($_SERVER['HTTP_HOST'], 'local.') === 0){
    $isLocal = true;
    if(strpos($_SERVER['HTTP_USER_AGENT'], '(Macintosh;') !== false) {
        $dbConfig = [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=etshop', //用本地Mac电脑的数据库
            'username' => 'root',
            'password' => '123456',
            'charset' => 'utf8',
        ];
    }else{
        $dbConfig = [
            'class' => 'yii\db\Connection',
            //'dsn' => 'mysql:host=192.168.1.111;dbname=etshop', //用内网Mac电脑的数据库
            'dsn' => 'mysql:host=localhost;dbname=etshop', //用本机电脑的数据库
            'username' => 'root',
            'password' => '123456',
            'charset' => 'utf8',
        ];
    }
}else{
    $dbConfig = [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=127.0.0.1;dbname=etshop',
        //'dsn' => 'mysql:host=120.24.54.172;dbname=etshop',
        'username' => 'etshop',
        'password' => '123456',
        'charset' => 'utf8',
    ];
}

return [
    'components' => [
        'db' => $dbConfig,
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];
