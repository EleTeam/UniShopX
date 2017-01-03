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

use common\models\Cart;
use wap\components\CookieUtil;
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
//    public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
////                'only' => ['logout', 'signup'],
//                'rules' => [
//                    [
//                        'actions' => ['signup', 'login'],
//                        'allow' => true,
//                        'roles' => ['?'],
//                    ],
//                    [
//                        'actions' => ['logout', 'view'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                ],
//            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ],
//        ];
//    }

    /**
     * 用户登录
     *
     * @return mixed
     */
    public function actionLogin()
    {
        //登陆后返回的页面
        $reload_page = Yii::$app->request->get('reload_page', '/my');

        //get请求
        if(Yii::$app->request->isGet){
            return $this->render('login', ['reload_page' => $reload_page]);
        }

        //post请求
        if(!Yii::$app->user->isGuest){
            return $this->jsonSuccess('已经登录');
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post(), '') && $model->login()) {
            //合并购物车
            $user_id = Yii::$app->user->id;
            $app_cart_cookie_id = CookieUtil::getAppCartCookieId();
            if($app_cart_cookie_id){
                Cart::combineCart($user_id, $app_cart_cookie_id);
                //重新生成app_cart_cookie_id
                $app_cart_cookie_id = Cart::genAppCartCookieId();
                CookieUtil::setAppCartCookieId($app_cart_cookie_id);
            }
            return $this->jsonSuccess(['user_id'=>Yii::$app->getUser()->getId()], '登陆成功');
        } else {
            return $this->jsonFail($model->getErrors(null), $model->errorsToOneString());
        }
    }

    /**
     * 用户注册
     *
     * @return mixed
     */
    public function actionSignup()
    {
        //注册后返回的页面
        $reload_page = Yii::$app->request->get('reload_page', '/my');

        //get请求
        if(Yii::$app->request->isGet){
            return $this->render('signup', ['reload_page' => $reload_page]);
        }

        //post请求
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

            //合并购物车
            $user_id = Yii::$app->user->id;
            $app_cart_cookie_id = CookieUtil::getAppCartCookieId();
            if($app_cart_cookie_id){
                Cart::combineCart($user_id, $app_cart_cookie_id);
                //重新生成app_cart_cookie_id
                $app_cart_cookie_id = Cart::genAppCartCookieId();
                CookieUtil::setAppCartCookieId($app_cart_cookie_id);
            }

            return $this->jsonSuccess(['user_id'=>Yii::$app->getUser()->getId()], '注册成功');
        } else {
            return $this->jsonFail($signupForm->getErrors(null), $signupForm->errorsToOneString());
        }
    }

    public function actionView()
    {
        $user = $this->getUser();
        return $this->render('view', ['user' => $user]);
    }

    /**
     * api退出, 前期退出不更新access-token, 任何平台都可以登录用户的账号,便于调试,而且不会导致用户登录的token失效
     * 后期如果要实现单点登录时,则清空用户的token即可
     * @return bool
     */
    public function actionLogout()
    {
        //$app_cart_cookie_id = Cart::genAppCartCookieId(); //重新生成保存在前端, 当没登陆时用新的购物车
        Yii::$app->user->logout();
        return $this->jsonSuccess(null, '退出成功');
    }
}