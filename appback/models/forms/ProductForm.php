<?php

namespace appback\models\forms;

use common\helpers\ModelHelper;
use common\models\BaseModel;
use common\models\ModelException;
use common\models\Product;
use common\models\User;
use yii\base\Exception;
use yii\base\Model;

/**
 * 商品表单
 */
class ProductForm extends Model
{
    // 必须加这些字段，如果继承数据表模型而不加这些字段也不会加载数据
    public $id;  // 无值为创建，有值为更新
    public $name;
    public $count;  // 商品数量
    public $sort;
    public $show_price;  // 原价，只用于展示，不参与逻辑
    public $price;  //销售价
    public $featured_price;  //特价
    public $is_featured;  //是否特价
    public $featured_image;  //特价图片
    public $featured_position;
    public $featured_position_sort;
    public $audit_status;  // 审核状态：consts.AuditStatus
    public $type;  // 商品类型, consts/ProductType
    public $product_status;  //上架/下架

    public function load($data, $formName = null)
    {
        $data['show_price'] = is_numeric($data['show_price']) ? intval($data['show_price'] * 100) : null;
        $data['price'] = is_numeric($data['price']) ? intval($data['price'] * 100) : null;
        $data['featured_price'] = is_numeric($data['featured_price']) ? intval($data['featured_price'] * 100) : null;
        return parent::load($data, $formName);
    }

    /**
     * 没有任何规则的字段不会加载
     */
    public function rules()
    {
        return [
            [['name', 'count', 'sort', 'price'], 'required'],
            [['is_featured', 'audit_status', 'id'], 'safe'],
            [['show_price', 'price', 'featured_price'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => '商品名称',
            'count' => '商品数量',
        ];
    }

    /**
     * 创建/更新商品
     * @throws ModelException
     */
    public function save()
    {
        if (!$this->validate()) {
            throw new ModelException(ModelHelper::errorStr($this));
        }

        $transaction = User::getDb()->beginTransaction(BaseModel::DEFAULT_TRANSACTION_ISOLATION);

        // 创建
        if (!$this->id) {
            $product = new Product();
        }
        // 更新
        else {
            $product = Product::findOne($this->id);
            if (!$product) {
                throw new ModelException('商品不存在');
            }
        }

        $data['name'] = $this->name;
        $product->load($data, '');
//        $product->load($this->toArray(), '');
        var_dump($product->toArray());
        die;
        if (!$product->save()) {
            $transaction->rollBack();
            throw new ModelException(ModelHelper::errorStr($product));
        }
        try {
            $transaction->commit();
        }  catch (Exception $e) {
            $transaction->rollBack();
            throw new ModelException($e->getMessage());
        }
    }
}
