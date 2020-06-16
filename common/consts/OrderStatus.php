<?php
namespace common\consts;

/**
 * 订单状态
 */
class OrderStatus extends ValueLabel
{
    const ORDER_CREATED     = 10;
    const FAIL              = 90;
    const SUCCESS           = 100;

    protected static $_array = [
        self::ORDER_CREATED     => '已创建',
        self::FAIL              => '失败',
        self::SUCCESS           => '成功',
    ];
}

