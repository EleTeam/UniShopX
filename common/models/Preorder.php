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
 * This is the model class for table "preorder".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $status
 * @property integer $updated_at
 * @property integer $updated_by
 * @property integer $ip
 * @property integer $user_id
 * @property integer $cart_id
 * @property string $cookie_id
 * @property integer $total_count
 * @property string $total_price
 * @property integer $is_ordered
 * @property integer $coupon_item_id
 * @property string $coupon_item_total_price
 * @property string $origin_total_price
 * @property integer $area_id
 * @property string $area_name
 * @property integer $area_parent_id
 * @property string $area_path_ids
 * @property string $area_path_names
 * @property string $area_simple_name
 * @property string $area_zip_code
 * @property string $address_fullname
 * @property string $address_telephone
 * @property string $address_detail
 * @property integer $address_id
 * @property integer $pay_type @see Order::$pay_type
 * @property integer $product_type
 * @property integer $rough_pay_type @see Order::$rough_pay_type
 * @property string $min_total_price_label
 * @property integer $store_id
 *
 * @property PreorderItem[] $preorderItems
 */
class Preorder extends ETActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'preorder';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'created_by', 'status', 'updated_at', 'updated_by', 'ip', 'user_id', 'cart_id', 'total_count', 'is_ordered', 'coupon_item_id', 'area_id', 'area_parent_id', 'address_id', 'pay_type', 'product_type', 'rough_pay_type', 'store_id'], 'integer'],
            [['total_count', 'total_price'], 'required'],
            [['total_price', 'coupon_item_total_price', 'origin_total_price'], 'number'],
            [['cookie_id'], 'string', 'max' => 64],
            [['area_name', 'area_simple_name', 'min_total_price_label'], 'string', 'max' => 50],
            [['area_path_ids', 'area_path_names', 'address_fullname', 'address_detail'], 'string', 'max' => 255],
            [['area_zip_code'], 'string', 'max' => 10],
            [['address_telephone'], 'string', 'max' => 11],
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
            'ip' => Yii::t('app', 'Ip'),
            'user_id' => Yii::t('app', 'User ID'),
            'cart_id' => Yii::t('app', 'Cart ID'),
            'cookie_id' => Yii::t('app', 'Cookie ID'),
            'total_count' => Yii::t('app', 'Total Count'),
            'total_price' => Yii::t('app', 'Total Price'),
            'is_ordered' => Yii::t('app', 'Is Ordered'),
            'coupon_item_id' => Yii::t('app', 'Coupon Item ID'),
            'coupon_item_total_price' => Yii::t('app', 'Coupon Item Total Price'),
            'origin_total_price' => Yii::t('app', 'Origin Total Price'),
            'area_id' => Yii::t('app', 'Area ID'),
            'area_name' => Yii::t('app', 'Area Name'),
            'area_parent_id' => Yii::t('app', 'Area Parent ID'),
            'area_path_ids' => Yii::t('app', 'Area Path Ids'),
            'area_path_names' => Yii::t('app', 'Area Path Names'),
            'area_simple_name' => Yii::t('app', 'Area Simple Name'),
            'area_zip_code' => Yii::t('app', 'Area Zip Code'),
            'address_fullname' => Yii::t('app', 'Address Fullname'),
            'address_telephone' => Yii::t('app', 'Address Telephone'),
            'address_detail' => Yii::t('app', 'Address Detail'),
            'address_id' => Yii::t('app', 'Address ID'),
            'pay_type' => Yii::t('app', 'Pay Type'),
            'product_type' => Yii::t('app', 'Product Type'),
            'rough_pay_type' => Yii::t('app', 'Rough Pay Type'),
            'min_total_price_label' => Yii::t('app', 'Min Total Price Label'),
            'store_id' => Yii::t('app', 'Store ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreorderItems()
    {
        return $this->hasMany(PreorderItem::className(), ['preorder_id' => 'id']);
    }
}
