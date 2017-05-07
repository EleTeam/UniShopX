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
 * 文章 controller
 */
class ArticleController extends BaseController
{
    public function actionView($id=0)
    {
        $article = CmsArticle::findOne($id);

        return $this->render('view', [
            'article' => $article,
        ]);
    }

    public function actionList($page, $row=10)
    {
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

        return $this->render('list', [
            'articles' => $articleArrays,
        ]);
    }
}
