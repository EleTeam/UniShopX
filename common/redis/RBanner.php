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

use common\models\Banner;
use Yii;

/**
 * Banner at redis
 *
 * @property integer $id
 * @property string $name
 * @property integer $position
 * @property integer $hits
 * @property string $image
 * @property string $text
 * @property string $html
 * @property string $link
 * @property integer $status
 * @property integer $ended_at
 * @property integer $started_at
 */
class RBanner extends ActiveRecord
{
    public function attributes()
    {
        return ['id', 'name', 'position', 'hits', 'image', 'text ', 'status', 'html', 'link', 'ended_at', 'started_at'];
    }

    /**
     * 获取所有进行中的广告
     *
     * @return self[]
     */
    public static function findBanners()
    {
        //@todo <= >=这样的条件查询怎么写？
        $where = ['status' => self::STATUS_ACTIVE];
        $rBanners = self::find()->where($where)->all();

        if(empty($rBanners)) {
            //从数据库中查询
            $rBanners = [];
            $banners = Banner::findBanners();
            //写入redis
            foreach($banners as $banner){
                $rBanner = new self();
                $rBanner->setAttributes($banner->getAttributes(), false);
                $rBanner->insert();
                $rBanners[] = $banner;
            }
        }

        return $rBanners;
    }
}
