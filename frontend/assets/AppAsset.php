<?php
/**
 * ETShop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2015-05-06
 * @email 908601756@qq.com
 * @copyright Copyright © 2015年 EleTeam
 * @license The MIT License (MIT)
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
