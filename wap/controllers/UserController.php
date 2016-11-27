<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2016-11-10
 * @email 908601756@qq.com
 * @copyright Copyright © 2016 EleTeam
 * @license The MIT License (MIT)
 */

namespace wap\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use wap\models\SignupForm;

/**
 * 用户控制器
 *
 * Class CartController
 * @package wap\controllers
 */
class UserController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
//                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup', 'login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * 用户登录
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if(Yii::$app->request->isGet){
            return $this->render('login');
        }

        if(!Yii::$app->user->isGuest){
            return $this->jsonSuccess('已经登录');
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post(), '') && $model->login()) {
            return $this->jsonSuccess(['user_id'=>Yii::$app->getUser()->getId()], '登陆成功');
        } else {
            return $this->jsonFail($model->getErrors(null), $model->errorsToOneString());
        }
    }

    /**
     * 用户登录
     *
     * @return mixed
     */
    public function actionSignup()
    {
        if(Yii::$app->request->isGet){
            return $this->render('signup');
        }

        if(!Yii::$app->user->isGuest){
            return $this->jsonSuccess('已经登录');
        }

        $signupForm = new SignupForm();
        if($signupForm->load(Yii::$app->request->post(), '') && $signupForm->signup()){
            //自动登录
            $loginForm = new LoginForm();
            $loginForm->username = $signupForm->mobile;
            $loginForm->password = $signupForm->password;
            $loginForm->login();

            return $this->jsonSuccess(['user_id'=>Yii::$app->getUser()->getId()], '注册成功');
        } else {
            return $this->jsonFail($signupForm->getErrors(null), $signupForm->errorsToOneString());
        }
    }

    public function actionView()
    {
        $user = $this->getUser();
        $userArr = [];
        $user && $userArr = $user->toArray();
        $userArr['level_label'] = '铜牌用户';
        $data = [
            'user' => $userArr,
            'user_id' => $this->getUserId(),
        ];
        return $this->jsonSuccess($data);
    }
}