<?php

namespace appwap\models\forms;

use common\helpers\ModelHelper;
use common\models\ModelException;
use common\models\User;
use yii\base\Exception;
use yii\base\Model;

/**
 * appwap 更改用户密码表单
 */
class UserUpdatePasswordForm extends Model
{
    // 必须加这些字段，如果继承数据表模型而不加这些字段也不会加载数据
    public $id;
    public $password;
    public $password_confirm;
    public $google_code;

    /**
     * 没有任何规则的字段不会加载
     */
    public function rules()
    {
        return [
            [['id', 'password', 'password_confirm', 'google_code'], 'required'],
            ['password_confirm', 'compare', 'compareAttribute' => 'password', 'message' => '两次输入密码不一致']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => '后台用户ID',
            'password' => '新密码',
            'password_confirm' => '确认新密码',
        ];
    }

    /**
     * 更新后台用户密码
     * @return bool
     * @throws ModelException
     */
    public function update()
    {
        if (!$this->validate()) {
            throw new ModelException(ModelHelper::errorStr($this));
        }

        $user = User::findOne($this->id);
        if (!$user) {
            throw new ModelException('后台用户不存在');
        }

        //验证当前用户的谷歌验证码
        $curUser = User::findOne(\Yii::$app->user->id);
        $ga = new \PHPGangsta_GoogleAuthenticator();
        if (!$ga->verifyCode($curUser->google_secret, $this->google_code)) {
            throw new ModelException('验证码不正确');
        }

        try {
            $user->setPassword($this->password);
        } catch (Exception $e) {
            throw new ModelException($e->getMessage());
        }
        $user->access_token = ''; // 使被修改用户退出系统
        if ($user->save()) {
            return true;
        } else {
            throw new ModelException(ModelHelper::errorStr($user));
        }
    }
}
