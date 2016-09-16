<?php
/**
 * ETShop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2015-06-10
 * @email 908601756@qq.com
 * @copyright Copyright © 2015年 EleTeam
 * @license The MIT License (MIT)
 */

namespace api\modules\v1\controllers;

use common\components\ETRestController;
use common\models\Cart;
use common\models\CartItem;
use common\models\User;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\ArrayHelper;
use yii\validators\Validator;

class UserController extends ETRestController
{
//    /**
//     * 行为: 登录认证
//     * @return array
//     */
////    public function behaviors()
////    {
////        return ArrayHelper::merge(parent::behaviors(), [
////            'authenticator' => [
////                #这个地方使用`ComopositeAuth` 混合认证
////                'class' => CompositeAuth::className(),
////                #`authMethods` 中的每一个元素都应该是 一种 认证方式的类或者一个 配置数组
////                'authMethods' => [
////                    //HttpBasicAuth::className(),
////                    //HttpBearerAuth::className(),
////                    QueryParamAuth::className(), //url as: http://api.eleteam.com/v1/users?access-token=123
////                ]
////            ]
////        ]);
////    }

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

    /**
     * 注册第一步 - 提交手机号码
     * @return string
     */
    public function actionRegisterStep1()
    {
        $mobile = $this->getParam('mobile');
        if(strlen($mobile)<11){
            return $this->jsonFail([], '手机号格式不正确');
        }

        $user = User::findOneByMobile($mobile, null);
        if($user){
            return $this->jsonFail([], '手机号已存在');
        }

        //发送手机验证码
        //SmsUtils.sendRegisterCode(username);

        return $this->jsonSuccess(['mobile'=>$mobile]);
    }

    /**
     * 注册第二步 - 提交手机号码、密码
     * @return string
     */
    public function actionRegisterStep2()
    {
        $mobile = $this->getParam('mobile');
        $password = $this->getParam('password');
        if(strlen($mobile)<11){
            return $this->jsonFail([], '手机号格式不正确');
        }

        $user = User::findOneByMobile($mobile, null);
        if($user){
            return $this->jsonFail([], '手机号已存在');
        }

        //发送手机验证码
        //SmsUtils.sendRegisterCode(username);

        return $this->jsonSuccess(['mobile'=>$mobile, 'password'=>$password]);
    }

    /**
     * 注册完成 - 提交手机号码、密码、验证码
     * @return string
     */
    public function actionRegisterStep3()
    {
        $mobile = $this->getParam('mobile');
        $password = $this->getParam('password');
        $code = $this->getParam('code');
        if(strlen($mobile)<11){
            return $this->jsonFail([], '手机号格式不正确');
        }

        $user = User::findOneByMobile($mobile, null);
        if($user){
            return $this->jsonFail([], '手机号已存在');
        }

        if(strlen($password) < 6){
            return $this->jsonFail([], '密码必须大于6位');
        }

        //比较验证码
        //if (smsService.checkRegisterCode(username, code)) {
        //短信验证码已过期，现在固定用 "8888"
        if($code != '8888'){
            return $this->jsonFail([], '验证码不正确');
        }

        //创建用户
        $user = new User();
        $user->mobile = $mobile;
        $user->password_plain = $password;
        $user->setPassword($password);
        $user->generateAccessToken();
        if($user->save()){
            $app_cart_cookie_id = $this->getAppCartCookieId();
            $user_id = $user->id;

            //给新注册用户发送优惠券
            //couponUserService.send4NewUser(loginUser.getId());

            //转移购物车给用户
            if($app_cart_cookie_id) {
                $cart = Cart::findOneByAppCartCookieId($app_cart_cookie_id);
                if(!$cart){ //创建购物车
                    $cart = new Cart();
                    $cart->user_id = $user_id;
                    $cart->save();
                }else{ //转移购物车项给用户
                    Cart::updateAll(['user_id'=>$user_id], 'app_cart_cookie_id=:app_cart_cookie_id', ['app_cart_cookie_id' => $app_cart_cookie_id]);
                    CartItem::updateAll(['user_id'=>$user_id], 'app_cart_cookie_id=:app_cart_cookie_id', ['app_cart_cookie_id' => $app_cart_cookie_id]);
                }
            }

            $data = [
                'user' => $user->toArray(),
                'app_cart_cookie_id' => Cart::genAppCartCookieId(), //重新生成保存在前端, 当没登陆时用新的购物车
            ];
            return $this->jsonSuccess($data);
        }

        return $this->jsonFail(['user'=>$user->toArray()], '注册用户失败');
    }

