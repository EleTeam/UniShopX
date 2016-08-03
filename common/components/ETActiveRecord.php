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

namespace common\components;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * 基类模型
 *  自动设置模型字段, 每个表必须存在这些字段: created_at, updated_at
 *  打印sql: echo $query->createCommand()->getRawSql();
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
        $imageFields = ['app_long_image1', 'app_long_image2', 'app_long_image3', 'app_long_image4',
            'app_long_image5', 'image_small', 'image_medium', 'image_large', 'image', 'featured_image'];
        if($value && in_array($name, $imageFields)) {
            $value = Yii::getAlias('@dataHost') . $value;
        }

        return $value;
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
        return ltrim(Yii::getAlias('@dataHost'), $url);
    }
}
