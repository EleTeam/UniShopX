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
//        $expand = ['category', 'productAttrs', 'productSkus'];
//        $product = Product::find()->where('id=:id', [':id'=>$id])->with($expand)->one();
        $product = Product::findOneNotDeleted($id);
        return $this->render('view', [
            'product' => $product,
        ]);
    }
}
