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

use common\redis\RBanner;
use common\models\CmsArticle;
use common\models\ProductCategory;
use Yii;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    /**
     * 首页初始化列表的个数
     */
    const LIST_INIT_ROW = 10;

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

    /**
     * Wap首页
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionHome()
    {
        $banners = RBanner::findBanners();

        $query = CmsArticle::find()->where('status=:status', [':status'=>CmsArticle::STATUS_ACTIVE])
            ->offset(0)->limit(self::LIST_INIT_ROW);
        $articles = $query->all();
        return $this->render('home', [
            'banners' => $banners,
            'articles' => $articles,
        ]);
    }

    public function actionIndexList($page=2)
    {
        $query = CmsArticle::find()->where('status=:status', [':status'=>CmsArticle::STATUS_ACTIVE])
            ->offset(self::LIST_INIT_ROW * ($page-1))->limit(self::LIST_INIT_ROW);
        $articles = $query->all();

        return $this->render('indexList', [
            'articles' => $articles,
        ]);
    }
}
