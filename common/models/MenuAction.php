<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "menu_action".
 *
 * @property int $menu_id from Menu.id
 * @property string $route
 * @property string $name
 * @property int $sort 排序
 */
class MenuAction extends BaseModel
{
    public static function tableName()
    {
        return 'menu_action';
    }

    public function rules()
    {
        return [
            [['menu_id', 'route', 'name'], 'required'],
            [['menu_id', 'sort'], 'integer'],
            [['route', 'name'], 'string', 'max' => 100],
            [['menu_id', 'route'], 'unique', 'targetAttribute' => ['menu_id', 'route']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'menu_id' => 'Menu ID',
            'route' => 'Route',
            'name' => 'Name',
            'sort' => 'Sort',
        ];
    }
}
