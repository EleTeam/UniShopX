<?php
namespace appback\controllers;

use common\helpers\ArrayHelper;
use common\helpers\DateHelper;
use common\helpers\ModelHelper;
use appback\models\forms\RoleForm;
use common\helpers\ResponseHelper;
use common\models\ModelException;
use Yii;

/**
 * Role controller
 */
class RoleController extends BaseController
{
    /**
     * 获取所有角色
     */
    public function actionIndex()
    {
        $roles = Yii::$app->authManager->getRoles();
        $items = [];
        foreach ($roles as $role) {
            $item = ArrayHelper::asArray($role, 'name, description');
            $item['created_at'] = DateHelper::format($role->createdAt);
            $items[] = $item;
        }
        $data['items'] = $items;
        $data['total'] = count($roles);

        return ResponseHelper::success($data);
    }

    public function actionView()
    {
        $role = Yii::$app->authManager->getRole(Yii::$app->request->get('name'));
        if ($role) {
            $data = ArrayHelper::asArray($role, 'name, description');
            return ResponseHelper::success($data);
        } else {
            return ResponseHelper::fail([], '角色不存在');
        }
    }

    public function actionCreate()
    {
        return $this->_save();
    }

    public function actionUpdate()
    {
        return $this->_save();
    }

    // 拆分为actionCreate/actionUpdate两个路由是为了分开创建和更新的权限
    //public function actionSave()
    private function _save()
    {
        $model = new RoleForm();
        if ($model->load(Yii::$app->request->post(),'')) {
            try {
                $model->save();
                return ResponseHelper::success();
            } catch (ModelException $e) {
                return ResponseHelper::fail([], $e->getMessage());
            }
        } else {
            return ResponseHelper::fail([], '提交数据不能为空');
        }
    }

    public function actionDelete($name) {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($name);
        if (!$role) {
            return ResponseHelper::fail([], '角色不存在');
        }

        // 超级角色不能删除
        if ($role->name == 'super_role') {
            return ResponseHelper::fail([], '超级角色不能删除');
        }

        if ($auth->remove($role)) {
            return ResponseHelper::success([], '删除角色成功');
        } else {
            return ResponseHelper::fail([], '删除角色失败');
        }
    }
}
