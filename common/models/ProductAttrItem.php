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
 * This is the model class for table "product_attr_item".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $status
 * @property integer $sort
 * @property integer $updated_at
 * @property integer $updated_by
 * @property string $name
 * @property string $remarks
 * @property string $print_name
 *
 * @property ProductAttr[] $productAttrs
 * @property Product[] $products
 * @property ProductAttrItemValue[] $productAttrItemValues
 */
class ProductAttrItem extends ETActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_attr_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'created_by', 'status', 'sort', 'updated_at', 'updated_by'], 'integer'],
            [['status', 'sort', 'name'], 'required'],
            [['name', 'remarks'], 'string', 'max' => 255],
            [['print_name'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'status' => Yii::t('app', 'Status'),
            'sort' => Yii::t('app', 'Sort'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'name' => Yii::t('app', 'Name'),
            'remarks' => Yii::t('app', 'Remarks'),
            'print_name' => Yii::t('app', 'Print Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductAttrs()
    {
        return $this->hasMany(ProductAttr::className(), ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])->viaTable('product_attr', ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductAttrItemValues()
    {
        return $this->hasMany(ProductAttrItemValue::className(), ['item_id' => 'id']);
    }
}
