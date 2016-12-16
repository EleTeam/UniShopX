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

namespace common\components;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
//use yii\redis\ActiveRecord;

/**
 * 基类模型
 *  自动设置模型字段, 每个表必须存在这些字段: created_at, updated_at
 *  打印sql: echo $query->createCommand()->getRawSql();
 *
 *  注意：
 *      如果用redis，只要不能用orderBy排序，否则会报错：orderBy is currently not supported by redis ActiveRecord.
 *      如下语句会报错：User::find()->where('status = :status', [':status'=>Banner::STATUS_ACTIVE])->orderBy('position asc')->all();
 */
class ETActiveRecord extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE   = 1;
    const STATUS_DELETED  = 2;

    const NO = 0;
    const YES = 1;

    public function __get($name)
    {
        $value = parent::__get($name);

        //图片加上前缀
        $imageFields = ['app_long_image1', 'app_long_image2', 'app_long_image3', 'app_long_image4', 'avatar',
            'app_long_image5', 'image_small', 'image_medium', 'image_large', 'image', 'featured_image'];
        if($value && in_array($name, $imageFields)) {
            $value = Yii::getAlias('@dataHost') . $value;
        }

        return $value;
    }

    /**
     * 保存数据前自动处理
     * @param boolean $insert whether this method called while inserting a record.
     * @return bool
     */
    public function beforeSave($insert)
    {
//        if(parent::beforeSave()){
//            if($this->isNewRecord){
//                $this->create_time = date('y-m-d H:m:s');
//                $this->create_user_id = Yii::app()->user->id;
//                $this->status_id = '0';
//            }else{
//                $this->update_time = date('y-m-d H:m:s');
//                $this->update_user_id = Yii::app()->user->id;
//            }
//            return true;
//        }else{
//            return false;
//        }

        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->created_by = Yii::$app->user->id;
                $this->updated_by = Yii::$app->user->id;
                $this->status = self::STATUS_ACTIVE;
            }else{
                $this->updated_by = Yii::$app->user->id;
            }

            //图片保存去掉本网站前缀
            $attrs = $this->getAttributes();
            $imageFields = ['app_long_image1', 'app_long_image2', 'app_long_image3', 'app_long_image4', 'avatar',
                'app_long_image5', 'image_small', 'image_medium', 'image_large', 'image', 'featured_image'];
            foreach($attrs as $key => $value){
                if($value && in_array($key, $imageFields)) {
                    $value = str_replace(Yii::getAlias('@dataHost'), '', $value);
                    $this->$key = $value;
                }
            }

            return true;
        }else{
            return false;
        }
    }

    /**
     * 自动设置模型字段, 每个表必须存在这些字段: created_at, updated_at
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * 获取一个激活的记录对象
     * @param $condition 底层findOne($condition)的参数
     * @return static|null static instance matching the condition, or `null` if nothing matches.
     */
    public static function findOneActive($condition)
    {
        $record = self::findOne($condition);
        if($record && $record->status == self::STATUS_ACTIVE) {
            return $record;
        }
        return null;
    }

    /**
     * 转换模型的错误信息数组为字符串
     * @return string
     */
    public function errorsToString()
    {
        $errors = [];
        foreach($this->errors as $attribute => $msgs){
            $msg = '';
            foreach($msgs as $msg){
                $msg .= ',';
            }
            $errors[] = $attribute . ': ' . trim($msg, ',');
        }
        return implode('; ', $errors);
    }

    /**
     * 转换模型的错误信息数组为字符串, 只取最前面的一个
     * @return string
     */
    public function errorsToOneString()
    {
        foreach($this->errors as $attribute => $msgs){
            foreach($msgs as $msg){
                return $msg;
            }
        }
        return '';
    }

    /**
     * 软删除
     * @param $id
     * @param $user_id
     * @return int 被删除的行数
     */
    public static function deleteBy($id, $user_id)
    {
        $rows = 0;
        if($user_id){
            $rows = static::updateAll(['status'=>static::STATUS_DELETED],
                'id=:id and user_id=:user_id',
                ['id'=>$id, 'user_id'=>$user_id]);
        }
        return $rows;
    }

    /**
     * 去除前缀为数据服务器的域名, 通常用在保存图片地址上
     * @param $url
     * @return string
     */
    public static function trimDataHost($url)
    {
        $url = ltrim($url, Yii::getAlias('@dataHost'));
        $url = ltrim($url, '/');
        if($url)
            $url = '/' . $url;
        return $url;
    }
}
