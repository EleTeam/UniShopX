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

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $image
 * @property string $image_small
 * @property string $image_medium
 * @property string $image_large
 * @property string $name
 * @property integer $sort
 * @property string $description  详细描述
 * @property string $short_description  简短描述
 * @property string $meta_keywords  seo关键字
 * @property string $meta_description  seo关键描述
 * @property integer $price  原价
 * @property string $is_featured  是否特价
 * @property string $featured_price  特价
 * @property string $featured_image  特价图片
 * @property string $featured_position
 * @property integer $featured_position_sort
 * @property string $app_featured_home
 * @property integer $app_featured_home_sort
 * @property string $app_featured_image
 * @property integer $is_audited  是否审核通过，审核通过的产品才能在网站交易
 * @property integer $audited_at
 * @property integer $audited_by
 * @property string $remarks  备注
 * @property integer $type  商品类型
 * @property integer $status  启用禁用
 * @property integer $status_at
 * @property integer $status_by
 * @property integer $created_at
 * @property integer $created_by
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
            [['name', 'price', 'is_audited', 'type', 'status'], 'required'],
            [['id', 'sort', 'created_at', 'created_by', 'updated_at', 'updated_by', 'featured_position_sort', 'app_featured_home_sort', 'app_featured_topic_sort', 'status', 'price', 'featured_price'], 'integer'],
            [['description'], 'string'],
            [['image', 'featured_image', 'image_small', 'name', 'featured_position', 'app_featured_image', 'short_description', 'meta_keywords', 'meta_description', 'remarks'], 'string', 'max' => 255],
            [['image_medium', 'image_large'], 'string', 'max' => 1000],
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
