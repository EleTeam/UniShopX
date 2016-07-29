<?php
/**
 * ETShop-for-PHP-Yii2
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
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $image
 * @property string $featured_image
 * @property string $image_small
 * @property string $name
 * @property integer $sort
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 * @property string $price
 * @property string $featured_price
 * @property string $featured_position
 * @property integer $featured_position_sort
 * @property string $app_featured_home
 * @property integer $app_featured_home_sort
 * @property string $app_featured_image
 * @property string $short_description
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $is_audit
 * @property string $remarks
 * @property string $featured
 * @property string $description
 * @property string $image_medium
 * @property string $image_large
 * @property string $app_featured_topic
 * @property integer $app_featured_topic_sort
 * @property string $app_long_image1
 * @property string $app_long_image2
 * @property string $app_long_image3
 * @property string $app_long_image4
 * @property string $app_long_image5
 * @property string $type
 * @property integer $status
 *
 * @property ProductCategory $category
 * @property ProductAttr[] $productAttrs
 * @property ProductAttrItem[] $items
 */
class Product extends ETActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'category_id', 'sort', 'created_at', 'created_by', 'updated_at', 'updated_by', 'featured_position_sort', 'app_featured_home_sort', 'app_featured_topic_sort', 'status'], 'integer'],
            [['price', 'featured_price'], 'number'],
            [['description'], 'string'],
            [['image', 'featured_image', 'image_small', 'name', 'featured_position', 'app_featured_image', 'short_description', 'meta_keywords', 'meta_description', 'remarks', 'app_long_image4', 'app_long_image5'], 'string', 'max' => 255],
            [['app_featured_home', 'is_audit', 'featured', 'app_featured_topic', 'type'], 'string', 'max' => 1],
            [['image_medium', 'image_large', 'app_long_image1', 'app_long_image2', 'app_long_image3'], 'string', 'max' => 1000],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'image' => Yii::t('app', 'Image'),
            'featured_image' => Yii::t('app', 'Featured Image'),
            'image_small' => Yii::t('app', 'Image Small'),
            'name' => Yii::t('app', 'Name'),
            'sort' => Yii::t('app', 'Sort'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'price' => Yii::t('app', 'Price'),
            'featured_price' => Yii::t('app', 'Featured Price'),
            'featured_position' => Yii::t('app', 'Featured Position'),
            'featured_position_sort' => Yii::t('app', 'Featured Position Sort'),
            'app_featured_home' => Yii::t('app', 'App Featured Home'),
            'app_featured_home_sort' => Yii::t('app', 'App Featured Home Sort'),
            'app_featured_image' => Yii::t('app', 'App Featured Image'),
            'short_description' => Yii::t('app', 'Short Description'),
            'meta_keywords' => Yii::t('app', 'Meta Keywords'),
            'meta_description' => Yii::t('app', 'Meta Description'),
            'is_audit' => Yii::t('app', 'Is Audit'),
            'remarks' => Yii::t('app', 'Remarks'),
            'featured' => Yii::t('app', 'Featured'),
            'description' => Yii::t('app', 'Description'),
            'image_medium' => Yii::t('app', 'Image Medium'),
            'image_large' => Yii::t('app', 'Image Large'),
            'app_featured_topic' => Yii::t('app', 'App Featured Topic'),
            'app_featured_topic_sort' => Yii::t('app', 'App Featured Topic Sort'),
            'app_long_image1' => Yii::t('app', 'App Long Image1'),
            'app_long_image2' => Yii::t('app', 'App Long Image2'),
            'app_long_image3' => Yii::t('app', 'App Long Image3'),
            'type' => Yii::t('app', 'Type'),
            'app_long_image4' => Yii::t('app', 'App Long Image4'),
            'app_long_image5' => Yii::t('app', 'App Long Image5'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    public function getAttribute($name)
    {
        $value = parent::getAttribute($name);
        return 'a';
    }

    public function __get($name)
    {
        $value = parent::__get($name);

        //图片加上前缀
        if($name == 'app_long_image1' && $value)
            $value = Yii::getAlias('@imghost') . $value;
        if($name == 'app_long_image2' && $value)
            $value = Yii::getAlias('@imghost') . $value;
        if($name == 'app_long_image3' && $value)
            $value = Yii::getAlias('@imghost') . $value;
        if($name == 'app_long_image4' && $value)
            $value = Yii::getAlias('@imghost') . $value;
        if($name == 'app_long_image5' && $value)
            $value = Yii::getAlias('@imghost') . $value;
        if($name == 'image_small' && $value)
            $value = Yii::getAlias('@imghost') . $value;
        if($name == 'image' && $value)
            $value = Yii::getAlias('@imghost') . $value;

        return $value;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductAttrs()
    {
        return $this->hasMany(ProductAttr::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductAttrItems()
    {
        return $this->hasMany(ProductAttrItem::className(), ['id' => 'item_id'])->viaTable('product_attr', ['product_id' => 'id']);
    }

    public static function listAllByCategoryId($category_id, $fields='*', $orderBy='sort asc', $status=1)
    {
        return self::find()
            ->select($fields)
            ->where('category_id = :category_id and status = :status',
                [':category_id' => $category_id, ':status' => $status])
            ->orderBy($orderBy);
    }

    public function showCurrentPrice()
    {
        if($this->featured_price){
            return $this->featured_price;
        }else{
            return $this->price;
        }
    }
}
