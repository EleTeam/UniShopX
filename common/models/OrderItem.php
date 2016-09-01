<?php
/**
 * ETShop-PHP-Yii2
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
 * This is the model class for table "order_item".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $preorder_item_id
 * @property integer $cart_item_id
 * @property integer $user_id
 * @property integer $product_id
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property string $update_by
 * @property integer $count
 * @property string $image
 * @property string $featured_image
 * @property string $image_small
 * @property string $name
 * @property string $price
 * @property string $subtotal_price
 * @property integer $type
 * @property integer $status
 *
 * @property Order $order
 * @property OrderItemAttr[] $orderItemAttrs
 */
class OrderItem extends ETActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'preorder_item_id', 'cart_item_id', 'user_id', 'product_id', 'created_at', 'created_by', 'updated_at', 'count', 'type', 'status'], 'integer'],
            [['product_id', 'count', 'name', 'price', 'subtotal_price', 'status'], 'required'],
            [['price', 'subtotal_price'], 'number'],
            [['update_by'], 'string', 'max' => 64],
            [['image', 'image_small', 'name'], 'string', 'max' => 255],
            [['featured_image'], 'string', 'max' => 1],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'order_id' => Yii::t('app', 'Order ID'),
            'preorder_item_id' => Yii::t('app', 'Preorder Item ID'),
            'cart_item_id' => Yii::t('app', 'Cart Item ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'update_by' => Yii::t('app', 'Update By'),
            'count' => Yii::t('app', 'Count'),
            'image' => Yii::t('app', 'Image'),
            'featured_image' => Yii::t('app', 'Featured Image'),
            'image_small' => Yii::t('app', 'Image Small'),
            'name' => Yii::t('app', 'Name'),
            'price' => Yii::t('app', 'Price'),
            'subtotal_price' => Yii::t('app', 'Subtotal Price'),
            'type' => Yii::t('app', 'Type'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItemAttrs()
    {
        return $this->hasMany(OrderItemAttr::className(), ['item_id' => 'id']);
    }
}
