<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cms_article".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $title
 * @property string $link
 * @property string $color
 * @property string $image
 * @property string $keywords
 * @property string $description
 * @property integer $weight
 * @property string $weight_date
 * @property integer $hits
 * @property string $posid
 * @property string $custom_content_view
 * @property string $view_config
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $updated_by
 * @property integer $updated_at
 * @property string $remarks
 * @property integer $status
 *
 * @property CmsCategory $category
 * @property CmsComment[] $cmsComments
 */
class CmsArticle extends \common\components\ETActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'weight', 'hits', 'created_by', 'created_at', 'updated_by', 'updated_at', 'status'], 'integer'],
            [['weight_date'], 'safe'],
            [['view_config'], 'string'],
            [['title', 'link', 'image', 'keywords', 'description', 'custom_content_view', 'remarks'], 'string', 'max' => 255],
            [['color'], 'string', 'max' => 50],
            [['posid'], 'string', 'max' => 10],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => CmsCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_id' => Yii::t('app', '分类编号'),
            'title' => Yii::t('app', '标题'),
            'link' => Yii::t('app', '文章链接'),
            'color' => Yii::t('app', '标题颜色'),
            'image' => Yii::t('app', '文章图片'),
            'keywords' => Yii::t('app', '关键字'),
            'description' => Yii::t('app', '描述、摘要'),
            'weight' => Yii::t('app', '权重，越大越靠前'),
            'weight_date' => Yii::t('app', '权重期限'),
            'hits' => Yii::t('app', '点击数'),
            'posid' => Yii::t('app', '推荐位，多选'),
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
    public function getCategory()
    {
        return $this->hasOne(CmsCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsComments()
    {
        return $this->hasMany(CmsComment::className(), ['article_id' => 'id']);
    }
}
