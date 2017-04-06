<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2017-04-06
 * @email 908601756@qq.com
 * @copyright Copyright © 2017年 EleTeam
 * @license The MIT License (MIT)
 */

namespace common\components;

use Yii;
use yii\base\Component;

/**
 * 工具类
 */
class Util extends Component
{
    /**
     * 返回当前时间戳的毫秒数部分, microsecond 微秒, millisecond 毫秒
     * @return int
     */
    public static function millisecond()
    {
        list($microsecond, $second) = explode(" ", microtime());
        $millisecond = round($microsecond*1000);
        return $millisecond;
    }
}
