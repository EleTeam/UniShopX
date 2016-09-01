<?php
/**
 * ETShop-PHP-Yii2
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
 * This is the model class for table "coupon_item".
 *
 * @property integer $id
 * @property integer $coupon_id
 * @property integer $user_id
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $updated_by
 * @property integer $updated_at
 * @property integer $is_used
 *
 * @property Coupon $coupon
 */
class CouponItem extends ETActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'coupon_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['coupon_id', 'user_id', 'created_by', 'created_at', 'updated_by', 'updated_at', 'is_used'], 'integer'],
            [['coupon_id'], 'exist', 'skipOnError' => true, 'targetClass' => Coupon::className(), 'targetAttribute' => ['coupon_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'coupon_id' => Yii::t('app', 'Coupon ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'is_used' => Yii::t('app', 'Is Used'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoupon()
    {
        return $this->hasOne(Coupon::className(), ['id' => 'coupon_id']);
    }
}
