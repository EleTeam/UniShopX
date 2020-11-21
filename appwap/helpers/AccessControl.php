<?php

namespace appwap\helpers;

use common\consts\ResponseCode;
use common\helpers\ResponseHelper;
use common\models\Fuser;
use Yii;

/**
 * 权限访问控制
 * 启用需要在main.phh配置文件配置
 * ```
 * 'as access' => [
 *     'class' => 'appwap\helpers\AccessControl',
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
        // 任何人都可以访问的action
        if (in_array($action->uniqueId, $this->allowActions)) {
            return true;
        }

        //是否登录
        $access_token = Yii::$app->request->get('access_token');
        if (empty($access_token) || $access_token === 'false') {
            ResponseHelper::fail([], '您还未登录', ResponseCode::NOT_LOGIN);
            return false; // 返回false会直接输出response对象，不再执行控制器
            // throw new ForbiddenHttpException('您还没有登录'); // 如果抛出异常会重定向到/site/error
        }
        if (!Fuser::loginByAccessToken($access_token)) {
            ResponseHelper::fail([], '登录已过期，请重新登录', ResponseCode::LOGIN_EXPIRED);
            return false;
            // throw new ForbiddenHttpException('登录已过期，请重新登录');
        }

        return true;
    }
}