<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2016-09-06
 * @email 908601756@qq.com
 * @copyright Copyright © 2016 EleTeam
 * @license The MIT License (MIT)
 */

namespace api\modules\v1\controllers;

use common\components\ETRestController;
use Yii;
use common\models\CmsArticle;

class HomeController extends ETRestController
{
    public function actionListArticles($page, $row=10)
    {
        $query = CmsArticle::find()->where('status=:status', [':status'=>CmsArticle::STATUS_ACTIVE])
            ->offset($row * ($page-1))->limit($row);
        $articles = $query->all();
//        die($query->createCommand()->getRawSql());

        $articlesArray = [];
        $i = 0;
        foreach($articles as $article){
            $articleArray = $article->toArray();
            $is_show_image = false;
            if(($i % 2 == 1) && $article->image){
                $is_show_image = true;
            }
            $articleArray['is_show_image'] = $is_show_image;
            $articlesArray[] = $articleArray;
            $i++;
        }

        $data = [
            'articles' => $articlesArray,
        ];
        return $this->jsonSuccess($data);
    }
}
