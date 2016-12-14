<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2016-12-08
 * @email 908601756@qq.com
 * @copyright Copyright © 2016年 EleTeam
 * @license The MIT License (MIT)
 */

namespace common\models;

use Yii;
use common\components\ETActiveRecord;

/**
 * This is the model class for table "product_sku".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $spec_ids
 * @property string $spec_value_ids
 * @property string $sku
 * @property string $price
 * @property integer $status
 * @property integer $count
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property ProductSpec[] $productSpec
 * @property ProductSpecValue[] $productSpecValue
 */
class ProductSku extends ETActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_sku';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'sku'], 'required'],
            [['price'], 'number'],
            [['product_id', 'status', 'count', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['spec_ids', 'spec_value_ids', 'sku'], 'string', 'max' => 255],
            [['sku'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'Product Id'),
            'spec_ids' => Yii::t('app', 'Spec Ids'),
            'spec_value_ids' => Yii::t('app', 'Spec Value Ids'),
            'sku' => Yii::t('app', 'Sku'),
            'price' => Yii::t('app', 'Price'),
            'status' => Yii::t('app', 'Status'),
            'count' => Yii::t('app', 'Count'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    public function specIdsToArray()
    {

    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * 获取有序的规格
     *
     * @return array ProductSpec[]
     */
    public function getProductSpecs()
    {
        $specs = [];
        foreach($this->spec_ids as $spec_id){
            $spec = ProductSpec::findOne($spec_id);
            $specs[] = $spec;
        }
        return $specs;
    }

    /**
     * 获取有序的规格值
     *
     * @return array ProductSpecValue[]
     */
    public function getProductSpecValues()
    {
        $specValues = [];
        foreach($this->spec_value_ids as $spec_value_id){
            $specValue = ProductSpecValue::findOne($spec_value_id);
            $specValues[] = $specValue;
        }
        return $specValues;
    }
}
