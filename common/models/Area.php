<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2016-08-08
 * @email 908601756@qq.com
 * @copyright Copyright © 2016年 EleTeam
 * @license The MIT License (MIT)
 */

namespace common\models;

use common\components\ETActiveRecord;
use Yii;

/**
 * This is the model class for table "area".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $code
 * @property string $name
 * @property string $simple_name
 * @property string $zip_code
 * @property string $area_number
 * @property integer $level
 * @property string $path_ids
 * @property string $path_names
 * @property string $remarks
 * @property integer $status
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 * @property string $parent_ids
 * @property integer $type
 * @property integer $sort
 * @property integer $shipping_group
 * @property integer $store_id
 *
 * @property Address[] $addresses
 */
class Area extends ETActiveRecord
{
    //shopping_group, 送货组
    const SHIPPING_GROUP_STORE = "1"; //店内消费

    const PROVINCE_PARENT_ID = "1";

    const DEFAULT_AREA_ID = "29722";

    const PREFIX_AREA_ID = "29722";

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'area';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'parent_id', 'level', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'type', 'sort', 'shipping_group', 'store_id'], 'integer'],
            [['code', 'zip_code'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 50],
            [['simple_name'], 'string', 'max' => 30],
            [['area_number'], 'string', 'max' => 10],
            [['path_ids', 'path_names', 'parent_ids'], 'string', 'max' => 2000],
            [['remarks'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'code' => Yii::t('app', 'Code'),
            'name' => Yii::t('app', 'Name'),
            'simple_name' => Yii::t('app', 'Simple Name'),
            'zip_code' => Yii::t('app', 'Zip Code'),
            'area_number' => Yii::t('app', 'Area Number'),
            'level' => Yii::t('app', 'Level'),
            'path_ids' => Yii::t('app', 'Path Ids'),
            'path_names' => Yii::t('app', 'Path Names'),
            'remarks' => Yii::t('app', '备注信息'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'parent_ids' => Yii::t('app', 'Parent Ids'),
            'type' => Yii::t('app', '区域类型'),
            'sort' => Yii::t('app', 'Sort'),
            'shipping_group' => Yii::t('app', '1:店内消费,'),
            'store_id' => Yii::t('app', '店铺id，一个地址属于一个店铺，根据店铺来打印订单'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Address::className(), ['area_id' => 'id']);
    }

    /**
     * 查找一个前缀地域
     * @return null|Area
     */
    public static function findOnePrefixArea()
    {
        return static::findOne(static::PREFIX_AREA_ID);
    }

    public function getChildren()
    {
//        return $this->hasMany(Area::className(), ['parent_id' => 'id']);
        return $this->find()->where('parent_id=:parent_id', [':parent_id'=>$this->id])->all();
    }

    /**
     * 获取级联的地址列表
     * @param $area_id
     * @return null|array  [{area, children}, {area, children}...]
     */
    public static function findChainedAreas($area_id)
    {
        $chainedAreas = [];
        $area = static::findOne($area_id);
        if(!$area || !$area->path_ids){
            return null;
        }

        $area_ids = explode('/', $area->path_ids);
        foreach($area_ids as $id){
            $theArea = static::findOne($id);
            $item = [
                'area' => $theArea,
                'children' => $theArea->children,
            ];
            $chainedAreas[] = $item;
        }

        return $chainedAreas;
    }

    /**
     * 用于简短显示去掉前缀"中国/广东省/"的path_names, 不存在于数据库的字段
     * @return string
     */
    public function getPathNames4Print()
    {
        $path_names_4print = ltrim($this->path_names, '中国/广东省/');
        $path_names_4print =  str_replace('/', '', $path_names_4print);
        return $path_names_4print;

    }

    /**
     * 获得树形结构数组
     *
     * @return array
     */
    public static function findToTree()
    {
        $areas = [];
        $provinces = static::findAll(['parent_id'=>static::PROVINCE_PARENT_ID]);
        foreach($provinces as $province)
        {
            $cities = static::findAll(['parent_id'=>$province->id]);
            $provinceChildren = [];
            foreach($cities as $city){
                $regions = static::findAll(['parent_id'=>$city->id]);
                $cityChildren = [];
                foreach($regions as $region){
                    $cityChildren[$region->id] = ['name'=>$region->name];
                }
                $provinceChildren[$city->id] = ['name'=>$city->name, 'children'=>$cityChildren];
            }
            $areas[$province->id] = ['name'=>$province->name, 'children'=>$provinceChildren];
        }
        return $areas;
    }
}
