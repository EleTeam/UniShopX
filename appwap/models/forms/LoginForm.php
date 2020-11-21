<?php
namespace appwap\models\forms;

use common\helpers\ModelHelper;
use common\models\ModelException;
use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $google_code;

    // 登录成功后赋值
    private $_access_token; // 登录令牌
    private $_expired_at; // 登录过期时间

    /* @var User */
    private $_user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'google_code'], 'required'],
            ['google_code', 'validateGoogleCode'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => '后台用户',
            'password' => '登录密码',
            'google_code' => '谷歌验证码'
        ];
    }

    public function validateGoogleCode($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            $ga = new \PHPGangsta_GoogleAuthenticator();
            if (!$user || !$ga->verifyCode($user->google_secret, $this->google_code)) {
                $this->addError($attribute, '用户名、密码、谷歌验证码不正确');
            }
        }
    }

    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, '用户名、密码、谷歌验证码不正确');
            }
        }
    }

    /**
     * 登录
     * @return bool
     * @throws ModelException
     */
    public function login()
    {
        if (!$this->validate()) {
            throw new ModelException(ModelHelper::errorStr($this));
        }

        $user = $this->getUser();
        // 单点登录，每次登录都更新token
        $user->setAccessToken();
        $user->setAccessTokenExpiredAt();
        if ($user->save() && Yii::$app->user->loginByAccessToken($user->access_token)) {
            $this->_access_token = $user->access_token;
            $this->_expired_at = $user->access_token_expired_at;
            return true;
        } else {
            return false;
        }

        // 多点登录，每次登录只更新过期的token
        /*
        if ($user->access_token) { // 之前登录过
            if ($user->access_token_expired_at > time()) { // 登录未过期
                $accessToken->updateExpire();
            } else { // 登录已过期
                $accessToken->generateAccessToken();
                $accessToken->save();
            }
        } else { // 未登录过
            $accessToken->user_id = $user->id;
            $accessToken->generateAccessToken();
            $accessToken->save();
        }
        */
    }

    public function getAccessToken() {
        return $this->_access_token;
    }

    public function getExpiredAt() {
        return $this->_expired_at;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
