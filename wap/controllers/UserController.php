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
use frontend\models\User;

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

            ////////

//            $mobile = $this->getParam('mobile');
//            $password = $this->getParam('password');
//            $app_cart_cookie_id = $this->getAppCartCookieId();
//
//            if(strlen($mobile) != 11){
//                return $this->jsonFail([], '手机号格式不正确');
//            }
//
//            if(!strlen($password)){
//                return $this->jsonFail([], '请输入密码');
//            }
//
//            $user = User::findOneByMobile($mobile);
//            if($user && $user->validatePassword($password)){
//                $user_id = $user->id;
//                $user->getAccessToken();
//                //转移购物车给用户
//                if($app_cart_cookie_id) {
//                    $cart = Cart::findOneByAppCartCookieId($app_cart_cookie_id);
//                    if($cart){
//                        $userCart = Cart::myCart($user_id, null);
//                        $cartItems = Cart::findItems($cart->id);
//                        if($cartItems) {
//                            //清空用户的购物车项
//                            CartItem::updateAll(['status'=>CartItem::STATUS_DELETED], 'cart_id=:cart_id', ['cart_id'=>$userCart->id]);
//                            //转移购物车项给用户
//                            CartItem::updateAll(['user_id'=>$user_id, 'cart_id'=>$userCart->id], 'app_cart_cookie_id=:app_cart_cookie_id', ['app_cart_cookie_id' => $app_cart_cookie_id]);
//                        }
//                    }
//                }
//                $data = [
//                    'user' => $user->toArray(),
//                    'app_cart_cookie_id' => Cart::genAppCartCookieId(), //重新生成保存在前端, 当没登陆时用新的购物车
//                ];
//                return $this->jsonSuccess($data);
//            }
//
//            return $this->jsonFail([], '手机号或密码错误');
    }

    /**
     * 用户注册
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
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