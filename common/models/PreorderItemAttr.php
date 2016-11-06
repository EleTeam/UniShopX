<?php
/**
 * Shop-PHP-Yii2
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
 * This is the model class for table "preorder_item_attr".
 *
 * @property integer $id
 * @property integer $item_id 来自PreorderItem::$id
 * @property integer $attr_item_id
 * @property integer $attr_item_value_id
 * @property integer $status
 * @property string $attr_item_name
 * @property string $attr_item_print_name
 * @property integer $attr_item_sort
 * @property string $attr_item_value_name
 * @property string $attr_item_value_print_name
 * @property integer $attr_item_value_sort
 * @property string $attr_item_value_price
 * @property integer $attr_item_value_is_standard
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property PreorderItem $item
 */
class PreorderItemAttr extends ETActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'preorder_item_attr';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'attr_item_id', 'attr_item_value_id', 'status', 'attr_item_sort', 'attr_item_value_sort', 'attr_item_value_is_standard'], 'integer'],
            [['attr_item_value_price'], 'number'],
            [['attr_item_name', 'attr_item_print_name', 'attr_item_value_name', 'attr_item_value_print_name'], 'string', 'max' => 20],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => PreorderItem::className(), 'targetAttribute' => ['item_id' => 'id']],
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
            'attr_item_name' => Yii::t('app', 'Attr Item Name'),
            'attr_item_print_name' => Yii::t('app', 'Attr Item Print Name'),
            'attr_item_sort' => Yii::t('app', 'Attr Item Sort'),
            'attr_item_value_name' => Yii::t('app', 'Attr Item Value Name'),
            'attr_item_value_print_name' => Yii::t('app', 'Attr Item Value Print Name'),
            'attr_item_value_sort' => Yii::t('app', 'Attr Item Value Sort'),
            'attr_item_value_price' => Yii::t('app', 'Attr Item Value Price'),
            'attr_item_value_is_standard' => Yii::t('app', 'Attr Item Value Is Standard'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreorderItem()
    {
        return $this->hasOne(PreorderItem::className(), ['id' => 'item_id']);
    }
}
