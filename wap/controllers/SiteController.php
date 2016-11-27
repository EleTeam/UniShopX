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

use common\models\Banner;
use common\models\CmsArticle;
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
//        $this->layout = 'main';

        $banners = Banner::findBanners();

        $query = CmsArticle::find()->where('status=:status', [':status'=>CmsArticle::STATUS_ACTIVE])
            ->offset(0)->limit(self::LIST_INIT_ROW);
        $articles = $query->all();
//        die($query->createCommand()->getRawSql());

//        $articleArrays = [];
//        $i = 0;
//        foreach($articles as $article){
//            $articleArray = $article->toArray();
//            $is_show_image = false;
//            if(($i % 2 == 1) && $article->image){
//                $is_show_image = true;
//            }
//            $articleArray['is_show_image'] = $is_show_image;
//            $articleArrays[] = $articleArray;
//            $i++;
//        }

        return $this->render('index', [
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
