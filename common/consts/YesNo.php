<?php
namespace common\consts;

/**
 * 是否状态
 */
class YesNo extends ValueLabel
{
    const NO  = 0;
    const YES   = 1;

    protected static $_array = [
        self::NO  => '否',
        self::YES => '是',
    ];
}

