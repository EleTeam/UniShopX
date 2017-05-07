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

class CmsArticleController extends ETRestController
{
    public function actionView($id)
    {
        $article = CmsArticle::findOne($id);

        //点击数加1
        $article->hits++;
        $article->save();

        return $this->jsonSuccess(['article'=>$article]);
    }
}
