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

use common\models\Product;
use common\models\ProductCategory;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * Product controller
 */
class ProductController extends BaseController
{
    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $product = Product::findOne($id);
        return $this->render('view', [
            'product' => $product,
        ]);
    }
}
