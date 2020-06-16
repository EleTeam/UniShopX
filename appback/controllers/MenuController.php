<?php
namespace appback\controllers;

use appback\helpers\AccessControl;
use common\helpers\ArrayHelper;
use common\helpers\ResponseHelper;
use common\models\Menu;
use Yii;

/**
 * Menu controller
 */
class MenuController extends BaseController
{
    // 获取该用户的所有权限
    public function actionIndex()
    {
        $permissions = Yii::$app->authManager->getPermissionsByUser(Yii::$app->user->id);
        return ResponseHelper::success($permissions);
    }
}
