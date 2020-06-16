<?php

namespace appback\helpers;

use common\consts\ResponseCode;
use common\helpers\ResponseHelper;
use common\models\User;
use Yii;
use yii\web\Response;

/**
 * 权限访问控制
 * 启用需要在main.phh配置文件配置
 * ```
 * 'as access' => [
 *     'class' => 'appback\helpers\AccessControl',
 *     'allowActions' => ['site/login', 'site/error']
 * ]
 * ```
 */
class AccessControl extends \yii\base\ActionFilter
{
    /**
     * @var array 不需要控制的action, 在main.php配置
     */
    public $allowActions = [];

    /**
     * 判断当前用户是否有权限
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        if (in_array($action->uniqueId, $this->allowActions)) { // 任何人都可以访问的action
            return true;
        }

        $access_token = Yii::$app->request->get('access_token');
        if (empty($access_token)) {
            ResponseHelper::fail([], '您还未登录', ResponseCode::NOT_LOGIN);
            return false; // 返回false会直接输出response对象，不再执行控制器
            // throw new ForbiddenHttpException('您还没有登录'); // 如果抛出异常会重定向到/site/error
        }
        if (!User::loginByAccessToken($access_token)) {
            ResponseHelper::fail([], '登录已过期，请重新登录', ResponseCode::LOGIN_EXPIRED);
            return false;
            // throw new ForbiddenHttpException('登录已过期，请重新登录');
        }

        //是否授权，超级管理员分配所有权限“/*”
        $permissionName = '/' . $action->uniqueId;
        if (Yii::$app->user->can($permissionName) ||
            Yii::$app->user->can('/*') ) {
            return true;
        }

        ResponseHelper::fail([], '没有操作权限', ResponseCode::LOGIN_EXPIRED);
        return false;
        // throw new UnauthorizedHttpException('没有操作权限');
    }

    /**
     * 获得用户的所有权限路由，如果用户分配了/*权限，则返回所有路由
     * @param integer $userId
     * @return array
     */
    public static function getRoutesByUser($userId)
    {
        $routes = [];
        $auth = Yii::$app->authManager;

        $permissions = $auth->getPermissionsByUser($userId);
        foreach ($permissions as $permission) {
            $routes[] = $permission->name;
        }

        if (in_array('/*', $routes)) {
            $permissions = $auth->getPermissions();
            foreach ($permissions as $permission) {
                if ($permission->name != '/*')
                    $routes[] = $permission->name;
            }
        }

        // 如果只分配了/*权限，最后$routes=['/*']
        /*
        $roles = $auth->getRolesByUser($userId); // 支持一个用户可属于多个角色：必须先获取roles再获取permissions
        foreach ($roles as $role) {
            $permissions = $auth->getPermissionsByRole($role->name);
            foreach ($permissions as $permission) {
                $routes[] = $permission->name;
            }
        }
        */

        return $routes;
    }
}