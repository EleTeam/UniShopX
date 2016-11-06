<?php
/**
 * Shop-PHP-Yii2
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
 * This is the model class for table "cart_item_attr".
 *
 * @property integer $id
 * @property integer $item_id 来自CartItem::$id
 * @property integer $attr_item_id 来自ProductAttrItem::$id
 * @property integer $attr_item_value_id 来自ProductAttrItemValue::$id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property ProductAttrItem $attrItem
 * @property ProductAttrItemValue $attrItemValue
 * @property CartItem $item
 */
class CartItemAttr extends ETActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cart_item_attr';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'attr_item_id', 'attr_item_value_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['attr_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductAttrItem::className(), 'targetAttribute' => ['attr_item_id' => 'id']],
            [['attr_item_value_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductAttrItemValue::className(), 'targetAttribute' => ['attr_item_value_id' => 'id']],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => CartItem::className(), 'targetAttribute' => ['item_id' => 'id']],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
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
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttrItem()
    {
        return $this->hasOne(ProductAttrItem::className(), ['id' => 'attr_item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttrItemValue()
    {
        return $this->hasOne(ProductAttrItemValue::className(), ['id' => 'attr_item_value_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(CartItem::className(), ['id' => 'item_id']);
    }
}
