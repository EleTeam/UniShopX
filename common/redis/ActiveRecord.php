<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2016-12-11
 * @email 908601756@qq.com
 * @copyright Copyright © 2016年 EleTeam
 * @license The MIT License (MIT)
 */

namespace common\redis;

use Yii;

/**
 * redis AR基类模型
 *
 *  注意：
 *      如果用redis，只要不能用orderBy排序，否则会报错：orderBy is currently not supported by redis ActiveRecord.
 *      如下语句会报错：User::find()->where('status = :status', [':status'=>Banner::STATUS_ACTIVE])->orderBy('position asc')->all();
 */
class ActiveRecord extends \yii\redis\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE   = 1;
    const STATUS_DELETED  = 2;

    const NO = 0;
    const YES = 1;
}
