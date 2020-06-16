<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Transaction;

/**
 * 表记录模型基类
 *
 * 事务隔离：Yii 为四个最常用的隔离级别提供了常量：
 *  yii\db\Transaction::READ_UNCOMMITTED - 最弱的隔离级别，脏读、不可重复读以及幻读都可能发生。
 *  yii\db\Transaction::READ_COMMITTED - 避免了脏读。
 *  yii\db\Transaction::REPEATABLE_READ - 避免了脏读和不可重复读。
 *  yii\db\Transaction::SERIALIZABLE - 最强的隔离级别， 避免了上述所有的问题。
 *
 * rules里面safe的含义：
 *  用来指定属性值是安全的，无须进行验证，直接赋值
 *  所以在数据表的model里不要用safe rule，在form表单可以用，因为保存model时会验证
 */
class BaseModel extends ActiveRecord
{
    //status, 记录状态
    const STATUS_INACTIVE       = 0;
    const STATUS_ACTIVE         = 1;

    //默认最高事务隔离级别，要在开启事务前手动设置
    const DEFAULT_TRANSACTION_ISOLATION = Transaction::SERIALIZABLE;

    /**
     * 所有表记录模型都有字段created_at, updated_at, 且由save时自动保存
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public static function statusToLabel($status)
    {
        if (isset(static::statusToArray()[$status])) {
            return static::statusToArray()[$status];
        } else {
            return '未知';
        }
    }

    public static function statusToArray()
    {
        return [
            static::STATUS_ACTIVE   => '启用',
            static::STATUS_INACTIVE => '禁用',
        ];
    }
}
