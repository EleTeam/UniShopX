<?php
namespace appwap\controllers;

use appwap\models\searchs\FuserSearch;
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

    /**
     * 获取用户信息，包括：用户数据，用户的菜单
     */
    public function actionGetInfo()
    {
        $mch = $this->getFuser();

        $data =  [
            'mch' => [
                'mch_no' => $mch->mch_no,
                'nickname' => $mch->nickname,
                'username' => $mch->username
            ],
            'menus' => [
                [
                    'name' => '首页',
                    'route' => '/site/index',
                    'icon' => 'fa fa-dashboard',
                ],
                [
                    'name' => '订单列表',
                    'route' => '/order/index',
                    'icon' => 'fa fa-list',
                ],
                [
                    'name' => '流水列表',
                    'route' => '/balance-flow/index',
                    'icon' => 'fa fa-list-ul',
                ],
                [
                    'name' => '修改密码',
                    'route' => '/mch/update-password',
                    'icon' => 'fa fa-lock',
                ],
            ],
        ];
        return ResponseHelper::success($data);
    }
}
