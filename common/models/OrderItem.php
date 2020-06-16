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
 * This is the model class for table "order_item".
 *
 * @property integer $id
 * @property integer $order_id
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
 * @property string $price 购买时的最终价格
 * @property string $sku_price ProductSku::$price
 * @property string $subtotal_price
 * @property integer $status
 * @property integer $product_type
 *
 * @property Order $order
 */
class OrderItem extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_item';
    }

    /**
     * {@inheritdoc}
     */
    public static function primaryKey()
    {
        return ['id'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'user_id', 'product_id', 'created_at', 'created_by', 'updated_at', 'count', 'product_type', 'status'], 'integer'],
            [['order_id', 'user_id', 'product_id', 'created_at', 'created_by', 'updated_at', 'count', 'product_type', 'status'], 'integer'],
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
            'id' => 'ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }
}
