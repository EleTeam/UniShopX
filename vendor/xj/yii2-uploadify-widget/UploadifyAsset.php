<?php

namespace xj\uploadify;

use yii\web\AssetBundle;

class UploadifyAsset extends AssetBundle {

    public $sourcePath = '@vendor/xj/yii2-uploadify-widget/assets';
    public $basePath = '@webroot/assets';
    public $css = ['uploadify.css'];
    public $js = ['jquery.uploadify.js'];
    public $depends = ['yii\web\JqueryAsset'];

}
