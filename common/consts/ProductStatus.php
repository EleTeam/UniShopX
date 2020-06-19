<?php
namespace common\consts;

/**
 * 商品上下架状态
 */
class ProductStatus extends ValueLabel
{
    const OFF  = 0;
    const ON   = 1;

    protected static $_array = [
        self::OFF  => '下架',
        self::ON   => '上架',
    ];
}

