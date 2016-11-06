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

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            //'dsn' => 'mysql:host=127.0.0.1;dbname=etshop',
            'dsn' => 'mysql:host=192.168.1.102;dbname=etshop',
            'username' => 'root',
//            'dsn' => 'mysql:host=120.24.54.172;dbname=yii',
//            'username' => 'etshop',
            'password' => '123456',
            'charset' => 'utf8',
            //'tablePrefix' => 'pre_',
        ],
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
