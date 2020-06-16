<?php

namespace common\helpers;

class ArrayHelper extends \yii\helpers\ArrayHelper
{
    /**
     * 数组转为字符串，只转换第一维度
     * @param $array
     * @param string $separator
     * @param string $itemSeparator
     * @return string
     */
    public static function arrayToStr($array, $separator=': ', $itemSeparator=', ')
    {
        $str = '';
        foreach ($array as $key => $value) {
            $str .= $key . $separator . $value . $itemSeparator;
        }
        $str = rtrim($str, $itemSeparator);
        return $str;
    }

    /**
     * 返回指定属性的数组，只转换第一维度
     * @param object|array $obj
     * @param string $keyStr 以英文逗号分隔
     * @return array
     */
    public static function asArray($obj, $keyStr)
    {
        $keys = explode(',', preg_replace('/\s/', '', $keyStr));
        $arr = [];
        if (is_array($obj)) {
            foreach ($keys as $key) {
                if (isset($obj[$key])) {
                    $arr[$key] = $obj[$key];
                }
            }
        } else if (is_object($obj)) {
            foreach ($keys as $key) {
                if (isset($obj->$key)) {
                    $arr[$key] = $obj->$key;
                }
            }
        }
        return $arr;
    }

}