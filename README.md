# Shop-PHP-Yii2

#### 如果你支持这个项目，请 Star and Fork Me。

#### 注：有任何问题请在Issues提交，EleTeam会尽快回复。

#### EleTeam开源项目-电商全套解决方案之iOS版-Shop-PHP-Yii2。一个类似京东/天猫/淘宝的商城，有对应的APP支持，由EleTeam团队维护！
#### 客户端是iOS商城，对应项目是 ETShop-for-iOS，https://github.com/EleTeam/Shop-PHP-Yii2

#### 该电商网站的基础架构，能承担上万的并发请求：
    一份代码拆分为五个项目
    业务项目：GatewayWorker + Redis
    API项目：Nginx + PHP-FPM，PHP通过RPC调用业务项目提供的接口。该层同时是手机APP和手机WAP的接口
    WEB项目：Nginx + PHP-FPM，UI框架用 Framework7，PHP通过RPC调用业务项目提供的接口
    WAP项目：
        方案一：直接返回带数据的html和js。因为电商的SEO必须得做好，前后端分离无法优化SEO，而后端用nodejs调用接口把项目架构做复杂了，所以选用这种方案。
        方案二：Nginx只返回静态html页面，在浏览器端用AJAX调用API层的接口。JS框架是 SUI Mobile。不用这种方案。
    图片项目：Nginx存放图片等静态文件
    后台项目：Nginx + PHP-FPM，UI框架用 Framework7
    
#### 分布式部署
    Gearman处理一些可异步执行的任务（异步队列)，如发送短信等。
        Gearman是一个具有php扩展的分布式异步处理框架，能处理大批量异步任务。
        Gearman安装和使用：http://blog.csdn.net/e421083458/article/details/21283113
    定时任务：用Linux crontab调用php代码，在php里调用gearman用异步队列处理任务，如自动取消未付款订单
    
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
    <VirtualHost *:80>
        ServerAdmin 908601756@qq.com
        DocumentRoot "/Users/tony/Desktop/Develop/PHP-WWW/Shop-PHP-Yii2/wap/web"
        ServerName local.eleteamwap.ygcr8.com
        ServerAlias local.eleteamwap.ygcr8.com
        ErrorLog "logs/local.eleteamwap.ygcr8.com-error_log"
        CustomLog "logs/local.eleteamwap.ygcr8.com-access_log" common
    </VirtualHost>

#### 配置本地的hosts文件:
    127.0.0.1       local.eleteam.ygcr8.com
    127.0.0.1       local.eleteambackend.ygcr8.com
    127.0.0.1       local.eleteamdata.ygcr8.com
    127.0.0.1       local.eleteamapi.ygcr8.com
    127.0.0.1       local.eleteamwap.ygcr8.com
    
#### 配置项目:
    以下文件夹要求读写权限:
        chmod -R 777 frontend/runtime backend/runtime api/runtime console/runtime
        chmod -R 777 frontend/web/assets backend/web/assets
    数据库配置文件：
        common/config/main-local.php

#### 导入数据库文件:
    文件存放在: /dbbaks/etshop_?.sql, 项目在紧急开发中，所以该文件会不断更新，如果你的项目出现问题了，请重新导入最新的sql文件。

#### 数据库的设计与部署
    Mysql分区分片？多数据库。
    采用传统的读写分离方式，一主两从，主库只写，从库只读。
    不采用二主的方式，因为会把程序搞得太负责。
    参考文档：http://geek.csdn.net/news/detail/52070
    
#### 线上的访问地址:
    前台: http://eleteam.ygcr8.com
    wap: http://eleteamwap.ygcr8.com
    api: http://eleteamapi.ygcr8.com/v1/product/view?id=3
    数据: http://eleteamdata.ygcr8.com
    gii: http://eleteam.ygcr8.com/gii
    后台: http://eleteambackend.ygcr8.com
        后台超级用户: admin/123456
        后台普通用户: demo/123456

###### @author Tony Wong
###### @email 908601756@qq.com
###### @copyright Copyright © 2015年 EleTeam. All rights reserved.
###### @license The MIT License (MIT)

###### 此源码遵守 The MIT License (MIT)，可用于商业上，但是因此带来的商业损失EleTeam团队不承担责任。
