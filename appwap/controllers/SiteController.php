<?php
namespace appwap\controllers;

use common\models\ModelException;
use common\consts\ResponseCode;
use common\helpers\ResponseHelper;
use common\models\User;
use Yii;
use appwap\models\forms\LoginForm;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $data = [];
        return ResponseHelper::success($data);
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post(), '')) {
            try {
                $model->login();
                return ResponseHelper::success(['access_token' => $model->getAccessToken()]);
            } catch (ModelException $e) {
                return ResponseHelper::fail([], $e->getMessage());
            }
        } else {
            return ResponseHelper::fail([], '提交数据不能为空');
        }
    }

    public function actionLogout()
    {
        $user = User::findOne(Yii::$app->user->id);
        if ($user) {
            $user->access_token = null;
            $user->access_token_expired_at = time();
            $user->save();
        }

        return ResponseHelper::success();
    }

    /**
     * 开发环境：
     *      显示具体报错信息，不分发到这里
     * 生产环境：
     * 发生异常时，系统内部分发到：'errorHandler' => [ 'errorAction' => 'site/error']
     * 抛出的异常会在这捕获，需要在main.php配置文件配置
     * ---
     * 'errorHandler' => [
     *       'errorAction' => 'site/error',
     * ]
     * ---
     */
    public function actionError()
    {
        $response = Yii::$app->response;
        $msg = 'ERROR4000: 服务器异常: ' . Yii::$app->getErrorHandler()->exception->getMessage();
        $code = ResponseCode::FAIL;
        $data = [
            'http_status_code' => $response->getStatusCode()
        ];
        return ResponseHelper::fail($data, $msg, $code);
    }
}
