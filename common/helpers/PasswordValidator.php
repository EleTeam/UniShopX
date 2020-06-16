<?php
namespace common\helpers;

use yii\validators\StringValidator;
use yii\validators\Validator;

/**
 * 密码规则验证器
 * 由数字和字母组成，并且要同时含有数字和字母，且长度要在6-16位之间。
拆分需求如下：
1，不能全部为数字
2，不能全部为字母
3，必须是数字或字母
只要能同时满足上面3个要求就可以了， 写出了如下：
^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,16}$

分开注释一下：
^ 匹配一行的开头位置
(?![0-9]+$) 预测该位置后面不全是数字
(?![a-zA-Z]+$) 预测该位置后台不全是字母
[0-9A-Za-z]{8-16} 由8-16位数字和字母组成
$ 匹配行结尾位置
注：(?!xxxx)是正则表达式的负向零宽断言一种形式，标识该位置后不全是xxxx字符
 *
 * @package common\helpers
 */
class PasswordValidator extends Validator
{
    protected function validateValue($value) {
        $rule = '/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,16}$/';
        if (!preg_match($rule, $value)) {
            return ['密码必须由字母和数字组成，长度为6-16位', []];
        }

        return null; // 验证通过
    }
}