<?php

namespace appback\controllers;

use appback\models\forms\ProductForm;
use common\consts\AuditStatus;
use common\consts\ProductStatus;
use common\consts\ProductType;
use common\consts\YesNo;
use common\helpers\PriceHelper;
use common\helpers\DateHelper;
use common\helpers\ResponseHelper;
use common\models\ModelException;
use Yii;
use common\models\Product;
use appback\models\searchs\ProductSearch;
use yii\data\Pagination;

/**
 * 商品管理
 */
class ProductController extends BaseController
{
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $page = $request->get('page', 1) - 1;
        $page_size = $request->get('page_size', 10);
        $pagination = new Pagination();
        $pagination->pageSize = $page_size;
        $pagination->page = $page;

        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search($request->queryParams);
        $dataProvider->setPagination($pagination);
        $models = $dataProvider->getModels();
        $totalCount = $dataProvider->getTotalCount();

        $items = [];
        /* @var Product $model */
        foreach ($models as $model) {
            $item = $model->toArray();
            $item['price'] = PriceHelper::format2DecimalYuan($model->price);
            $item['featured_price'] = PriceHelper::format2DecimalYuan($model->featured_price);
            $item['show_price'] = PriceHelper::format2DecimalYuan($model->show_price);
            $item['product_status_label'] = ProductStatus::label($model->product_status);
            $item['is_featured_label'] = YesNo::label($model->is_featured);
            $item['description'] = substr($model->description, 0, 10) . '...';
            $item['created_at'] = DateHelper::format($model->created_at);
            $items[] = $item;
        }

        $data = [
            'items' => $items,
            'total' => $totalCount
        ];
        return ResponseHelper::success($data);
    }

    public function actionSave()
    {
        $model = new ProductForm();

        if ($model->load(Yii::$app->request->post(), '')) {
            try {
                $model->save();
                if (!$model->id) {
                    $msg = '添加成功';
                } else {
                    $msg = '修改成功';
                }
                return ResponseHelper::success([], $msg);
            } catch (ModelException $e) {
                return ResponseHelper::fail([], $e->getMessage());
            }
        } else {
            return ResponseHelper::fail([], '提交数据不能为空');
        }
    }

    // 商品对应的常量定义
    public function actionConsts()
    {
        $data = [
            'type_array' => ProductType::toArray(),
            'is_featured_array' => YesNo::toArray(),
            'product_status_array' => ProductStatus::toArray(),
            'audit_status_array' => AuditStatus::toArray()
        ];
        return ResponseHelper::success($data, '商品对应的常量定义');
    }
}