    /**
     * 直接注册 - 提交手机号码、密码、验证码
     * @return string
     */
    public function actionRegister()
    {
        $mobile = $this->getParam('mobile');
        $password = $this->getParam('password');
        $code = $this->getParam('code');
        if(strlen($mobile) != 11){
            return $this->jsonFail([], '手机号格式不正确');
        }

        $user = User::findOneByMobile($mobile, null);
        if($user){
            return $this->jsonFail([], '手机号已存在');
        }

        if(strlen($password) < 6){
            return $this->jsonFail([], '密码必须大于6位');
        }

        //比较验证码
        //if (smsService.checkRegisterCode(username, code)) {
        //短信验证码已过期，现在固定用 "8888"
        if($code != '8888'){
            return $this->jsonFail([], '验证码不正确');
        }

        //创建用户
        $user = new User();
        $user->mobile = $mobile;
        $user->password_plain = $password;
        $user->setPassword($password);
        $user->generateAccessToken();
        if($user->save()){
            $app_cart_cookie_id = $this->getAppCartCookieId();
            $user_id = $user->id;

            //给新注册用户发送优惠券
            //couponUserService.send4NewUser(loginUser.getId());

            //转移购物车给用户
            if($app_cart_cookie_id) {
                $cart = Cart::findOneByAppCartCookieId($app_cart_cookie_id);
                if(!$cart){ //创建购物车
                    $cart = new Cart();
                    $cart->user_id = $user_id;
                    $cart->save();
                }else{ //转移购物车项给用户
                    Cart::updateAll(['user_id'=>$user_id], 'app_cart_cookie_id=:app_cart_cookie_id', ['app_cart_cookie_id' => $app_cart_cookie_id]);
                    CartItem::updateAll(['user_id'=>$user_id], 'app_cart_cookie_id=:app_cart_cookie_id', ['app_cart_cookie_id' => $app_cart_cookie_id]);
                }
            }

            $data = [
                'user' => $user->toArray(),
                'app_cart_cookie_id' => Cart::genAppCartCookieId(), //重新生成保存在前端, 当没登陆时用新的购物车
            ];
            return $this->jsonSuccess($data);
        }

        return $this->jsonFail(['user'=>$user->toArray()], '注册用户失败');
    }

    /**
     * 通过手机号码快捷登录
     * @param $mobile
     * @param $code
     * @return string
     */
    public function actionMobileLogin($mobile, $code)
    {
        if(strlen($mobile)<11){
            return $this->jsonFail([], '手机号格式不正确');
        }

        //验证码验证, 未实现 @todo
        if($code != '8888'){
            return $this->jsonFail([], '验证码不正确');
        }

        //手机号存在
        $user = User::findOneByMobile($mobile);

        //如果手机号不存在则创建用户
        if(!$user){
            $user = new User();
            $data = ['User' => ['mobile' => $mobile]];
            if($user->load($data) && $user->save(false)){
                //
            }else{
                return $this->jsonFail($user->errors, '创建用户失败');
            }
        }

        //如果没有access_token,则创建
        $user->access_token = $user->getAccessToken();
        return $this->jsonSuccess(['user'=>$user->toArray()], '登录成功');
    }

    /**
     * api登录, 返回access-token值
     *  购物车商品的保存方式:
     *      1. 没有登陆且购物车有值, 以当前购物车为准
     *      2. 没有登陆且购物车没值, 以用户的购物车为准
     * post: [mobile:123, password=abc]
     * @return LoginForm|string
     */
    public function actionLogin()
    {
        $mobile = $this->getParam('mobile');
        $password = $this->getParam('password');
        $app_cart_cookie_id = $this->getAppCartCookieId();

        if(strlen($mobile) != 11){
            return $this->jsonFail([], '手机号格式不正确');
        }

        if(!strlen($password)){
            return $this->jsonFail([], '请输入密码');
        }

        $user = User::findOneByMobile($mobile);
        if($user && $user->validatePassword($password)){
            $user_id = $user->id;
            $user->getAccessToken();
            //转移购物车给用户
            if($app_cart_cookie_id) {
                $cart = Cart::findOneByAppCartCookieId($app_cart_cookie_id);
                if($cart){
                    $userCart = Cart::myCart($user_id, null);
                    $cartItems = Cart::findItems($cart->id);
                    if($cartItems) {
                        //清空用户的购物车项
                        CartItem::updateAll(['status'=>CartItem::STATUS_DELETED], 'cart_id=:cart_id', ['cart_id'=>$userCart->id]);
                        //转移购物车项给用户
                        CartItem::updateAll(['user_id'=>$user_id, 'cart_id'=>$userCart->id], 'app_cart_cookie_id=:app_cart_cookie_id', ['app_cart_cookie_id' => $app_cart_cookie_id]);
                    }
                }
            }
            $data = [
                'user' => $user->toArray(),
                'app_cart_cookie_id' => Cart::genAppCartCookieId(), //重新生成保存在前端, 当没登陆时用新的购物车
            ];
            return $this->jsonSuccess($data);
        }

        return $this->jsonFail([], '手机号或密码错误');

//        $data = [
//            'username' => $mobile,
//            'password' => $password,
//        ];
//        $model = new LoginForm();
//        if ($model->load($data, '') && $model->login()) {
//            return Yii::$app->user->identity->access_token;
//            return Yii::$app->user->identity->getAuthKey();
//        } else {
//            return $model;
//        }
    }

    /**
     * @param $mobile
     * @return string
     */
    public function actionSendCode($mobile)
    {
        if(strlen($mobile)<11){
            return $this->jsonFail([], '手机号格式不正确');
        }

        $user = User::findOneByMobile($mobile);
        if($user && $user->id){
            return $this->jsonFail([], '手机号已存在');
        }

        //发送手机验证码, 未实现, @todo

        return $this->jsonSuccess([], '验证码已发送');
    }

    /**
     * api退出, 前期退出不更新access-token, 任何平台都可以登录用户的账号,便于调试,而且不会导致用户登录的token失效
     * 后期如果要实现单点登录时,则清空用户的token即可
     * @return bool
     */
    public function actionLogout()
    {
        $app_cart_cookie_id = Cart::genAppCartCookieId(); //重新生成保存在前端, 当没登陆时用新的购物车
        return $this->jsonSuccess(['app_cart_cookie_id'=>$app_cart_cookie_id]);
    }

//    public function actionIsLoggedIn($user_id, $api_login_token)
//    {
//        $result = ['is_logged_in' => false];
//        $user = User::findOne($user_id);
//        if($user && $user->api_login_token && $user->api_login_token == $api_login_token){
//            $result['is_logged_in'] = true;
//        }
//        return $result;
//    }
}
