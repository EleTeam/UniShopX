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

use common\models\ProductCategory;
use common\models\ProductSku;
use common\models\ProductSpec;
use common\models\ProductSpecValue;
use common\models\ProductType;
use Yii;
use common\models\Product;
use common\models\ProductSearch;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ]);
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = false;
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $category = new ProductCategory();
        $categories = $category->find()->where('status=:status', [':status'=>$category::STATUS_ACTIVE])->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categories' => $categories,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateStep1()
    {
        $category = new ProductCategory();
        $categories = $category->find()
            ->where('status=:status and id!=:root_level_id', [':status'=>$category::STATUS_ACTIVE, ':root_level_id'=>$category::ROOT_LEVEL_ID])
            ->orderBy('sort')
            ->all();

        $productType = new ProductType();
        $productTypes = $productType->find()
            ->where('status=:status', [':status'=>$productType::STATUS_ACTIVE])
            ->orderBy('sort')
            ->all();

        return $this->render('create_step1', [
            'categories' => $categories,
            'productTypes' => $productTypes,
        ]);
    }

    /**
     * 第二步创建商品
     * post过来的值
     * 选中的规格和规格值:
         [sp_val] => Array
            (
                [1] => Array
                    (
                        [1] => 标准
                        [2] => 标准
                    )

                [2] => Array
                    (
                        [4] => 标准
                        [5] => 大杯
                    )
            )
     * 选中的规格值组合成的sku:
        [skus] => Array
            (
                [_1_4_] => Array
                (
                    [spec_value_id_names] => Array
                    (
                        [1] => 标准
                        [4] => 标准
                    )
                    [price] =>
                    [count] => 0
                    [code] =>
                )

                [_2_5_] => Array
                (
                    [spec_value_id_names] => Array
                    (
                        [2] => 标准
                        [5] => 大杯
                    )
                    [price] =>
                    [count] => 0
                    [code] =>
                )
            )
     * @return mixed
     *
     * ALTER TABLE `etshop`.`product` ADD COLUMN `specs_json` varchar(255) COMMENT '选择的规格id和规格值' AFTER `status`;
     */
    public function actionCreateStep2()
    {
        $category_id = Yii::$app->request->get('category_id');
        $type_id = Yii::$app->request->get('type_id');
        $skus = Yii::$app->request->post('skus', []); //选中的规格值组合成的sku
        $sp_val = Yii::$app->request->post('sp_val', []); //选中的规格和规格值

        $spec_id_names = [];
        $spec_ids = '_'; //组合spec_id给保存sku使用
        foreach($sp_val as $spec_id => $spec_value_ids){
            $spec = ProductSpec::findOne($spec_id);
            if($spec){
                $spec_id_names[$spec->id] = $spec->name;
            }
            $spec_ids .= $spec_id . '_';
        }

        if(empty($category_id) || empty($type_id)){
            return '请在第一步选择商品分类和类型';
        }

        $category = ProductCategory::findOneActive($category_id);
        $productType = ProductType::findOneActive($type_id);
        $categories = $category->find()
            ->where('status=:status and id!=:root_level_id', [':status'=>ProductCategory::STATUS_ACTIVE, ':root_level_id'=>ProductCategory::ROOT_LEVEL_ID])
            ->orderBy('sort')
            ->all();

        if(empty($category)){
            return '商品分类不存在';
        }
        if(empty($productType)){
            return '商品类型不存在';
        }

        $product = new Product();
        //提交表单，如果验证通过，新增商品
        $skuError = '';
        if (Yii::$app->request->isPost){
//            echo '<pre>';
//            print_r($sp_val);

            $isValid = true;
            //验证sku信息
            if(!$skus){
                $skuError = '请勾选以上规格';
                $isValid = false;
            }
            $codes = [];
            foreach($skus as $spec_value_ids => $sku){
                if(empty($sku['price'])){
                    $skuError = '价格不能为空';
                    $isValid = false;
                    break;
                }
                if(empty($sku['code'])){
                    $skuError = 'SKU编码不能为空';
                    $isValid = false;
                    break;
                }
                if(in_array($sku['code'], $codes)){
                    $skuError = 'SKU编码不能重复';
                    $isValid = false;
                    break;
                }
                if(ProductSku::findOne(['code' => $sku['code']])){
                    $skuError = "SKU编码({$sku['code']})已经存在";
                    $isValid = false;
                    break;
                }
                $codes[] = $sku['code'];
            }

            //验证商品信息
            $product->specs_json = Json::encode($sp_val);
            if($product->load(Yii::$app->request->post()) && $product->validate() && $isValid) {
                //保存商品
                $product->save();

                //保存sku
                foreach($skus as $spec_value_ids => $sku) {
                    $productSku = new ProductSku();
                    $productSku->product_id = $product->id;
                    $productSku->spec_ids = $spec_ids;
                    $productSku->spec_value_ids = $spec_value_ids;
                    $productSku->price = $sku['price'];
                    $productSku->count = $sku['count'];
                    $productSku->code = $sku['code'];
                    $productSku->save();
                }

                return $this->redirect(['view', 'id' => $product->id]);
            }

            print_r($product->errorsToString());
        }

        return $this->render('_form', [
            'title' => 'Create Product',
            'product' => $product,
            'productType' => $productType,
            'category' => $category,
            'categories' => $categories,
            'skus' => $skus,
            'sp_val' => $sp_val,
            'spec_id_names' => $spec_id_names,
            'skuError' => $skuError,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $product = self::findModel($id);

        //为表单构建规格, 参考actionCreateStep2()
        $sp_val = [];
        $skus = [];
        $oldSkus = [];

        /**
         * @var $productSku ProductSku
         */
        foreach ($product->productSkus as $productSku) {
            //构建$sp_val
            $sp_val = $product->specsArray;
            //构建skus
            if ($productSku->spec_value_ids) {
                $spec_value_id_names = [];
                foreach($productSku->productSpecValues as $productSpecValue){
                    $spec_value_id_names[$productSpecValue->id] = $productSpecValue->name;
                }
                $skus[$productSku->spec_value_ids] = [
                    'spec_value_id_names' => $spec_value_id_names,
                    'id' => $productSku->id,
                    'price' => $productSku->price,
                    'count' => $productSku->count,
                    'code' => $productSku->code,
                ];
            }
        }
        $oldSkus = $skus;

        //表单提交, 用表单的$sp_val和$skus
        if (Yii::$app->request->isPost){
            $sp_val = Yii::$app->request->post('sp_val', []); //选中的规格和规格值
            $skus = Yii::$app->request->post('skus', []); //选中的规格值组合成的sku
        }


        $spec_id_names = [];
        $spec_ids = '_'; //组合spec_id给保存sku使用
        foreach($sp_val as $spec_id => $spec_value_ids){
            $spec = ProductSpec::findOne($spec_id);
            if($spec){
                $spec_id_names[$spec->id] = $spec->name;
            }
            $spec_ids .= $spec_id . '_';
        }

        $categories = ProductCategory::find()
            ->where('status=:status and id!=:root_level_id', [':status'=>ProductCategory::STATUS_ACTIVE, ':root_level_id'=>ProductCategory::ROOT_LEVEL_ID])
            ->orderBy('sort')
            ->all();

        //提交表单，如果验证通过，新增商品
        $skuError = '';
        if (Yii::$app->request->isPost){
            $isValid = true;
            //验证sku信息
            if(!$skus){
                $skuError = '请勾选以上规格';
                $isValid = false;
            }
            $codes = [];
            foreach($skus as $spec_value_ids => $sku){
                if(empty($sku['price'])){
                    $skuError = '价格不能为空';
                    $isValid = false;
                    break;
                }
                if(empty($sku['code'])){
                    $skuError = 'SKU编码不能为空';
                    $isValid = false;
                    break;
                }
                if(in_array($sku['code'], $codes)){
                    $skuError = 'SKU编码不能重复';
                    $isValid = false;
                    break;
                }
                $otherProduct = ProductSku::find()
                    ->where('code=:code and product_id!=:product_id', [':code'=>$sku['code'], ':product_id'=>$id])
                    ->one();
                if($otherProduct){
                    $skuError = "SKU编码(sku code:{$sku['code']}, product id:{$otherProduct->id})已经存在";
                    $isValid = false;
                    break;
                }
                $codes[] = $sku['code'];
            }

            //验证商品信息
            $product->specs_json = Json::encode($sp_val);
            if($isValid) {
                if($product->load(Yii::$app->request->post()) && $product->validate()){
                    //保存商品
                    $product->save();

                    //保存sku
                    $savedSkuIds = [];
                    foreach($skus as $spec_value_ids => $sku) {
                        //如果sku存在则保存, 否则增加
                        $productSku = ProductSku::findOne(['id'=>$sku['id']]);
                        if(!$productSku) {
                            $productSku = new ProductSku();
                        }
                        $productSku->product_id = $product->id;
                        $productSku->spec_ids = $spec_ids;
                        $productSku->spec_value_ids = $spec_value_ids;
                        $productSku->price = $sku['price'];
                        $productSku->count = $sku['count'];
                        $productSku->code = $sku['code'];
                        $productSku->save();
                        $savedSkuIds[$productSku->id] = $productSku->id;
                    }

                    //硬删除本商品不需要的sku
                    foreach($oldSkus as $oldSku){
                        if(!isset($savedSkuIds[$oldSku['id']])){
                            ProductSku::deleteAll('id=:id', [':id'=>$oldSku['id']]);
                        }
                    }

                    return $this->redirect(['view', 'id' => $product->id]);
                }
            }
        }

        return $this->render('_form', [
            'title' => 'Update Product',
            'product' => $product,
            'productType' => $product->productType,
            'category' => $product->category,
            'categories' => $categories,
            'skus' => $skus,
            'sp_val' => $sp_val,
            'spec_id_names' => $spec_id_names,
            'skuError' => $skuError,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
