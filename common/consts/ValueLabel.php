<?php

namespace common\consts;

/**
 * value=>label的映射对象的基类
 */
abstract class ValueLabel
{
    protected static $_array = [];

    public static function label($value)
    {
        if (isset(static::$_array[$value])) {
            return static::$_array[$value];
        } else {
            return '未定义';
        }
    }

    public static function toArray()
    {
        return static::$_array;
    }

    public static function values()
    {
        return array_keys(static::$_array);
    }
}