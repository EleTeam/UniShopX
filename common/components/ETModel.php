<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2016-11-25
 * @email 908601756@qq.com
 * @copyright Copyright © 2016年 EleTeam
 * @license The MIT License (MIT)
 */

namespace common\components;

use Yii;
use yii\base\Model;

/**
 * 基类模型
 */
class ETModel extends Model
{
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
}
