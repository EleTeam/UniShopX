<?php

namespace common\helpers;

class ModelHelper extends \yii\helpers\ArrayHelper
{
    /**
     * 返回$model所以字段的firstError
     * @param \yii\base\Model $model
     * @return string
     */
    public static function errorStr($model)
    {
        $errors = $model->getFirstErrors();
        $str = '';
        foreach ($errors as $key => $value) {
            // $str .= $key . ': ' . $value . '<br/>';
            $str .= $value;
        }
        //$str = rtrim($str, '<br/>');
        return $str;
    }

    public static function generateOrderNo()
    {
        return date('ymdHis') . substr(microtime(), 2, 6) . rand(0, 99);
    }
}