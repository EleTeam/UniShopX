<?php
/**
 * ETShop-for-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2015-05-18
 * @email 908601756@qq.com
 * @copyright Copyright © 2015年 EleTeam
 * @license The MIT License (MIT)
 */

namespace common\models;

use Yii;
use common\components\ETActiveRecord;

/**
 * This is the model class for table "coupon".
 *
 * @property integer $id
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $updated_by
 * @property integer $updated_at
 * @property integer $startd_at
 * @property integer $ended_at
 * @property string $name
 * @property string $desc
 * @property string $price
 * @property integer $type
 * @property string $type_desc
 * @property integer $duration_day
 * @property string $duration_day_desc
 * @property integer $used_type
 * @property string $used_type_desc
 * @property integer $status
 * @property integer $count
 *
 * @property CouponItem[] $couponItems
 */
class Coupon extends ETActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'coupon';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_by', 'created_at', 'updated_by', 'updated_at', 'startd_at', 'ended_at', 'type', 'duration_day', 'used_type', 'status', 'count'], 'integer'],
            [['price'], 'number'],
            [['name'], 'string', 'max' => 100],
            [['desc', 'type_desc', 'duration_day_desc', 'used_type_desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'startd_at' => Yii::t('app', 'Startd At'),
            'ended_at' => Yii::t('app', 'Ended At'),
            'name' => Yii::t('app', 'Name'),
            'desc' => Yii::t('app', 'Desc'),
            'price' => Yii::t('app', 'Price'),
            'type' => Yii::t('app', 'Type'),
            'type_desc' => Yii::t('app', 'Type Desc'),
            'duration_day' => Yii::t('app', 'Duration Day'),
            'duration_day_desc' => Yii::t('app', 'Duration Day Desc'),
            'used_type' => Yii::t('app', 'Used Type'),
            'used_type_desc' => Yii::t('app', 'Used Type Desc'),
            'status' => Yii::t('app', 'Status'),
            'count' => Yii::t('app', 'Count'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCouponItems()
    {
        return $this->hasMany(CouponItem::className(), ['coupon_id' => 'id']);
    }
}
