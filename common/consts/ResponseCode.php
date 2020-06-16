<?php

namespace common\consts;

/**
 * 前端vue接口的业务标志位
 * Class ResponseCode
 */
class ResponseCode extends ValueLabel
{
    const NOT_LOGIN             = 10;
    const LOGIN_EXPIRED         = 11;
    const UNAUTHORIZED          = 12;
    const FAIL                  = 90;
    const SUCCESS               = 100;

    protected static $_array = [
        self::NOT_LOGIN         => '未登录',
        self::LOGIN_EXPIRED     => '登录已过期',
        self::UNAUTHORIZED      => '没有操作权限',
        self::FAIL              => '操作失败',
        self::SUCCESS           => '操作成功',
    ];
}