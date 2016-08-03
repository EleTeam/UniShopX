<?php
/**
 * ETShop-for-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2016-08-02
 * @email 908601756@qq.com
 * @copyright Copyright © 2016年 EleTeam
 * @license The MIT License (MIT)
 */

namespace common\models;

use common\components\ETActiveRecord;
use Yii;

/**
 * This is the model class for table "order_item_attr".
 *
 * @property integer $id
 * @property integer $item_id
 * @property integer $attr_item_id
 * @property integer $attr_item_value_id
 * @property string $attr_item_name
 * @property string $attr_item_print_name
 * @property integer $attr_item_sort
 * @property string $attr_item_value_name
 * @property string $attr_item_value_print_name
 * @property integer $attr_item_value_sort
 * @property string $attr_item_value_price
 * @property string $attr_item_value_is_standard
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property OrderItem $item
 */
class OrderItemAttr extends ETActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_item_attr';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'item_id', 'attr_item_id', 'attr_item_value_id', 'attr_item_sort', 'attr_item_value_sort', 'status'], 'integer'],
            [['attr_item_value_price'], 'number'],
            [['attr_item_name', 'attr_item_print_name', 'attr_item_value_name', 'attr_item_value_print_name'], 'string', 'max' => 20],
            [['attr_item_value_is_standard'], 'string', 'max' => 1],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrderItem::className(), 'targetAttribute' => ['item_id' => 'id']],
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
            'attr_item_id' => Yii::t('app', 'Attr Item ID'),
            'attr_item_value_id' => Yii::t('app', 'Attr Item Value ID'),
            'attr_item_name' => Yii::t('app', 'Attr Item Name'),
            'attr_item_print_name' => Yii::t('app', 'Attr Item Print Name'),
            'attr_item_sort' => Yii::t('app', 'Attr Item Sort'),
            'attr_item_value_name' => Yii::t('app', 'Attr Item Value Name'),
            'attr_item_value_print_name' => Yii::t('app', 'Attr Item Value Print Name'),
            'attr_item_value_sort' => Yii::t('app', 'Attr Item Value Sort'),
            'attr_item_value_price' => Yii::t('app', 'Attr Item Value Price'),
            'attr_item_value_is_standard' => Yii::t('app', 'Attr Item Value Is Standard'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(OrderItem::className(), ['id' => 'item_id']);
    }
}
