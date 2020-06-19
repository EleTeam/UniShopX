<?php
namespace common\consts;

/**
 * 商品审核状态
 */
class AuditStatus extends ValueLabel
{
    const UNDO       = 0;
    const REJECTED   = 90;
    const PASSED     = 100;

    protected static $_array = [
        self::UNDO      => '未审核',
        self::REJECTED  => '审核拒绝',
        self::PASSED    => '审核通过',
    ];
}

