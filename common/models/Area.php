<?php

namespace common\models;

use common\components\ETActiveRecord;
use Yii;

/**
 * This is the model class for table "area".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $code
 * @property string $name
 * @property string $simple_name
 * @property string $zip_code
 * @property string $area_number
 * @property integer $level
 * @property string $path_ids
 * @property string $path_names
 * @property string $remarks
 * @property integer $status
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 * @property string $parent_ids
 * @property integer $type
 * @property integer $sort
 * @property integer $shipping_group
 * @property integer $store_id
 *
 * @property Address[] $addresses
 */
class Area extends ETActiveRecord
{
    //shopping_group, 送货组
    const SHIPPING_GROUP_STORE = "1"; //店内消费

    const PROVINCE_PARENT_ID = "1";

    const DEFAULT_AREA_ID = "29722";

    const PREFIX_AREA_ID = "29722";

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'area';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'parent_id', 'level', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'type', 'sort', 'shipping_group', 'store_id'], 'integer'],
            [['code', 'zip_code'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 50],
            [['simple_name'], 'string', 'max' => 30],
            [['area_number'], 'string', 'max' => 10],
            [['path_ids', 'path_names', 'parent_ids'], 'string', 'max' => 2000],
            [['remarks'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'code' => Yii::t('app', 'Code'),
            'name' => Yii::t('app', 'Name'),
            'simple_name' => Yii::t('app', 'Simple Name'),
            'zip_code' => Yii::t('app', 'Zip Code'),
            'area_number' => Yii::t('app', 'Area Number'),
            'level' => Yii::t('app', 'Level'),
            'path_ids' => Yii::t('app', 'Path Ids'),
            'path_names' => Yii::t('app', 'Path Names'),
            'remarks' => Yii::t('app', '备注信息'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'parent_ids' => Yii::t('app', 'Parent Ids'),
            'type' => Yii::t('app', '区域类型'),
            'sort' => Yii::t('app', 'Sort'),
            'shipping_group' => Yii::t('app', '1:店内消费,'),
            'store_id' => Yii::t('app', '店铺id，一个地址属于一个店铺，根据店铺来打印订单'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Address::className(), ['area_id' => 'id']);
    }
}
