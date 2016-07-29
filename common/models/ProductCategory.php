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
 * This is the model class for table "product_category".
 *
 * @property integer $id
 * @property string $featured
 * @property string $image
 * @property string $featured_image
 * @property string $image_small
 * @property string $name
 * @property string $parent_id
 * @property integer $sort
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 * @property string $short_description
 * @property string $app_featured_home
 * @property integer $app_featured_home_sort
 * @property string $parent_ids
 * @property string $remarks
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $href
 * @property string $href_target
 * @property string $image_medium
 * @property string $image_large
 * @property integer $status
 *
 * @property Product[] $products
 */
class ProductCategory extends ETActiveRecord
{
    const ROOT_LEVEL_ID = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['id', 'sort', 'created_at', 'created_by', 'updated_at', 'updated_by', 'app_featured_home_sort', 'status'], 'integer'],
            [['featured', 'app_featured_home'], 'string', 'max' => 1],
            [['image', 'featured_image', 'image_small', 'name', 'short_description', 'remarks', 'meta_keywords', 'meta_description', 'href'], 'string', 'max' => 255],
            [['parent_id'], 'string', 'max' => 64],
            [['parent_ids'], 'string', 'max' => 2000],
            [['href_target'], 'string', 'max' => 7],
            [['image_medium', 'image_large'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'featured' => Yii::t('app', 'Featured'),
            'image' => Yii::t('app', 'Image'),
            'featured_image' => Yii::t('app', 'Featured Image'),
            'image_small' => Yii::t('app', 'Image Small'),
            'name' => Yii::t('app', 'Name'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'sort' => Yii::t('app', 'Sort'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'short_description' => Yii::t('app', 'Short Description'),
            'app_featured_home' => Yii::t('app', 'App Featured Home'),
            'app_featured_home_sort' => Yii::t('app', 'App Featured Home Sort'),
            'parent_ids' => Yii::t('app', 'Parent Ids'),
            'remarks' => Yii::t('app', 'Remarks'),
            'meta_keywords' => Yii::t('app', 'Meta Keywords'),
            'meta_description' => Yii::t('app', 'Meta Description'),
            'href' => Yii::t('app', '超链接地址，优先级“高”'),
            'href_target' => Yii::t('app', '超链接打开的目标窗口，新窗口打开，请填写：“_blank”, 目标（_blank、_self、_parent、_top）'),
            'image_medium' => Yii::t('app', 'Image Medium'),
            'image_large' => Yii::t('app', 'Image Large'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['category_id' => 'id']);
    }

    /**
     * 查找第一级分类
     * @param string $fields
     * @param string $orderBy
     * @param int $status
     * @return $this
     */
    public static function findFirstLevels($fields='*', $orderBy='sort asc', $status=1)
    {
        return self::find()
            ->select($fields)
            ->where('parent_id = :parent_id and status = :status',
                [':parent_id' => self::ROOT_LEVEL_ID, ':status' => $status])
            ->orderBy($orderBy);
    }
}
