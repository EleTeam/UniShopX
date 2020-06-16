<?php
namespace common\helpers;

/**
 * 签名助手
 * @package common\helpers
 */
class SignHelper
{
    /**
     * 生成接口签名
     * @param array $data
     * @param string $api_key
     * @return string
     */
    public static function sign($data, $api_key)
    {
        ksort($data);
        $signStr = '';
        foreach ($data as $k => $v){
            if ($v == '' || $v == null || $k == 'sign')
                continue;
            $signStr .= "{$k}={$v}&";
        }
        $signStr .= 'key=' . $api_key;

        return strtoupper(md5($signStr));
    }
}

