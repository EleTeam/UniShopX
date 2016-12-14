<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2015-06-22
 * @email 908601756@qq.com
 * @copyright Copyright © 2015年 EleTeam
 * @license The MIT License (MIT)
 */

namespace backend\controllers;

use common\models\Category;
use Yii;
use common\models\Product;
use common\models\ProductSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * 移植控制器
 */
class MigrationController extends BaseController
{
    public function actionIndex()
    {
        echo '移值...';
    }

    /**
     * 移植产品图片
     */
    public function actionProductimage()
    {
        $products = Product::find()->all();
        foreach($products as $product){
//            if($product->image == '/public')
//                $product->image = null;
//            if($product->image_small == '/public')
//                $product->image_small = null;
//            if($product->image_large == '/public')
//                $product->image_large = null;
//            if($product->image_medium == '/public')
//                $product->image_medium = null;
//            if($product->app_long_image1 == '/public')
//                $product->app_long_image1 = null;
//            if($product->app_long_image2 == '/public')
//                $product->app_long_image2 = null;
//            if($product->app_long_image3 == '/public')
//                $product->app_long_image3 = null;
//            if($product->app_long_image4 == '/public')
//                $product->app_long_image4 = null;
//            if($product->app_long_image5 == '/public')
//                $product->app_long_image5 = null;
            /*
            $product->image = str_replace('/public', '/uploads/public/product', $product->image);
            $product->image_small = str_replace('/public', '/uploads/public/product', $product->image_small);
            $product->image_large = str_replace('/public', '/uploads/public/product', $product->image_large);
            $product->image_medium = str_replace('/public', '/uploads/public/product', $product->image_medium);
            $product->app_long_image1 = str_replace('/public', '/uploads/public/product', $product->app_long_image1);
            $product->app_long_image2 = str_replace('/public', '/uploads/public/product', $product->app_long_image2);
            $product->app_long_image3 = str_replace('/public', '/uploads/public/product', $product->app_long_image3);
            $product->app_long_image4 = str_replace('/public', '/uploads/public/product', $product->app_long_image4);
            $product->app_long_image5 = str_replace('/public', '/uploads/public/product', $product->app_long_image5);
            $product->save();
            */
        }
        echo '移植产品图片结束';
        exit;
    }

    /**
     * 移植产品id, 利用外键来更改
     */
    public function actionProductid()
    {
        //category, product, product_attr
//        $products = Product::find()->all();
//
//        foreach($products as $product){
//            $productIdOld = $product->id;
//            $category =
//            $product->save();
//        }
        echo '移植产品图片结束';
        exit;
    }

    /**
     * 移植目录id, 利用外键来更改
     */
    public function actionCategoryid()
    {
        $categories = Category::find()->all();
//        $i = 1;
//        foreach($categories as $category){
//            //更新product.category_id
//            if($category->id == 1)
//                continue;
//            $products = Product::find()->where('category_id = :category_id', [':category_id'=>$category->id]);
//            echo $category->id . '<br>';
//            var_dump($products);exit;
//            foreach($products as $product){
//                var_dump($product);exit;
//                $product->category_id = $i;
//                $product->save();
//            }
//            //更新category.id
//            //用sql更新, update product set id='aaa' where id='ssss'
//            $connection = Category::getDb();
//            $sql = 'UPDATE category SET id="' . $i . '" WHERE id="' . $category->id . '"';
//            $command = $connection->createCommand($sql);
//            $command->execute();
//            $i++;
//        }
//        echo '移植产品目录结束';
//        exit;
    }
}
