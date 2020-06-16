<?php
namespace common\consts;

/**
 * 商品类型
 */
class ProductType extends ValueLabel
{
    const UNICOM_RECHARGE       = 10;
    const MOBILE_RECHARGE       = 11;
    const TELECOM_RECHARGE      = 12;

    protected static $_array = [
        self::UNICOM_RECHARGE   => '联通话费充值',
        self::MOBILE_RECHARGE   => '移动话费充值',
        self::TELECOM_RECHARGE  => '电信话费充值',
    ];
}

