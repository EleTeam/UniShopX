### 重构项目，前后端分离，前端采用用Vue
    Vue项目地址为：https://github.com/EleTeam/Shop-Vue



### ==================== 以下项目移到分支 old-etshop ====================

# Shop-PHP-Yii2

#### 如果你支持这个项目，请 Star and Fork Me。

#### 注：有任何问题请在Issues提交，EleTeam会尽快回复。

#### EleTeam开源项目-电商全套解决方案之后端版-Shop-PHP-Yii2。一个类似京东/天猫/淘宝的商城，有对应的APP支持，由EleTeam团队维护！
#### iOS手机端，对应项目是 Shop-iOS，https://github.com/EleTeam/Shop-iOS
#### RN手机端，对应项目是 Shop-React-Native，https://github.com/EleTeam/Shop-React-Native

#### 网站的功能模块
    商品模块：支持一个商品多SKU模式
    用户模块：注册登录，用户角色权限管理
    地址模块
    订单模块
    购物车模块
    文章模块

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

#### Redis 安装与使用, 必须安装
    Linux下安装Redis：
        用源码包安装，yii2-redis需要redis>=2.6.12的版本
        1.cd /usr/local/src;  wget download.redis.io/releases/redis-3.2.6.tar.gz
        2.tar xvf redis-3.2.6.tar.gz;  cd redis-3.2.6
        3.make && make install
        4.cp redis.conf /usr/local/etc
        5.redis-server /usr/local/etc/redis.conf &
        用命令行安装
        1.安装redis： yum install redis
        2.安装php-redis扩展： yum install php-redis
        3.启动redis，并设定开机自动启动： service redis start
        4.开机自动启动redis： chkconfig redis on
        5.查看进程： ps aux|grep redis
        6.查看端口： netstat -apn | grep redis
        7.命令测试： redis-cli， set key "123", get key
        8.查看redis版本：redis-server -v, 如果版本redis<2.6.12, 请用用源码包安装
    让外网可以访问Redis：
        1.打开redis端口：iptables -I INPUT -p tcp --dport 6379 -j ACCEPT && service iptables save && service iptables restart
        2.修改redis的配置文件，将所有bind信息全部屏蔽。
          vi /etc/redis.conf 或者 vi /usr/local/etc/redis.conf
              # bind 127.0.0.1
              protected-mode no
        3.重启redis
        4.安装redis图形界面客户端Redis Desktop Manager
        5.用该客户端可以清晰看到redis数据
    
#### 搜索服务
    ElasticSearch分布式多用户的全文搜索引擎，是当前流行的企业级搜索引擎。
    
#### 分布式部署
    Gearman处理一些可异步执行的任务（异步队列)，如发送短信等。
        Gearman是一个具有php扩展的分布式异步处理框架，能处理大批量异步任务。
        Gearman安装和使用：http://blog.csdn.net/e421083458/article/details/21283113
    定时任务：用Linux crontab调用php代码，在php里调用gearman用异步队列处理任务，如自动取消未付款订单
    
#### 安装环境要求:
    php-5.6.x
    mysql-server-5.6.x, 否则导入sql文件语法出错
    httpd-2.x/nginx, 需要打开重写规则AllowOverride All

#### rpm安装MySQL-5.6.35
     wget https://dev.mysql.com/get/Downloads/MySQL-5.6/mysql-5.6.35-linux-glibc2.5-x86_64.tar.gz
     tar xvf mysql-5.6.35-linux-glibc2.5-x86_64.tar.gz
     ln -s mysql-5.6.35-linux-glibc2.5-x86_64/ mysql
     cd mysql
     ./scripts/mysql_install_db
     ./bin/mysqld_safe &
     ./bin/mysql_secure_installation

#### 该项目分为4个小项目，Apache需要创建4个虚拟主机，存放该项目的所有代码，虚拟主机的配置如下：
    <VirtualHost *:80>
        ServerAdmin 908601756@qq.com
        DocumentRoot "/var/www/html/Shop-PHP-Yii2/backend/web"
        ServerName admin.eleteam.com
        ErrorLog "logs/admin.eleteam.com-error_log"
        CustomLog "logs/admin.eleteam.com-access_log" common
    </VirtualHost>
    <VirtualHost *:80>
        ServerAdmin 908601756@qq.com
        DocumentRoot "/var/www/html/Shop-PHP-Yii2/frontend/web"
        ServerName eleteam.com
        ServerAlias www.eleteam.com
        ErrorLog "logs/eleteam.com-error_log"
        CustomLog "logs/eleteam.com-access_log" common
    </VirtualHost>
    <VirtualHost *:80>
        ServerAdmin 908601756@qq.com
        DocumentRoot "/var/www/html/Shop-PHP-Yii2/data"
        ServerName data.eleteam.com
        ServerAlias data.eleteam.com
        ErrorLog "logs/data.eleteam.com-error_log"
        CustomLog "logs/data.eleteam.com-access_log" common
    </VirtualHost>
    <VirtualHost *:80>
        ServerAdmin 908601756@qq.com
        DocumentRoot "/var/www/html/Shop-PHP-Yii2/api/web"
        ServerName api.eleteam.com
        ServerAlias api.eleteam.com
        ErrorLog "logs/api.eleteam.com-error_log"
        CustomLog "logs/api.eleteam.com-access_log" common
    </VirtualHost>
    <VirtualHost *:80>
        ServerAdmin 908601756@qq.com
        DocumentRoot "/var/www/html/Shop-PHP-Yii2/wap/web"
        ServerName m.eleteam.com
        ServerAlias m.eleteam.com
        ErrorLog "logs/m.eleteam.com-error_log"
        CustomLog "logs/m.eleteam.com-access_log" common
    </VirtualHost>

#### 配置本地的hosts文件:
    127.0.0.1       local.eleteam.com
    127.0.0.1       local.m.eleteam.com
    127.0.0.1       local.admin.eleteam.com
    127.0.0.1       local.api.eleteam.com
    127.0.0.1       local.admin.eleteam.com
    127.0.0.1       local.data.eleteam.com
    
#### 配置项目:
    以下文件夹要求读写权限:
        chmod -R 777 frontend/runtime frontend/web/assets
        chmod -R 777 backend/runtime  backend/web/assets
        chmod -R 777 wap/runtime      wap/web/assets
        chmod -R 777 api/runtime
        chmod -R 777 console/runtime
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
    前台: eleteam.com
    wap: m.eleteam.com
    api: api.eleteam.com/v1/product/view?id=3
    数据: data.eleteam.com
    gii: eleteam.com/gii
    后台: admin.eleteam.com
        后台超级用户: admin/123456
        后台普通用户: demo/123456

###### @author Tony Wong
###### @copyright Copyright © 2015年 EleTeam. All rights reserved.
###### @license The MIT License (MIT)

###### 此源码遵守 The MIT License (MIT)，可用于商业上，但是因此带来的商业损失EleTeam团队不承担责任。
