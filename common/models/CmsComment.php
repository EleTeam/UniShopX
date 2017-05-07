<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cms_comment".
 *
 * @property integer $id
 * @property integer $article_id
 * @property string $title
 * @property string $content
 * @property string $name
 * @property string $ip
 * @property integer $created_at
 * @property integer $audited_by
 * @property integer $audited_at
 * @property integer $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $updated_at
 * @property integer $user_id
 *
 * @property CmsArticle $article
 */
class CmsComment extends \common\components\ETActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'created_at', 'audited_by', 'audited_at', 'status', 'created_by', 'updated_by', 'updated_at', 'user_id'], 'integer'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['name', 'ip'], 'string', 'max' => 100],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => CmsArticle::className(), 'targetAttribute' => ['article_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'article_id' => Yii::t('app', '栏目内容的编号'),
            'title' => Yii::t('app', '栏目内容的标题'),
            'content' => Yii::t('app', '评论内容'),
            'name' => Yii::t('app', '评论姓名'),
            'ip' => Yii::t('app', '评论IP'),
            'created_at' => Yii::t('app', '评论时间'),
            'audited_by' => Yii::t('app', '审核人'),
            'audited_at' => Yii::t('app', '审核时间'),
            'status' => Yii::t('app', 'Status'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(CmsArticle::className(), ['id' => 'article_id']);
    }
}
