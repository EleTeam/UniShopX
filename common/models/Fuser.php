<?php

namespace common\models;

use common\helpers\PasswordValidator;
use Yii;
use yii\base\Exception;
use yii\web\IdentityInterface;

/**
 * 前端用户模型
 *
 * @property int $id  自增主键
 * @property int $parent_id  父id
 * @property string $username 登录用户名
 * @property string $nickname 昵称
 * @property string|null $mobile 手机号
 * @property string $auth_key
 * @property string $password_hash
 * @property string $verification_token
 * @property string|null $password_reset_token
 * @property string|null $email
 * @property int $status
 * @property string|null $access_token 登录令牌
 * @property int|null $access_token_expired_at 登录令牌过期时间，每次访问都更新
 * @property int $created_at
 * @property int $updated_at
 */
class Fuser extends BaseModel implements IdentityInterface
{
    // 登录令牌过期时间
    const ACCESS_TOKEN_EXPIRE_SECONDS = 1800;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fuser';
    }

    /**
     * {@inheritdoc}
     */
    public static function primaryKey()
    {
        return ['id'];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'nickname', 'auth_key', 'password_hash'], 'required'],
            [['status', 'access_token_expired_at', 'created_at', 'updated_at'], 'integer'],
            [['auth_key'], 'string', 'min' => 6, 'max' => 32],
            [['username'], 'string', 'min' => 2, 'max' => 50],
            [['nickname'], 'string', 'min' => 2, 'max' => 100],
            [['mobile'], 'string', 'max' => 11],
            [['password_hash', 'verification_token', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['access_token'], 'string', 'max' => 200],
            [['username'], 'unique'],
            ['email', 'email'],
            [['password_reset_token'], 'unique'],
            ['status', 'default', 'value' => static::STATUS_ACTIVE],
            ['status', 'in', 'range' => [static::STATUS_ACTIVE, static::STATUS_INACTIVE]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'username' => '登录用户名',
            'nickname' => '昵称',
            'mobile' => '手机号',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'verification_token' => 'Verification Token',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'access_token' => '登录令牌',
            'access_token_expired_at' => '登录令牌过期时间，每次访问都更新',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        if (empty($token))
            return null;
        return static::findOne(['access_token' => $token, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * 每次访问都要先登录
     * @param $token
     * @return bool
     */
    public static function loginByAccessToken($token)
    {
        if ($token) {
            $user = self::findIdentityByAccessToken($token);
            if ($user && $user->access_token_expired_at >= time()) {
                $user->setAccessTokenExpiredAt();
                if ($user->save() && Yii::$app->user->loginByAccessToken($user->access_token)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param $password
     * @throws yii\base\Exception
     */
    public function setPassword($password)
    {
        if (!(new PasswordValidator())->validate($password, $error)) {
            throw new Exception($error);
        }
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function setAccessToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString();
    }

    /**
     * 设置过期时间，每次访问都更新
     */
    public function setAccessTokenExpiredAt() {
        $this->access_token_expired_at = time() + self::ACCESS_TOKEN_EXPIRE_SECONDS;
    }
}
