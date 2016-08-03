<?php

namespace common\models;

use common\components\ETActiveRecord;
use Yii;

/**
 * This is the model class for table "address".
 *
 * @property integer $id
 * @property integer $area_id
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $is_default
 * @property integer $status
 * @property integer $updated_at
 * @property integer $updated_by
 * @property string $detail
 * @property string $fullname
 * @property string $telephone
 * @property string $cookie_id
 *
 * @property Area $area
 */
class Address extends ETActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'area_id', 'user_id', 'created_at', 'created_by', 'is_default', 'status', 'updated_at', 'updated_by'], 'integer'],
            [['detail', 'fullname'], 'string', 'max' => 255],
            [['telephone'], 'string', 'max' => 11],
            [['cookie_id'], 'string', 'max' => 64],
            [['area_id'], 'exist', 'skipOnError' => true, 'targetClass' => Area::className(), 'targetAttribute' => ['area_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'area_id' => Yii::t('app', 'Area ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'is_default' => Yii::t('app', 'Is Default'),
            'status' => Yii::t('app', 'Status'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'detail' => Yii::t('app', 'Detail'),
            'fullname' => Yii::t('app', 'Fullname'),
            'telephone' => Yii::t('app', 'Telephone'),
            'cookie_id' => Yii::t('app', 'Cookie ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArea()
    {
        return $this->hasOne(Area::className(), ['id' => 'area_id']);
    }

    /**
     * 获取默认的地址
     * @param $user_id
     * @return null|static
     */
    public static function findDefault($user_id)
    {
        return static::findOne(['user_id'=>$user_id, 'is_default'=>static::YES, 'status'=>static::YES]);
    }
}
