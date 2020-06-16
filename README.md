# Shop-PHP-Yii2

#### 如果你支持这个项目，请 Star and Fork Me。

#### 注：有任何问题请在Issues提交，EleTeam会尽快回复。

#### 重构原来的Shop-PHP-Yii2项目，前后端完全分离，前端用 Vue 实现，
     前端项目地址为：https://github.com/EleTeam/Shop-Vue

#### appback管理后台：
    账号：admin   密码：admin123   谷歌验证码：4C7V54RRQXZ3QFTX
     
#### 开发环境为-xampp:
    Yii-2.0.35
    PHP-7.3.x
    MySQL-8.x 或者 MariaDB-10.4.x
    Apache-2.4.x 或者 Nginx-2.x
    Redis-6.x
    
#### 生产环境推荐用lnmp啦，简单便捷
    Centos-8.x，lnmp-1.6 选择最高版本的php/mysql即可，Redis-6.x
    具体的命令行请看：docs/Linux安装流程.txt
    
#### 项目目录：
     appback       管理后台vue接口项目
     appwap        商城vue接口项目
     console       命令行项目
     common        公共模块
     environments  不同环境需要的文件
     docs          开发文档等信息记录，数据库备份
     vagrant       可以忽略
    
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

#### 配置本地的hosts文件:
    127.0.0.1       local.eleteam.com
    127.0.0.1       local.m.eleteam.com
    127.0.0.1       local.admin.eleteam.com
    127.0.0.1       local.api.eleteam.com
    127.0.0.1       local.admin.eleteam.com
    127.0.0.1       local.data.eleteam.com
    
#### 配置项目:
    以下文件夹要求读写权限:
        chmod -R 777 appback/runtime 
        chmod -R 777 appwap/runtime
        chmod -R 777 console/runtime
    数据库配置文件：
        common/config/main-local.php

     
###### 旧项目已经移到old-etshop分支，
      旧项目地址为：https://github.com/EleTeam/Shop-PHP-Yii2/tree/old-etshop

###### @author Tony Wong
###### @copyright Copyright © 2015年 EleTeam. All rights reserved.
###### @license The MIT License (MIT)

###### 此源码遵守 The MIT License (MIT)，可用于商业上，但是因此带来的商业损失EleTeam团队不承担责任。
