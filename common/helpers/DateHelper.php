<?php
namespace common\helpers;

class DateHelper
{
    public static function format($time = null, $format = 'm-d H:i:s')
    {
        if (!$time)
            return '';
        return date($format, $time ? $time : time());
    }

}