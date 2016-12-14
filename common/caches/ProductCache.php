<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2016-12-08
 * @email 908601756@qq.com
 * @copyright Copyright © 2016年 EleTeam
 * @license The MIT License (MIT)
 */

namespace common\caches;

use common\models\Product;
use Yii;

/**
 * 商品缓存层
 *
 * Class ProductCache
 * @package common\caches
 */
class ProductCache
{
    /**
     * 获取所有商品信息, 包括sku, 属性
     *
     * @param int $productId
     * @return Product
     */
    public static function getProduct($productId)
    {
        $expand = ['productAttrs', 'productSkus'];
        $product = Product::find()->where('id=:id', [':id'=>$productId])->with($expand)->one();
        return $product;
    }
}
