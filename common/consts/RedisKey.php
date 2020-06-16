<?php
namespace common\consts;

/**
 * redis key
 */
class RedisKey extends ValueLabel
{
    const LOCK_ORDER        = 'lock_order_{id}'; // 单个订单级别锁

    const LOCK_FUSER        = 'lock_fuser_{id}'; // 单个用户级别锁

    const LOCK_FORM_TOKEN   = 'lock_form_token_{token}'; // 表单令牌
}

