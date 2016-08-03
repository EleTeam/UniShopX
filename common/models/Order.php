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
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $status
 * @property integer $updated_at
 * @property integer $updated_by
 * @property string $address_detail
 * @property string $address_fullname
 * @property string $address_telephone
 * @property integer $area_id
 * @property string $area_name
 * @property integer $area_parent_id
 * @property string $area_path_ids
 * @property string $area_path_names
 * @property string $area_simple_name
 * @property string $area_zip_code
 * @property integer $cart_id
 * @property integer $cookie_id
 * @property integer $ip
 * @property integer $preorder_id
 * @property string $serial_no
 * @property integer $user_id
 * @property string $total_price  订单最后价格
 * @property integer $total_count
 * @property integer $print_count
 * @property string $coupon_item_id  用户代金券id, CouponItem::$id
 * @property string $coupon_item_total_price  用户代金券总额, CouponItem::$total_price
 * @property string $origin_total_price  订单未减去优惠(如代金券)的价格
 * @property string $address_id
 * @property integer $is_paid
 * @property integer $pay_type
 * @property string $notice
 * @property string $rough_pay_type
 * @property string $status_id
 * @property string $op_transaction_id
 * @property string $status_union
 * @property string $min_total_price_label
 * @property string $paid_date
 * @property integer $store_id
 *
 * @property OrderItem[] $orderItems
 * @property OrderStatus[] $orderStatuses
 */
class Order extends ETActiveRecord
{
    //支付类型
    const PAY_TYPE_CASH = 1;     //现金支付
    const PAY_TYPE_WX = 2;       //微信支付
    const PAY_TYPE_ALIPAY = 3;   //支付宝

    //粗略的支付类型, 区分现金支付还是在线支付, 用户展示订单状态步骤, 查看对象: OrderStatus/OrderStatusProcess
    const ROUGH_PAY_TYPE_CASH = "1";     //现金支付
    const ROUGH_PAY_TYPE_OP = "2";       //在线支付

    //最小送货金额
    // 送货要求：1，只有商品总额(不是订单总额)大于该值才送货；2，店内消费没这个要求
    const MIN_PRODUCT_AMOUNT_FOR_SHIPPING = 15;

    //最少支付金额为1元
    const MIN_TOTAL_PRICE = 1;
    const MIN_TOTAL_PRICE_LABEL = "APP要求最少支付金额为￥1.00元";

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'created_by', 'status', 'updated_at', 'updated_by', 'area_id', 'area_parent_id', 'cart_id', 'cookie_id', 'ip', 'preorder_id', 'user_id', 'total_count', 'print_count', 'is_paid', 'pay_type', 'store_id'], 'integer'],
            [['status', 'address_fullname', 'address_telephone', 'area_id', 'area_name', 'area_parent_id', 'area_path_ids', 'area_path_names', 'total_price', 'total_count'], 'required'],
            [['total_price', 'coupon_item_total_price', 'origin_total_price'], 'number'],
            [['paid_date'], 'safe'],
            [['address_detail', 'address_fullname', 'address_telephone', 'area_name', 'area_path_ids', 'area_path_names', 'area_simple_name', 'area_zip_code', 'serial_no', 'status_union'], 'string', 'max' => 255],
            [['coupon_item_id', 'address_id', 'status_id', 'op_transaction_id'], 'string', 'max' => 64],
            [['notice'], 'string', 'max' => 1000],
            [['rough_pay_type'], 'string', 'max' => 1],
            [['min_total_price_label'], 'string', 'max' => 50],
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
            'address_detail' => Yii::t('app', 'Address Detail'),
            'address_fullname' => Yii::t('app', 'Address Fullname'),
            'address_telephone' => Yii::t('app', 'Address Telephone'),
            'area_id' => Yii::t('app', 'Area ID'),
            'area_name' => Yii::t('app', 'Area Name'),
            'area_parent_id' => Yii::t('app', 'Area Parent ID'),
            'area_path_ids' => Yii::t('app', 'Area Path Ids'),
            'area_path_names' => Yii::t('app', 'Area Path Names'),
            'area_simple_name' => Yii::t('app', 'Area Simple Name'),
            'area_zip_code' => Yii::t('app', 'Area Zip Code'),
            'cart_id' => Yii::t('app', 'Cart ID'),
            'cookie_id' => Yii::t('app', 'Cookie ID'),
            'ip' => Yii::t('app', 'Ip'),
            'preorder_id' => Yii::t('app', 'Preorder ID'),
            'serial_no' => Yii::t('app', 'Serial No'),
            'user_id' => Yii::t('app', 'User ID'),
            'total_price' => Yii::t('app', 'Total Price'),
            'total_count' => Yii::t('app', 'Total Count'),
            'print_count' => Yii::t('app', 'Print Count'),
            'coupon_item_id' => Yii::t('app', 'Coupon Item ID'),
            'coupon_item_total_price' => Yii::t('app', 'Coupon Item Total Price'),
            'origin_total_price' => Yii::t('app', 'Origin Total Price'),
            'address_id' => Yii::t('app', 'Address ID'),
            'is_paid' => Yii::t('app', 'Is Paid'),
            'pay_type' => Yii::t('app', 'Pay Type'),
            'notice' => Yii::t('app', 'Notice'),
            'rough_pay_type' => Yii::t('app', 'Rough Pay Type'),
            'status_id' => Yii::t('app', 'Status ID'),
            'op_transaction_id' => Yii::t('app', 'Op Transaction ID'),
            'status_union' => Yii::t('app', 'Status Union'),
            'min_total_price_label' => Yii::t('app', 'Min Total Price Label'),
            'paid_date' => Yii::t('app', 'Paid Date'),
            'store_id' => Yii::t('app', 'Store ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderStatuses()
    {
        return $this->hasMany(OrderStatus::className(), ['order_id' => 'id']);
    }

    public static function payTypeToRough($pay_type)
    {
        switch($pay_type){
            case self::PAY_TYPE_CASH:
                return self::ROUGH_PAY_TYPE_CASH;
            default:
                return self::ROUGH_PAY_TYPE_OP;
        }
    }
}
