<?php

namespace appwap\controllers;

use common\consts\NotifyStatus;
use common\consts\OrderStatus;
use common\consts\ProductType;
use common\helpers\PriceHelper;
use common\helpers\DateHelper;
use common\helpers\NotifyHelper;
use common\helpers\ResponseHelper;
use common\models\Fuser;
use common\models\Payer;
use Yii;
use common\models\Order;
use appwap\models\searchs\OrderSearch;
use yii\base\Exception;
use yii\data\Pagination;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends BaseController
{
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $page = $request->get('page', 1) - 1;
        $page_size = $request->get('page_size', 10);
        $pagination = new Pagination();
        $pagination->pageSize = $page_size;
        $pagination->page = $page;

        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search($request->queryParams);
        $dataProvider->setPagination($pagination);
        $orders = $dataProvider->getModels();
        $totalCount = $dataProvider->getTotalCount();

        $items = [];
        /* @var Order $order */
        foreach ($orders as $order) {
            $item = $order->toArray();
            $item['total_price'] = PriceHelper::format2DecimalYuan($order->total_price);
            $item['origin_total_price'] = PriceHelper::format2DecimalYuan($order->origin_total_price);
            $item['order_status_label'] = OrderStatus::label($order->order_status);
            $item['created_at'] = DateHelper::format($order->created_at);
            $items[] = $item;
        }

        $data = [
            'items' => $items,
            'total' => $totalCount
        ];
        return ResponseHelper::success($data);
    }

    // 订单首页统计
    public function actionStat()
    {
        $request = Yii::$app->request;
        $searchModel = new OrderSearch();

        // 总数
        $selectColumns = 'COUNT(1) total_count';
        $dataProvider = $searchModel->search($request->queryParams);
        $total = $dataProvider->query->select($selectColumns)->asArray(true)->one();

        // 成功的总数
        $selectColumns = 'SUM(total_price) total_price, COUNT(1) total_count';
        $dataProvider = $searchModel->search($request->queryParams);
        $success = $dataProvider->query->select($selectColumns)->andFilterWhere(['order_status' => OrderStatus::SUCCESS])->asArray(true)->one();

        $data = [
            'total_price_success' => $success['total_price'] ? PriceHelper::format2DecimalYuan($success['total_price']) : '0',
            'total_count_success' => $success['total_count'],
            'total_count' => $total['total_count'],
        ];
        return ResponseHelper::success($data);
    }
}
