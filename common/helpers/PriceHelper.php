<?php

namespace common\helpers;

class PriceHelper
{
    // 返回两个小数点的字符串
    public static function format2Decimal($price){
        return number_format($price, 2, '.', '');
    }

    // 返回两个小数点的金额字符串，单位为元
    public static function format2DecimalYuan($price){
        return number_format($price / 100, 2, '.', '');
    }

    // 返回带+-号的两个小数点的金额字符串，单位为元
    public static function format2DecimalSymbolYuan($price){
        if ($price > 0)
            return '+' . static::format2DecimalYuan($price);
        else
            return static::format2DecimalYuan($price);
    }
}