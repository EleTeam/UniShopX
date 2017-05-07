<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2016-09-04
 * @email 908601756@qq.com
 * @copyright Copyright © 2016 EleTeam
 * @license The MIT License (MIT)
 */

namespace common\models;

use Yii;
use common\components\ETActiveRecord;

/**
 * This is the model class for table "banner".
 *
 * @property integer $id
 * @property string $name
 * @property integer $position
 * @property integer $hits
 * @property string $image
 * @property string $text
 * @property string $html
 * @property string $link
 * @property integer $status
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 * @property integer $ended_at
 * @property integer $started_at
 */
class Banner extends ETActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'banner';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['position', 'hits', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'ended_at', 'started_at'], 'integer'],
            [['html'], 'string'],
            [['name'], 'string', 'max' => 100],
            [['image', 'text', 'link'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'name' => Yii::t('app', '广告名称'),
            'position' => Yii::t('app', '广告位置'),
            'hits' => Yii::t('app', '点击数'),
            'image' => Yii::t('app', '图片地址'),
            'text' => Yii::t('app', '文字广告内容'),
            'html' => Yii::t('app', '代码广告内容'),
            'link' => Yii::t('app', '链接地址'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', '开始时间'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'ended_at' => Yii::t('app', '结束时间'),
            'started_at' => Yii::t('app', '开始时间'),
        ];
    }

    /**
     * 获取所有进行中的广告
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function findBanners()
    {
        return self::find()->where('started_at <= :now_time and ended_at >= :now_time and status = :status',
                    [':now_time'=>time(), ':status'=>Banner::STATUS_ACTIVE])
                ->orderBy('position asc')
                ->all();
    }
}
