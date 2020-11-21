<?php
namespace common\consts;

/**
 * 是否状态
 */
class YesNo extends ValueLabel
{
    const YES   = 1;
    const NO  = 0;

    protected static $_array = [
        self::YES => '是',
        self::NO  => '否',
    ];
}

