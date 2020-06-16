<?php

namespace common\helpers;

/**
 *  移动联通电信手机号校验
移动号段：【目前19种】
　　　　　  134 135 136 137 138 139
　　　　　　150 151 152 157 158 159
　　　　　　147 178　　 182 183 184 187 188
联通号段：【目前11种】
　　　　　  130 131 132　　　171 175 176　　185 186 155 156　　145
电信号段：【目前8种】
　　　　　133 153 149    180 181 189    177 173（待放）
 * Class MobileHelper
 * @package common\helpers
 */
class MobileHelper
{
    // 是否移动手机号
    public static function isMobile($mobile){
        $rule = '/^(134|135|136|137|138|139|150|151|152|157|158|159|147|178|182|183|184|187|188)\d{8}$/';
        return !!preg_match($rule, $mobile);
    }

    // 是否联通手机号
    public static function isUnicom($mobile){
        $rule = '/^(130|131|132|171|175|176|185|186|155|156|145)\d{8}$/';
        return !!preg_match($rule, $mobile);
    }

    // 是否联通手机号
    public static function isTelecom($mobile){
        $rule = '/^(133|153|149|180|181|189|177|173)\d{8}$/';
        return !!preg_match($rule, $mobile);
    }
}