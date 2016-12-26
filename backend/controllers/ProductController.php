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
use common\models\ProductType;
use Yii;
use common\models\Product;
use common\models\ProductSearch;
use yii\filters\AccessControl;
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
                        [2] => 常温
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
                    [goods_id] =>
                    [sp_value] => Array
                    (
                    [1] => 标准
                    [4] => 标准
                    )
                    [price] =>
                    [count] => 0
                    [code] =>
                )

                [_1_5_] => Array
                (
                    [goods_id] =>
                    [sp_value] => Array
                    (
                    [1] => 标准
                    [5] => 大杯
                    )
                    [price] =>
                    [count] => 0
                    [code] =>
                )

                [_2_4_] => Array
                (
                    [goods_id] =>
                    [sp_value] => Array
                    (
                    [2] => 常温
                    [4] => 标准
                    )
                    [price] =>
                    [count] => 0
                    [code] =>
                )

                [_2_5_] => Array
                (
                    [goods_id] =>
                    [sp_value] => Array
                    (
                    [2] => 常温
                    [5] => 大杯
                    )
                    [price] =>
                    [count] => 0
                    [code] =>
                )
            )
     * @return mixed
     */
    public function actionCreateStep2()
    {
        $category_id = Yii::$app->request->get('category_id');
        $type_id = Yii::$app->request->get('type_id');
        $skus = Yii::$app->request->post('skus', []); //选中的规格值组合成的sku
        $sp_val = Yii::$app->request->post('sp_val', []); //选中的规格和规格值


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
        if (Yii::$app->request->isPost
                && $product->load(Yii::$app->request->post()) && $product->validate()) {
            $product->save();
            return $this->redirect(['view', 'id' => $product->id]);
        }

//        echo '<pre>';
//        print_r($_REQUEST);
//        print_r($product->errorsToString());

        return $this->render('create_step2', [
            'product' => $product,
            'productType' => $productType,
            'category' => $category,
            'categories' => $categories,
            'skus' => $skus,
            'sp_val' => $sp_val,
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
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
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
