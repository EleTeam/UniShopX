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
use common\models\CmsArticle;
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

    public function actionIndex($page=1, $row=10)
    {
        $banners = [];
        if($page == 1) {
            $banners = Banner::findBanners();
        }

        $query = CmsArticle::find()->where('status=:status', [':status'=>CmsArticle::STATUS_ACTIVE])
            ->offset($row * ($page-1))->limit($row);
        $articles = $query->all();
//        die($query->createCommand()->getRawSql());

        $articleArrays = [];
        $i = 0;
        foreach($articles as $article){
            $articleArray = $article->toArray();
            $is_show_image = false;
            if(($i % 2 == 1) && $article->image){
                $is_show_image = true;
            }
            $articleArray['is_show_image'] = $is_show_image;
            $articleArrays[] = $articleArray;
            $i++;
        }

        return $this->render('index', [
            'banners' => $banners,
            'articles' => $articleArrays,
        ]);
    }
}
