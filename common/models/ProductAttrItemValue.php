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
 * This is the model class for table "product_attr_item_value".
 *
 * @property integer $id
 * @property integer $item_id
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $status
 * @property integer $sort
 * @property integer $updated_at
 * @property integer $updated_by
 * @property string $name
 * @property string $price
 * @property string $remarks
 * @property string $print_name
 * @property string $is_standard
 *
 * @property ProductAttrItem $item
 */
class ProductAttrItemValue extends ETActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_attr_item_value';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'created_at', 'created_by', 'status', 'sort', 'updated_at', 'updated_by'], 'integer'],
            [['sort', 'name'], 'required'],
            [['price'], 'number'],
            [['name', 'remarks'], 'string', 'max' => 255],
            [['print_name'], 'string', 'max' => 20],
            [['is_standard'], 'string', 'max' => 1],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductAttrItem::className(), 'targetAttribute' => ['item_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'item_id' => Yii::t('app', 'Item ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'status' => Yii::t('app', 'Status'),
            'sort' => Yii::t('app', 'Sort'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'name' => Yii::t('app', 'Name'),
            'price' => Yii::t('app', 'Price'),
            'remarks' => Yii::t('app', 'Remarks'),
            'print_name' => Yii::t('app', 'Print Name'),
            'is_standard' => Yii::t('app', '是否标准的属性值，如果是则在前台不打印出来'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductAttrItem()
    {
        return $this->hasOne(ProductAttrItem::className(), ['id' => 'item_id']);
    }
}
