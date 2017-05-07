<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2016-11-10
 * @email 908601756@qq.com
 * @copyright Copyright © 2016年 EleTeam
 * @license The MIT License (MIT)
 */

namespace wap\controllers;

use Yii;
use common\models\CmsArticle;

/**
 * 访问外部网站代理 controller, 解决js跨域问题
 */
class ProxyController extends BaseController
{
    public function actionGet($url)
    {
        return '<div data-page="index" class="page">'.file_get_contents($url).'</div>';
    }
}
