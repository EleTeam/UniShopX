<?php
namespace common\helpers;

use Yii;
use yii\base\BaseObject;

/**
 * redis 分布式锁
 *
 * @property string $key redis key
 * @property string $value key对应的value
 * @property int $expireSeconds 锁过期时间
 * @property string $error 没有获取到锁时的报错信息，read-only
 *
 * Class RedisLock
 * @package common\helpers
 */
class RedisLock extends BaseObject
{
    private $_key;
    private $_value = '';
    private $_expireSeconds = 5;
    private $_error = '';
    private $_redis; /* @var yii\redis\Connection $redis */

    /**
     * RedisLock constructor.
     * @param string $key redis key
     * @param array $config
     */
    public function __construct($key, $config = [])
    {
        if (!($this->_redis = Yii::$app->redis)) {
            $this->_error = 'redis连接失败';
        }

        $this->_key = $key;
        parent::__construct($config);
    }

    /**
     * 非阻塞锁
     * @return bool
     */
    public function lock()
    {
        if ($this->_error)
            return false;

        if ($this->_redis->setnx($this->_key, $this->_value)) {
            $this->_redis->expire($this->_key, $this->_expireSeconds);
            return true;
        } else {
            $this->_error = '未获取到非阻塞锁';
            return false;
        }
    }

    /**
     * 阻塞锁
     * @param int $waitSeconds 获取锁的等待时间，超过这个时间还没有获取到锁则返回失败
     * @return bool
     */
    public function blockLock($waitSeconds = 10)
    {
        if ($this->_error)
            return false;

        $startTime = time();
        while (true) {
            if ($startTime + $waitSeconds >= time()) {
                if ($this->_redis->setnx($this->_key, $this->_value)) {
                    $this->_redis->expire($this->_key, $this->_expireSeconds);
                    return true;
                }
                sleep(1);
            } else {
                $this->_error = '超时未获取到阻塞锁';
                return false;
            }
        }
   }

   public function unLock()
   {
       $this->_redis->del($this->_key);
   }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->_key;
    }

    /**
     * @param mixed $key
     */
    public function setKey($key)
    {
        $this->_key = $key;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->_value;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->_value = $value;
    }

    /**
     * @return int
     */
    public function getExpireSeconds()
    {
        return $this->_expireSeconds;
    }

    /**
     * @param int $expireSeconds
     */
    public function setExpireSeconds($expireSeconds)
    {
        $this->_expireSeconds = $expireSeconds;
    }

   public function getError()
   {
       return $this->_error;
   }
}