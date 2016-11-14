<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2016-09-30
 * @email 908601756@qq.com
 * @copyright Copyright © 2016年 EleTeam
 * @license The MIT License (MIT)
 */

namespace wap\assets;

use yii\web\AssetBundle;

/**
 * Main wap application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'f7/css/framework7.ios.min.css',
        'f7/css/framework7.ios.colors.min.css',
        'css/site.css',
    ];
    public $js = [
        'f7/js/framework7.min.js',
        'js/site.js',
    ];
    public $depends = [
    ];

//    public function init()
//    {
//        //本地环境
//        $localCss = [
//            'css/msui/sm.css',
//            'css/msui/sm-extend.css',
//        ];
//        $localJs = [
//            'js/msui/zepto.js',
//            'js/msui/sm.js',
//            'js/msui/sm-extend.js',
//        ];
//
//        //正式环境, 用阿里的cdn
//        $productCss = [
//            '//g.alicdn.com/msui/sm/0.6.2/css/sm.min.css',
//            '//g.alicdn.com/msui/sm/0.6.2/css/sm-extend.min.css',
//        ];
//        $productJs = [
//            '//g.alicdn.com/sj/lib/zepto/zepto.min.js',
//            '//g.alicdn.com/msui/sm/0.6.2/js/sm.min.js',
//            '//g.alicdn.com/msui/sm/0.6.2/js/sm-extend.min.js',
//        ];
//
//        if(strpos($_SERVER['HTTP_HOST'], 'local.') === 0){
//            $this->css = $localCss;
//            $this->js = $localJs;
//        }else{
//            $this->css = $productCss;
//            $this->js = $productJs;
//        }
//
//        parent::init();
//    }
}
