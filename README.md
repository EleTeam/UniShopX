# Shop-PHP-Yii2

#### 亲~您的一个小动作，会大大地鼓励EleTeam团队继续维护该项目，请 Watch、Star、Fork、Follow Me。

#### EleTeam开源项目-电商全套解决方案之iOS版-ETShop-for-PHP-Yii2。一个类似京东/天猫/淘宝的商城，有对应的APP支持，由EleTeam团队维护！
#### 客户端是iOS商城，对应项目是 ETShop-for-iOS，https://github.com/EleTeam/Shop-PHP-Yii2

#### 安装环境要求:
    php-5.6.x
    mysql-server-5.6.x
    httpd-2.x/nginx
    
#### 该项目分为4个小项目，Apache需要创建4个虚拟主机，存放该项目的所有代码，虚拟主机的配置如下：
    <VirtualHost *:80>
        ServerAdmin 908601756@qq.com
        DocumentRoot "/Users/tony/Desktop/Develop/PHP-WWW/Shop-PHP-Yii2/backend/web"
        ServerName local.eleteambackend.ygcr8.com
        ErrorLog "logs/local.eleteambackend.ygcr8.com-error_log"
        CustomLog "logs/local.eleteambackend.ygcr8.com-access_log" common
    </VirtualHost>
    <VirtualHost *:80>
        ServerAdmin 908601756@qq.com
        DocumentRoot "/Users/tony/Desktop/Develop/PHP-WWW/Shop-PHP-Yii2/frontend/web"
        ServerName local.eleteam.ygcr8.com
        ServerAlias local.eleteam.ygcr8.com
        ErrorLog "logs/local.eleteam.ygcr8.com-error_log"
        CustomLog "logs/local.eleteam.ygcr8.com-access_log" common
    </VirtualHost>
    <VirtualHost *:80>
        ServerAdmin 908601756@qq.com
        DocumentRoot "/Users/tony/Desktop/Develop/PHP-WWW/Shop-PHP-Yii2/data"
        ServerName local.eleteamdata.ygcr8.com
        ServerAlias local.eleteamdata.ygcr8.com
        ErrorLog "logs/local.eleteamdata.ygcr8.com-error_log"
        CustomLog "logs/local.eleteamdata.ygcr8.com-access_log" common
    </VirtualHost>
    <VirtualHost *:80>
        ServerAdmin 908601756@qq.com
        DocumentRoot "/Users/tony/Desktop/Develop/PHP-WWW/Shop-PHP-Yii2/api/web"
        ServerName local.eleteamapi.ygcr8.com
        ServerAlias local.eleteamapi.ygcr8.com
        ErrorLog "logs/local.eleteamapi.ygcr8.com-error_log"
        CustomLog "logs/local.eleteamapi.ygcr8.com-access_log" common
    </VirtualHost>

#### 配置本地的hosts文件:
    127.0.0.1       local.eleteam.ygcr8.com
    127.0.0.1       local.eleteambackend.ygcr8.com
    127.0.0.1       local.eleteamdata.ygcr8.com
    127.0.0.1       local.eleteamapi.ygcr8.com
    
#### 配置项目:
    以下文件夹要求读写权限:
        chmod -R 777 frontend/runtime backend/runtime api/runtime console/runtime
        chmod -R 777 frontend/web/assets backend/web/assets

#### 导入数据库文件:
    文件存放在: /dbbaks/etshop_?.sql, 项目在紧急开发中，所以该文件会不断更新，如果你的项目出现问题了，请重新导入最新的sql文件。

#### 线上的访问地址:
    前台: http://eleteam.ygcr8.com
    api: http://eleteamapi.ygcr8.com/v1/product/view?id=1
    数据: http://eleteamdata.ygcr8.com
    gii: http://local.eleteam.ygcr8.com/gii
    后台: http://eleteambackend.ygcr8.com
        后台超级用户: admin/123456
        后台普通用户: demo/123456

###### @author Tony Wong
###### @email 908601756@qq.com
###### @copyright Copyright © 2015年 EleTeam. All rights reserved.
###### @license The MIT License (MIT)

###### 此源码遵守 The MIT License (MIT)，可用于商业上，但是因此带来的商业损失EleTeam团队不承担责任。
