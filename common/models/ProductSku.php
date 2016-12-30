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
 * @property string $spec_ids  如: _1_2_  ,$spec_ids与$spec_value_ids一一对应
 * @property string $spec_value_ids  如: _3_4_
 * @property string $price
 * @property integer $status
 * @property integer $count
 * * @property integer $code
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property ProductSpec[] $productSpecs 根据$spec_ids获得, $productSpecs与$productSpecValues一一对应
 * @property ProductSpecValue[] $productSpecValues 根据$spec_value_ids获得
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
            [['product_id', 'code'], 'required'],
            [['price'], 'number'],
            [['product_id', 'status', 'count', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['spec_ids', 'spec_value_ids', 'code'], 'string', 'max' => 255],
            [['code'], 'unique'],
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
            'code' => Yii::t('app', 'SKU Code'),
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
        $spec_ids = explode('_', trim($this->spec_ids, '_'));
        $specs = [];
        foreach($spec_ids as $spec_id){
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
        $spec_value_ids = explode('_', trim($this->spec_value_ids, '_'));
        $specValues = [];
        foreach($spec_value_ids as $spec_value_id){
            $specValue = ProductSpecValue::findOne($spec_value_id);
            $specValues[] = $specValue;
        }
        return $specValues;
    }
}
