<?php

namespace appwap\models\forms;

use common\helpers\ModelHelper;
use common\models\BaseModel;
use common\models\ModelException;
use common\models\User;
use yii\base\Model;

/**
 * 用户表单
 */
class UserForm extends Model
{
    // 必须加这些字段，如果继承数据表模型而不加这些字段也不会加载数据
    public $password;
    public $role_name; // 角色名称
    // 以下字段会在User::save()的时候进一步验证
    public $username;
    public $nickname;
    public $mobile;
    public $email;

    /**
     * 没有任何规则的字段不会加载
     */
    public function rules()
    {
        return [
            [['password', 'role_name', 'username', 'nickname'], 'required'],
            [['email', 'mobile'], 'string'],
            ['password', 'string', 'min' => 6, 'max' => 30],
            ['role_name', 'validateRoleName'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'password' => '密码',
            'role_name' => '角色',
        ];
    }

    public function validateRoleName()
    {
        $attribute = 'role_name';
        if (!\Yii::$app->authManager->getRole($this->role_name)) {
            $this->addError($attribute, '角色不存在');
        }
    }

    /**
     * 创建用户
     * @throws ModelException
     */
    public function create()
    {
        if (!$this->validate()) {
            throw new ModelException(ModelHelper::errorStr($this));
        }

        // 生成谷歌密钥
        $ga = new \PHPGangsta_GoogleAuthenticator();
        $google_secret = $ga->createSecret();

        $transaction = User::getDb()->beginTransaction(BaseModel::DEFAULT_TRANSACTION_ISOLATION);

        try {
            //添加用户
            $user = new User();
            $user->username = $this->username;
            $user->nickname = $this->nickname;
            $user->mobile = $this->mobile;
            $user->email = $this->email;
            $user->status = User::STATUS_ACTIVE;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->google_secret = $google_secret;
            if (!$user->save()) {
                $transaction->rollBack();
                throw new ModelException(ModelHelper::errorStr($user));
            }

            //分配角色
            $auth = \Yii::$app->authManager;
            $role = $auth->getRole($this->role_name);
            $auth->assign($role, $user->id);

            $transaction->commit();
        }  catch (\Exception $e) {
            $transaction->rollBack();
            throw new ModelException($e->getMessage());
        }
    }
}
