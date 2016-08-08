<?php
/**
 * ETShop-for-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2015-06-10
 * @email 908601756@qq.com
 * @copyright Copyright © 2015年 EleTeam
 * @license The MIT License (MIT)
 */

namespace api\modules\v1\controllers;

use common\components\ETRestController;
use common\models\Cart;
use common\models\OrderItem;
use common\models\ProductAttrItem;
use Yii;
use common\models\Product;

class ProductController extends ETRestController
{
    public function actionView($id)
    {
        $expand = ['category', 'productAttrs'];
        $product = Product::find()->where('id=:id', [':id'=>$id])->with($expand)->one();

        //查找商品属性对象
        $productArr = $product->toArray([], $expand);
        if(isset($productArr['productAttrs'])){
            foreach($productArr['productAttrs'] as &$attr){
                $attrItem = ProductAttrItem::find()->where('id=:id', [':id'=>$attr['item_id']])->with(['productAttrItemValues'])->one();
                $attr['productAttrItem'] = $attrItem->toArray([], ['productAttrItemValues']);
            }
        }

        $cart = Cart::myCart($this->getUserId(), $this->getAppCartCookieId());

        //购物车项数量
        $data = [
            'product' => $productArr,
            'cart_num' => Cart::sumCartNum($cart->id),
            'product_collected' => '1',
        ];
        return $this->jsonSuccess($data);
    }

    public function actionList($category_id)
    {
        $products = Product::listAllByCategoryId($category_id,
            'id, name, category_id, price, featured_price, image_small, short_description')->all();

        $productArr = [];
        foreach($products as $product){
            $productArr[] = $product->toArray();
        }

        return $this->jsonSuccess(['products'=>$productArr]);
    }

    /**
     * 收藏商品
     * @param $id 商品id
     * @return string
     */
    public function actionCollect($id)
    {
        return $this->jsonSuccess([], '已收藏');
    }

    /**
     * 取消收藏商品
     * @param $id 商品id
     * @return string
     */
    public function actionUncollect($id)
    {
        return $this->jsonSuccess([], '取消收藏');
    }

    /**
     * 查看打折的商品列表
     */
    public function actionListFeaturedPrice()
    {
        $products = Product::find()
            ->where('featured_price>0 and status=:status', [':status'=>Product::STATUS_ACTIVE])
            ->orderBy('(price - featured_price) desc')
            ->all();
        $productsArr = [];
        foreach($products as $product){
            $productsArr[] = $product->toArray();
        }
        return $this->jsonSuccess(['products'=>$productsArr]);
    }

    /**
     * 为你精选的商品列表
     */
    public function actionListFeaturedTopic()
    {
        $products = Product::find()
            ->where('app_featured_topic=1 and status=1')
            ->orderBy('app_featured_topic_sort')
            ->all();
        $productsArr = [];
        foreach($products as $product){
            $productsArr[] = $product->toArray();
        }
        return $this->jsonSuccess(['products'=>$productsArr]);
    }

    /**
     * 销量最高的商品列表
     */
    public function actionListTopSeller()
    {
        $productsArr = [];
        $orderItems = OrderItem::find()->alias('t')
            ->innerJoin('Order o', 'o.id = t.order_id')
            ->innerJoin('Product p', 'p.id = t.product_id')
            ->select('t.id, t.product_id, SUM(t.count) total_count')
            ->where('o.is_paid = 1 and p.status = 1')
            ->orderBy('total_count desc')
            ->limit(30)
            ->all();
        foreach($orderItems as $item){
            $product = Product::findOne($item['product_id']);
            if($product)
                $productsArr[] = $product;
        }

        return $this->jsonSuccess($productsArr);
    }

    //yii\rest\ActiveController 的用法
//    public $modelClass = 'common\models\Product';
//    public function actions()
//    {
//        $actions = parent::actions();
//
//        // 禁用"delete" 和 "create" 操作
//        unset($actions['delete'], $actions['create'], $actions['update'], $actions['view']);
//
//        // 使用"prepareDataProvider()"方法自定义数据provider
//        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProviderForIndex'];
//        //$actions['view']['prepareDataProvider'] = [$this, 'prepareDataProviderForView'];
//
//        return $actions;
//    }
//
//    public function actionView($id)
//    {
//        $expand = ['category', 'productAttrs'];
//        $product = Product::find()->where('id=:id', [':id'=>$id])->with($expand)->one();
//
//        //查找商品属性对象
//        $productArr = $product->toArray([], $expand);
//        if(isset($productArr['productAttrs'])){
//            foreach($productArr['productAttrs'] as &$attr){
//                $attrItem = ProductAttrItem::find()->where('id=:id', [':id'=>$attr['item_id']])->with(['productAttrItemValues'])->one();
//                $attr['productAttrItem'] = $attrItem->toArray([], ['productAttrItemValues']);
//            }
//        }
//
//        //购物车项数量
//
//        $data = [
//            'product' => $productArr,
//            'cart_item_num' => 2,
//            'product_collected' => '1',
//        ];
//        return $data;
//    }
//
//    public function prepareDataProviderForIndex()
//    {
//        $category_id = $_GET['category_id'];
//        $query = Product::listAllByCategoryId($category_id,
//            'id, name, category_id, price, featured_price, image_small, short_description');
//
//        //die($query->createCommand()->getRawSql());
//
//        $dataProvider = new ActiveDataProvider(['query' => $query]);
//        return $dataProvider;
//    }
}
