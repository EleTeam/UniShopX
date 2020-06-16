<?php
namespace common\consts;

/**
 * 支付类型
 */
class PayType extends ValueLabel
{
    //支付类型: 10微信H5，11微信扫码，20支付宝H5，21支付宝扫码
    const WX_H5     = 10;
    const WX_SCAN   = 11;
    const ALI_H5    = 20;
    const ALI_SCAN  = 21;

    protected static $_array = [
        self::WX_H5     => '微信H5',
        self::WX_SCAN   => '微信扫码',
        self::ALI_H5    => '支付宝H5',
        self::ALI_SCAN  => '支付宝扫码',
    ];
}

