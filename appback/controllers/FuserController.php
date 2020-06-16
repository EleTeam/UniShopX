<?php
namespace appback\controllers;

use appback\models\searchs\FuserSearch;
use common\helpers\DateHelper;
use common\helpers\ResponseHelper;
use common\models\Fuser;
use Yii;

class FuserController extends BaseController
{
    public function actionIndex()
    {
        $searchModel = new FuserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $fusers = $dataProvider->getModels();
        $items = [];
        /* @var Fuser $fusers */
        foreach ($fusers as $fuser) {
            $item = $fuser->toArray(['username', 'nickname', 'mobile', 'email', 'status']);
            $item['created_at'] = DateHelper::format($fuser->created_at);
            $item['updated_at'] = DateHelper::format($fuser->updated_at);
            $items[] = $item;
        }
        $data = [
            'items' => $items,
            'total' => strval($dataProvider->getTotalCount())
        ];
        return ResponseHelper::success($data);
    }

    public function actionView($id)
    {
        $model = Fuser::findOne($id);
        if (!$model) {
            return ResponseHelper::fail([], '用户不存在');
        }

        $item = $model->toArray(['username', 'nickname', 'mobile', 'email', 'status']);
        $item['created_at'] = DateHelper::format($model->created_at);
        $item['updated_at'] = DateHelper::format($model->updated_at);
        ResponseHelper::success(['fuser' => $item]);
    }

    public function actionDelete()
    {
        return ResponseHelper::fail([], '目前不能删除');
    }
}
