<?php

namespace common\helpers;

use common\consts\RedisKey;
use yii\redis\Connection;

/**
 * 表单令牌助手，防止重复提交表单
 * Class FormToken
 * @package common\helpers
 */
class FormToken
{
    const EXPIRE_SECONDS = 3600;

    /**
     * 生成表单令牌，保存在redis
     * @return string|null
     */
    public static function generateToken(){
        $token = date('ymdHis') . substr(microtime(), 2, 6) . rand(0, 99);
        $key = str_replace('{token}', $token, RedisKey::LOCK_FORM_TOKEN);
        if (static::_getRedis()->setnx($key, 1)) {
            static::_getRedis()->expire($key, static::EXPIRE_SECONDS);
            return $token;
        } else {
            return null;
        }
    }

    public static function exists($token){
        if (empty($token)) {
            return false;
        }
        $key = str_replace('{token}', $token, RedisKey::LOCK_FORM_TOKEN);
        return !!static::_getRedis()->exists($key);
    }

    public static function delete($token)
    {
        $key = str_replace('{token}', $token, RedisKey::LOCK_FORM_TOKEN);
        static::_getRedis()->del($key);
    }

    /**
     * @return Connection $redis
     */
    private static function _getRedis()
    {
        return \Yii::$app->redis;
    }

}