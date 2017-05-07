<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cms_category".
 *
 * @property integer $id
 * @property string $parent_id
 * @property string $parent_ids
 * @property string $site_id
 * @property string $office_id
 * @property string $module
 * @property string $name
 * @property string $image
 * @property string $href
 * @property string $target
 * @property string $description
 * @property string $keywords
 * @property integer $sort
 * @property string $in_menu
 * @property string $in_list
 * @property string $show_modes
 * @property string $allow_comment
 * @property string $custom_list_view
 * @property string $custom_content_view
 * @property string $view_config
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $updated_by
 * @property integer $updated_at
 * @property string $remarks
 * @property integer $status
 *
 * @property CmsArticle[] $cmsArticles
 */
class CmsCategory extends \common\components\ETActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'parent_ids', 'name'], 'required'],
            [['sort', 'created_by', 'created_at', 'updated_by', 'updated_at', 'status'], 'integer'],
            [['view_config'], 'string'],
            [['parent_id', 'site_id', 'office_id'], 'string', 'max' => 64],
            [['parent_ids'], 'string', 'max' => 2000],
            [['module', 'target'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 100],
            [['image', 'href', 'description', 'keywords', 'custom_list_view', 'custom_content_view', 'remarks'], 'string', 'max' => 255],
            [['in_menu', 'in_list', 'show_modes', 'allow_comment'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', '父级编号'),
            'parent_ids' => Yii::t('app', '所有父级编号'),
            'site_id' => Yii::t('app', '站点编号'),
            'office_id' => Yii::t('app', '归属机构'),
            'module' => Yii::t('app', '栏目模块'),
            'name' => Yii::t('app', '栏目名称'),
            'image' => Yii::t('app', '栏目图片'),
            'href' => Yii::t('app', '链接'),
            'target' => Yii::t('app', '目标'),
            'description' => Yii::t('app', '描述'),
            'keywords' => Yii::t('app', '关键字'),
            'sort' => Yii::t('app', '排序（升序）'),
            'in_menu' => Yii::t('app', '是否在导航中显示'),
            'in_list' => Yii::t('app', '是否在分类页中显示列表'),
            'show_modes' => Yii::t('app', '展现方式'),
            'allow_comment' => Yii::t('app', '是否允许评论'),
            'custom_list_view' => Yii::t('app', '自定义列表视图'),
            'custom_content_view' => Yii::t('app', '自定义内容视图'),
            'view_config' => Yii::t('app', '视图配置'),
            'created_by' => Yii::t('app', '创建者'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_by' => Yii::t('app', '更新者'),
            'updated_at' => Yii::t('app', '更新时间'),
            'remarks' => Yii::t('app', '备注信息'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsArticles()
    {
        return $this->hasMany(CmsArticle::className(), ['category_id' => 'id']);
    }
}
