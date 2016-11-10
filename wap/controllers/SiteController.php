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

namespace wap\controllers;

use common\components\ETWebController;
use common\models\Banner;
use Yii;

/**
 * Site controller
 */
class SiteController extends ETWebController
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $banners = Banner::findBanners();

        return $this->render('index', [
            'banners' => $banners,
            'a'=>'aa',
        ]);
    }
}
