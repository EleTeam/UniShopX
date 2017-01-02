<?php
/**
 * Shop-PHP-Yii2
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
 * This is the model class for table "cart_item".
 *
 * @property integer $id
 * @property integer $cart_id
 * @property integer $product_id
 * @property integer $sku_id
 *
 * 以下两个字段与Cart::$user_id/Cart::$app_cart_cookie_id共同存在是需要的, 为的是方便获取和更高效更新CartItem对象
 * @property integer $user_id
 * @property string $app_cart_cookie_id
 *
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $status
 * @property integer $updated_at
 * @property integer $updated_by
 * @property integer $count
 * @property integer $is_ordered
 * @property integer $is_selected
 * @property integer $cookie_id
 *
 * @property Cart $cart
 * @property Product $product
 * @property CartItemAttrs[] $cartItemAttrs
 */
class CartItem extends ETActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cart_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cart_id', 'product_id', 'sku_id', 'user_id', 'created_at', 'created_by', 'status', 'updated_at', 'updated_by', 'count', 'is_ordered', 'is_selected', 'cookie_id'], 'integer'],
            [['app_cart_cookie_id'], 'string'],
            [['cart_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cart::className(), 'targetAttribute' => ['cart_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            ['is_ordered', 'default', 'value' => self::NO],
            ['is_selected', 'default', 'value' => self::YES],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cart_id' => Yii::t('app', 'Cart ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'status' => Yii::t('app', 'Status'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'count' => Yii::t('app', 'Count'),
            'is_ordered' => Yii::t('app', 'Is Ordered'),
            'is_selected' => Yii::t('app', 'Is Selected'),
            'cookie_id' => Yii::t('app', 'Cookie ID'),
            'app_cart_cookie_id' => Yii::t('app', 'App Cart Cookie ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCart()
    {
        return $this->hasOne(Cart::className(), ['id' => 'cart_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCartItemAttrs()
    {
        return $this->hasMany(CartItemAttr::className(), ['item_id' => 'id']);
    }

    /**
     * 获得购物车唯一的产品, 如某个购物车的某个商品带着某些属性
     * @param $cart_id
     * @param $product_id
     * @param $attrs 的格式 [$item_id=>$value_id, 1=>2, ...]
     * @return CartItem|null
     * @deprecated 用sku定义不同的商品, 而不是属性
     */
    public static function findOneByCartIdProductIdAttrs($cart_id, $product_id, array $attrs)
    {
        $cartItems = static::find()->where(['cart_id'=>$cart_id, 'product_id'=>$product_id])->all();

        //对应产品属性的产品是否添加到购物车?
        foreach($cartItems as $cartItem){
            $cartItemAttrs = CartItemAttr::find()->where(['item_id'=>$cartItem->id])->all();

            //属性个数和值都相等，则是已经添加的商品
            $isAttrsExist = true;
            foreach ($cartItemAttrs as $cartItemAttr) {
                if(!isset($attrs[$cartItemAttr->attr_item_id])
                    || $attrs[$cartItemAttr->attr_item_id] != $cartItemAttr->attr_item_value_id){
                    $isAttrsExist = false;
                }
            }
            if($isAttrsExist && count($attrs) == count($cartItemAttrs)){
                return $cartItem;
            }
        }

        return null;
    }

    /**
     * 获得购物车唯一的产品, 如某个购物车的某个商品带着某些属性
     * @param $cart_id
     * @param $sku_id
     * @return CartItem|null
     */
    public static function findOneBy($cart_id, $sku_id)
    {
        $cartItem = self::find()
            ->where(['cart_id'=>$cart_id, 'sku_id'=>$sku_id, 'status'=>self::STATUS_ACTIVE])
            ->one();
        return $cartItem;
    }

    /**
     * 硬删除, 不能用软删除, 因为通过关联获取的时候, 会把关联的所有都包含进来, 如 $items = $preorder->preorderItems;
     * @param $id
     * @param $user_id
     * @param $app_cart_cookie_id
     * @return int 被删除的行数
     */
    public static function deleteByMore($id, $user_id, $app_cart_cookie_id)
    {
        //硬删除
        $rows = 0;
        $item = static::findOne($id);
        if($user_id && $item && $item->user_id == $user_id){
            $rows = $item->delete();
        }elseif($app_cart_cookie_id && $item && $item->app_cart_cookie_id == $app_cart_cookie_id){
            $rows = $item->delete();
        }


        //软删除
//        $rows = 0;
//        if($user_id){
//            $rows = static::deleteBy($id, $user_id);
//        }elseif($app_cart_cookie_id){
//            $rows = static::updateAll(['status'=>static::STATUS_DELETED],
//                'id=:id and app_cart_cookie_id=:app_cart_cookie_id',
//                ['id'=>$id, 'app_cart_cookie_id'=>$app_cart_cookie_id]);
//        }

        return $rows;
    }

    /**
     * 获取购物车项
     *      foreach 时用 $cartItem->product, $cartItem->cartItemAttrs获取相应的关联对象
     * @param $user_id
     * @param int $is_selected
     * @return array|null|\yii\db\ActiveRecord[]
     */
    public static function findByUserId($user_id, $is_selected=1)
    {
        if(!$user_id)
            return null;
        $cartItems = static::find()->where(['user_id'=>$user_id, 'is_selected'=>$is_selected])->all();
        return $cartItems;
    }
}
