<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2016-11-26
 * @email 908601756@qq.com
 * @copyright Copyright © 2016年 EleTeam
 * @license The MIT License (MIT)
 */

namespace wap\models;

use common\components\ETModel;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends ETModel
{
    public $mobile;
    public $password;
    public $code; //验证码

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['mobile', 'filter', 'filter' => 'trim'],
            ['mobile', 'required'],
            ['mobile', 'string', 'min' => 11, 'max' => 11],
            ['mobile', 'unique', 'targetClass' => '\common\models\User', 'message' => '该手机号已经存在'],

            ['password', 'filter', 'filter' => 'trim'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6, 'max' => 32],

            ['code', 'filter', 'filter' => 'trim'],
            ['code', 'required'],
            ['code', 'string', 'length' => 4],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->mobile = $this->mobile;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        if($this->code != '8888') {
            $this->addError('code', '验证码不正确');
            return null;
        }

        if($user->save()){
            return $user;
        }
        
        return null;
    }
}
