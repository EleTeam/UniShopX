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

use Yii;

/**
 * This is the model class for table "preorder_item".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $status
 * @property integer $updated_at
 * @property integer $updated_by
 * @property integer $count
 * @property string $image
 * @property string $image_small
 * @property string $featured_image
 * @property string $name
 * @property string $price
 * @property integer $product_id
 * @property integer $cart_item_id
 * @property integer $preorder_id
 * @property string $subtotal_price
 *
 * @property Preorder $preorder
 * @property PreorderItemAttr[] $preorderItemAttrs
 */
class PreorderItem extends \common\components\ETActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'preorder_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'created_by', 'status', 'updated_at', 'updated_by', 'count', 'product_id', 'cart_item_id', 'preorder_id'], 'integer'],
            [['count', 'name', 'price', 'product_id', 'subtotal_price'], 'required'],
            [['price', 'subtotal_price'], 'number'],
            [['image', 'image_small', 'featured_image', 'name'], 'string', 'max' => 255],
            [['preorder_id'], 'exist', 'skipOnError' => true, 'targetClass' => Preorder::className(), 'targetAttribute' => ['preorder_id' => 'id']],
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
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'count' => Yii::t('app', 'Count'),
            'image' => Yii::t('app', 'Image'),
            'image_small' => Yii::t('app', 'Image Small'),
            'featured_image' => Yii::t('app', 'Featured Image'),
            'name' => Yii::t('app', 'Name'),
            'price' => Yii::t('app', 'Price'),
            'product_id' => Yii::t('app', 'Product ID'),
            'cart_item_id' => Yii::t('app', 'Cart Item ID'),
            'preorder_id' => Yii::t('app', 'Preorder ID'),
            'subtotal_price' => Yii::t('app', 'Subtotal Price'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreorder()
    {
        return $this->hasOne(Preorder::className(), ['id' => 'preorder_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreorderItemAttrs()
    {
        return $this->hasMany(PreorderItemAttr::className(), ['item_id' => 'id']);
    }
}
