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
 * This is the model class for table "order".
 *
 * @property integer $order_no  订单号主键，用这种方式便于分表
 * @property integer $order_status
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
 * @property string $serial_no
 * @property integer $fuser_id
 * @property string $total_price  订单最后价格
 * @property integer $total_count
 * @property integer $print_count
 * @property string $coupon_item_id  用户代金券id, CouponItem::$id
 * @property string $coupon_item_total_price  用户代金券总额, CouponItem::$total_price
 * @property string $origin_total_price  订单未减去优惠(如代金券, 积分抵扣, 节日立减等)的价格
 * @property integer $address_id
 * @property integer $is_paid
 * @property integer $pay_type
 * @property string $notice
 * @property string $rough_pay_type
 * @property string $status_id
 * @property string $status_union
 * @property string $min_total_price_label
 * @property string $paid_date
 * @property integer $store_id
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property OrderItem[] $orderItems
 */
class Order extends BaseModel
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
     * {@inheritdoc}
     */
    public static function primaryKey()
    {
        return ['order_no'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_no', 'created_at', 'created_by', 'order_status', 'updated_at', 'updated_by', 'user_id', 'total_count', 'is_paid', 'pay_type'], 'required'],
            [['created_at', 'created_by', 'order_status', 'updated_at', 'updated_by', 'user_id', 'total_count', 'is_paid', 'pay_type'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_no' => '订单号'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['order_id' => 'id']);
    }

    public static function genSerialNum()
    {
        return date('YmdHis') . Util::millisecond() . rand(100,999);
    }
}
