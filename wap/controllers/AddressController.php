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
use common\models\Area;
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

    /**
     * 添加地址-空页面
     */
    public function actionCreate()
    {
        return $this->render('create');
    }

    /**
     * 添加地址-提交数据
     */
    public function actionCreatePost()
    {
        $user_id = $this->getUserId();
        $area_id = Yii::$app->request->post('area_id');
        $area = Area::findOne($area_id);
        if (!$area) {
            return $this->jsonFail("区域地址(ID:$area_id) 不存在");
        }

        //非店内消费必须填写门牌地址
        if ($area->id != Area::SHIPPING_GROUP_STORE && empty($this->getParam('detail'))) {
            return $this->jsonFail([], '请填写门牌地址，用于收货');
        }

        //清除默认地址, 因为把每次添加的地址作为默认地址
        Address::updateAll(['is_default'=>Address::NO], 'user_id=:user_id', [':user_id'=>$user_id]);

        //添加收货地址
        $address = new Address();
        $addressData = $_REQUEST;
        $addressData['is_default'] = Address::YES;
        $addressData['user_id'] = $user_id;
        if(!($address->load($addressData, '') && $address->save())) {
            return $this->jsonFail([], $address->errorsToString());
        }

        //我的收货列表
        $addresses = Address::findByUser($user_id);
        $addressesArr = [];
        foreach($addresses as $item){
            $addressesArr[] = $item->toArray([], ['area']);
        }

        //带有区域对象的新地址
        $addrArr = [];
        $addrArr[] = $address->toArray();
        $addrArr['area'] = $address->area->toArray();
        $addrArr['area']['path_names_4print'] = $address->area->getPathNames4Print();

        $data = [
            'addresses' => $addressesArr,
            'address' => $addrArr,
        ];
        return $this->jsonSuccess($data);

    }
}