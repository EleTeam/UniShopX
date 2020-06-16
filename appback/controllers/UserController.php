<?php
namespace appback\controllers;

use appback\models\forms\UserForm;
use appback\models\forms\UserUpdatePasswordForm;
use appback\models\searchs\UserSearch;
use common\helpers\DateHelper;
use common\helpers\ResponseHelper;
use common\models\Menu;
use common\models\ModelException;
use common\models\User;
use Yii;

/**
 * 后台用户 User controller
 */
class UserController extends BaseController
{
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $users = $dataProvider->getModels();
        $items = [];
        /* @var User $user */
        foreach ($users as $user) {
            $item = $user->toArray(['id', 'username', 'nickname', 'mobile', 'sex', 'status', 'google_secret']);
            $item['created_at'] = DateHelper::format($user->created_at);
            $item['role_name'] = '';
            // 获取用户角色名称
            if (($roles = Yii::$app->authManager->getRolesByUser($user->id))) {
                foreach ($roles as $role) {
                    $item['role_name'] .= $role->name . '，';
                }
                $item['role_name'] = rtrim($item['role_name'], '，');
            }
            $items[] = $item;
        }
        $data = [
            'items' => $items,
            'total' => strval($dataProvider->getTotalCount())
        ];
        return ResponseHelper::success($data);
    }

    public function actionCreate()
    {
        $model = new UserForm();

        if ($model->load(Yii::$app->request->post(), '')) {
            try {
                $model->create();
                return ResponseHelper::success([], '添加成功');
            } catch (ModelException $e) {
                return ResponseHelper::fail([], $e->getMessage());
            }
        } else {
            return ResponseHelper::fail([], '提交数据不能为空');
        }
    }

    // 更新当前用户的密码
    public function actionUpdatePassword()
    {
        $model = new UserUpdatePasswordForm();
        if ($model->load(Yii::$app->request->post(), '')) {
            $model->id = $this->getUserId(); // 重新赋值只更新当前用户
            try {
                $model->update();
                return ResponseHelper::success([], '修改成功');
            } catch (ModelException $e) {
                return ResponseHelper::fail([], $e->getMessage());
            }
        } else {
            return ResponseHelper::fail([], '提交数据不能为空');
        }
    }

    // 更新任意后台用户的密码
    public function actionUpdateAnyPassword()
    {
        $model = new UserUpdatePasswordForm();
        if ($model->load(Yii::$app->request->post(), '')) {
            try {
                $model->update();
                return ResponseHelper::success([], '修改成功');
            } catch (ModelException $e) {
                return ResponseHelper::fail([], $e->getMessage());
            }
        } else {
            return ResponseHelper::fail([], '提交数据不能为空');
        }
    }

    public function actionDelete()
    {
        $id = Yii::$app->request->post('id');
        $user = User::findOne($id);
        if (!$user) {
            return ResponseHelper::fail([], '用户不存在');
        }

        try {
            $user->delete();
            return ResponseHelper::success([], '删除成功');
        }  catch (ModelException $e) {
            return ResponseHelper::fail([], $e->getMessage());
        }
    }

    /**
     * 获取用户信息，包括：用户数据，用户的权限，用户的菜单（没有权限的菜单不显示）
     */
    public function actionGetInfo()
    {
        $role_name = Yii::$app->request->get('role_name'); // 可选项
        $user = User::findOne($this->getUserId());

        //查找该用户所有权限, '/user/index'权限必须要分配给所有用户
        $permissions = Yii::$app->authManager->getPermissions();
        $permissionList = [];
        foreach ($permissions as $permission) {
            $permissionList[] = $permission->name;
        }

        $data =  [
            'user' => [
                'id' => $user->id,
                'nickname' => $user->nickname,
                'username' => $user->username
            ],
            'permissions' => $permissionList, //如果后台没有分配权限，就会跳到404页面
            'menus' => Menu::treeByUser($this->getUserId(), $role_name)
        ];
        return ResponseHelper::success($data);
    }
}
