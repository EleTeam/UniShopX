<?php

namespace appwap\models\forms;

use common\helpers\ModelHelper;
use common\models\ModelException;
use Yii;
use common\models\BaseModel;
use yii\base\Model;

/**
 * 角色表单
 */
class RoleForm extends Model
{
    public $old_name; // 旧名称，没有该值则为创建，有该值则为更新
    public $name; //名称
    public $description; //描述
    public $permissions = []; //权限路由如：[/user/index,/user/create]

    // 添加/修改角色时默认分配的权限
    const DEFAULT_PERMISSIONS = [
        '/user/get-info', '/site/logout'
    ];

    /**
     * 注意：在这个方法内数据还没有加载，不能用if ($this->old_name) 这样的判断来添加规则
     * {@inheritdoc}
     */
    public function rules()
    {
        $rules = [
            [['name', 'permissions'], 'required'],
            [['name', 'old_name', 'description'], 'filter', 'filter' => 'trim'],
            [['name', 'old_name'], 'string', 'min' => 2, 'max' => 64],
            ['description', 'string', 'max' => 200],
            ['name', 'validateName'],
            ['old_name', 'validateOldName'],
            ['permissions', 'validatePermissions'],
        ];
        return $rules;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => '名称',
            'description' => '描述',
            'permissions' => '权限',
        ];
    }

    public function validateName()
    {
        $attribute = 'name';
        if ($this->name == 'super_role' || $this->name == '超级管理员') {
            $this->addError($attribute, '角色名称不能为：'.$this->name.'。');
        }

        // 如果是更新且没有更新名称，则不验证角色是否存在
        if (!empty($this->old_name) && $this->old_name == $this->name)
            return;

        if (!$this->hasErrors()) {
            if (Yii::$app->authManager->getRole($this->$attribute)) {
                $this->addError($attribute, '角色已存在。');
            }
        }
    }

    public function validateOldName()
    {
        $attribute = 'old_name';
        if (!empty($this->old_name)) { // 更新角色时才验证
            if ($this->$attribute == 'super_role' || $this->$attribute == '超级管理员') {
                $this->addError($attribute, '不能编辑超级管理员。');
            }
            if (!$this->hasErrors()) {
                if (!Yii::$app->authManager->getRole($this->$attribute)) {
                    $this->addError($attribute, '旧角色不存在。');
                }
            }
        }
    }

    public function validatePermissions()
    {
        $attribute = 'permissions';
        if (!$this->hasErrors()) {
            if (empty($this->permissions)) {
                $this->addError($attribute, '权限不能为空。');
            }

            // 判断当前用户是否有该权限，没有该权限是不能再分配给他人的
            $permissions = Yii::$app->authManager->getPermissionsByUser(Yii::$app->user->id);
            $userPermissions = [];
            foreach ($permissions as $permission) {
                if ($permission->name == '/*') // 该用户拥有所有权限，直接验证通过
                    return;
                $userPermissions[] = $permission->name;
            }
            foreach ($this->permissions as $route) {
                if (!in_array($route, $userPermissions)) {
                    $this->addError($attribute, '您没有分配'.$route.'的权限。');
                }
            }
        }
    }

    /**
     * 创建/更新角色和分配权限
     * @throws ModelException
     */
    public function save()
    {
        if (!$this->validate()) {
            throw new ModelException(ModelHelper::errorStr($this));
        }

        $transaction = Yii::$app->db->beginTransaction(BaseModel::DEFAULT_TRANSACTION_ISOLATION);

        $auth = Yii::$app->authManager;
        if (empty($this->old_name)) { // 创建角色
            $role = $auth->createRole($this->name);
            $role->description = $this->description;
            try {
                if (!$auth->add($role)) {
                    $transaction->rollBack();
                    throw new ModelException('创建角色失败。');
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw new ModelException('创建角色异常：' . $e->getMessage());
            }
        } else { // 更新角色
            $role = $auth->getRole($this->old_name);
            $role->name = $this->name;
            $role->description = $this->description;
            try {
                $auth->update($this->old_name, $role);
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw new ModelException('更新角色异常：' . $e->getMessage());
            }
            // 删除角色的权限
            $auth->removeChildren($role);
        }

        // 分配默认权限
        foreach (self::DEFAULT_PERMISSIONS as $route) {
            $child = $auth->getPermission($route);
            try {
                $auth->addChild($role, $child);
            }  catch (\yii\base\Exception $e) {
                $transaction->rollBack();
                throw new ModelException('分配默认权限异常：'.$e->getMessage());
            }
        }
        // 分配提交过来的权限
        foreach ($this->permissions as $route) {
            if (in_array($route, self::DEFAULT_PERMISSIONS))
                continue;
            $child = $auth->getPermission($route);
            try {
                $auth->addChild($role, $child);
            }  catch (\yii\base\Exception $e) {
                $transaction->rollBack();
                throw new ModelException('分配权限异常：'.$e->getMessage());
            }
        }

        try {
            $transaction->commit();
            return true;
        }  catch (\yii\db\Exception $e) {
            $transaction->rollBack();
            $this->addError('name', '数据库操作异常：'.$e->getMessage());
            return false;
        }
    }
}
