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

use common\consts\ProductStatus;
use Yii;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $image
 * @property string $image_small
 * @property string $image_medium
 * @property string $image_large
 * @property string $name
 * @property integer $count  商品数量
 * @property integer $sort
 * @property string $description  详细描述
 * @property string $short_description  简短描述
 * @property string $meta_keywords  seo关键字
 * @property string $meta_description  seo关键描述
 * @property integer|null $show_price  原价，只用于展示，不参与逻辑
 * @property integer $price  销售价
 * @property integer|null $featured_price  特价
 * @property integer|null $is_featured  是否特价
 * @property string|null $featured_image  特价图片
 * @property string|null $featured_position
 * @property integer|null $featured_position_sort
 * @property string|null $app_featured_home
 * @property integer|null $app_featured_home_sort
 * @property string|null $app_featured_image
 * @property integer|null $audit_status  审核状态：consts.AuditStatus
 * @property integer|null $audited_at
 * @property integer|null $audited_by
 * @property string|null $remarks  备注
 * @property integer $type  商品类型, consts/ProductType
 * @property integer $product_status  上架/下架
 * @property integer $product_status_at
 * @property integer $product_status_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class Product extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
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
            [['name', 'price', 'audit_status', 'type', 'product_status', 'count'], 'required'],
            [['id', 'sort', 'created_at', 'created_by', 'updated_at', 'updated_by', 'count', 'featured_position_sort', 'app_featured_home_sort', 'product_status', 'price', 'featured_price', 'show_price', 'is_featured'], 'integer'],
            [['description'], 'string'],
            [['image', 'featured_image', 'image_small', 'name', 'featured_position', 'app_featured_image', 'short_description', 'meta_keywords', 'meta_description', 'remarks'], 'string', 'max' => 255],
            [['image_medium', 'image_large'], 'string', 'max' => 1000],
            ['product_status', 'in', 'range' => ProductStatus::values()]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '商品名称'
        ];
    }

}
