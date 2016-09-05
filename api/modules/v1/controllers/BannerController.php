<?php
/**
 * ETShop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2016-09-04
 * @email 908601756@qq.com
 * @copyright Copyright © 2016 EleTeam
 * @license The MIT License (MIT)
 */

namespace api\modules\v1\controllers;

use common\models\Banner;
use Yii;
use common\components\ETRestController;

/**
 * 广告控制器
 * Class BannerController
 * @package api\modules\v1\controllers
 */
class BannerController extends ETRestController
{
    public function actionList()
    {
        $banners = Banner::find()->where('started_at <= :now_time and ended_at >= :now_time and status = :status',
                                        [':now_time'=>time(), ':status'=>Banner::STATUS_ACTIVE])
                                 ->orderBy('position asc')
                                 ->all();
        return $this->jsonSuccess(['banners'=>$banners]);
    }
}