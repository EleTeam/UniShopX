<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2015-06-10
 * @email 908601756@qq.com
 * @copyright Copyright © 2015年 EleTeam
 * @license The MIT License (MIT)
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'adminlte/others/font-awesome.min.css',
        'adminlte/others/ionicons.min.css',
        'adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.css',
        'adminlte/dist/css/AdminLTE.min.css',
        'adminlte/dist/css/skins/_all-skins.min.css',
    ];
    public $js = [
        'adminlte/bootstrap/js/bootstrap.min.js',
        'adminlte/plugins/fastclick/fastclick.js',
        'adminlte/dist/js/app.min.js',
        'adminlte/plugins/sparkline/jquery.sparkline.min.js',
        'adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
        'adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
        'adminlte/plugins/slimScroll/jquery.slimscroll.min.js',
        'adminlte/plugins/chartjs/Chart.min.js',
        //'adminlte/dist/js/pages/dashboard2.js',
        //'adminlte/dist/js/demo.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
