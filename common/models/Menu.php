<?php

namespace common\models;

use appback\helpers\AccessControl;
use common\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property int $id
 * @property string $name
 * @property int|null $parent_id
 * @property string|null $route
 * @property int|null $sort
 * @property resource|null $data
 * @property string|null $icon
 *
 * @property Menu $parent
 * @property Menu[] $children
 * @property MenuAction[] $actions
 */
class Menu extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu';
    }

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
            [['name'], 'required'],
            [['parent_id', 'sort'], 'integer'],
            [['data'], 'string'],
            [['name'], 'string', 'max' => 128],
            [['route'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::class, 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'parent_id' => 'Parent',
            'route' => 'Route',
            'sort' => '排序',
            'data' => 'Data',
        ];
    }

    /**
     * @return Menu|array|\yii\db\ActiveRecord|null
     */
    public function getParent()
    {
        return $this->hasOne(Menu::class, ['id' => 'parent_id'])->one();
    }

    /**
     * Gets query for [[Children]].
     *
     * @return Menu[]
     */
    public function getChildren()
    {
        return $this->hasMany(Menu::class, ['parent_id' => 'id'])->orderBy('sort')->all();
    }

    /**
     * Gets query for [[MenuAction]].
     *
     * @return MenuAction[]
     */
    public function getActions()
    {
        return $this->hasMany(MenuAction::class, ['menu_id' => 'id'])->orderBy('sort')->all();
    }

    /**
     * 获取一级菜单
     * @return Menu[]
     */
    public static function findFirstLevel()
    {
        return Menu::find()->where(['parent_id' => null])->orderBy('sort')->all();
    }

    /**
     * 获取用户拥有权限的菜单
     * @param int $user_id
     * @param string $role_name 如果有角色名称，则actions节点多一个is_selected字段，在分配角色页面用来默认选中与否
     * @return array
     */
    public static function treeByUser($user_id, $role_name=null)
    {
        $routes = AccessControl::getRoutesByUser($user_id);

        //查找所有菜单
        $menus = Menu::findFirstLevel(); // 一级菜单
        $menuArr = [];
        foreach ($menus as $menu) {
            $keys = 'id, name, icon, route, pid, sort';
            $item = ArrayHelper::asArray($menu, $keys);
            $item['actions'] = []; // 一级菜单没有action，不用获取，可以减少查询次数
            $item['children'] = [];
            $childMenus = $menu->getChildren(); // 二级菜单
            foreach ($childMenus as $childMenu) {
                $child = ArrayHelper::asArray($childMenu, $keys);
                $child['actions'] = [];
                $child['children'] = [];
                // 获取actions
                $actions = $childMenu->actions;
                foreach ($actions as $action) {
                    $actionItem = ArrayHelper::asArray($action, 'menu_id, name, route, sort');
                    // 只添加有权限的action
                    if (in_array($action->route, $routes)) {
                        // 是否选中权限
                        if ($role_name) {
                            $actionItem['is_selected'] = 0;
                            if (($permissions = Yii::$app->authManager->getPermissionsByRole($role_name))) {
                                foreach ($permissions as $permission) {
                                    if ($permission->name == '/*') { // 拥有所有权限就直接选中
                                        $actionItem['is_selected'] = 1;
                                        break;
                                    } else if ($action->route == $permission->name) {
                                        $actionItem['is_selected'] = 1;
                                    }
                                }
                            }
                        }
                        $child['actions'][] = $actionItem;
                    }
                }
                // 只添加有action的子菜单
                if (count($child['actions']) > 0)
                    $item['children'][] = $child;
            }
            // 只添加有children的菜单
            if (count($item['children']) > 0)
                $menuArr[] = $item;
        }
        
        return $menuArr;
    }
}
