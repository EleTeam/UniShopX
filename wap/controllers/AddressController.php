<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2017-01-19
 * @email 908601756@qq.com
 * @copyright Copyright © 2017年 EleTeam
 * @license The MIT License (MIT)
 */

namespace wap\controllers;

use common\models\Cart;
use common\models\Address;
use Yii;
use yii\db\Exception as DbException;

/**
 * 地址控制器
 *
 * Class AddressController
 * @package wap\controllers
 */
class AddressController extends BaseController
{
    public function actionIndex()
    {
        $addresses = Address::findByUser($this->getUserId());

        return $this->render('index', [
            'addresses' => $addresses,
        ]);
    }
}