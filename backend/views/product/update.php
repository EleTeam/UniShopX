<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2016-12-27
 * @email 908601756@qq.com
 * @copyright Copyright © 2016年 EleTeam
 * @license The MIT License (MIT)
 */

use common\models\Product;
use common\models\ProductCategory;
use common\models\ProductType;

/**
 * @var $this yii\web\View
 * @var $product Product
 * @var $category ProductCategory
 * @var $categories ProductCategory[]
 * @var $productType ProductType
 * @var $skus array 提交的sku信息
 * @var $sp_val array 提交的规格信息
 * @var $skuError string 提交的sku信息是否有误
 * @var $spec_id_names array
 */

$this->title = Yii::t('app', 'Update Product');
?>
    <?= $this->render('_form', [
        'product' => $product,
        'category' => $category,
        'categories' => $categories,
        'productType' => $productType,
        'skus' => $skus,
        'sp_val' => $sp_val,
        'skuError' => $skuError,
        'spec_id_names' => $spec_id_names,
    ]) ?>
