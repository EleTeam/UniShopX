<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2015-08-04
 * @email 908601756@qq.com
 * @copyright Copyright © 2016年 EleTeam
 * @license The MIT License (MIT)
 */

namespace api\modules\v1\controllers;

use common\models\Address;
use common\models\Area;
use Yii;
use common\components\ETRestController;

/**
 * 用户收货地址控制器
 * Class AddressController
 * @package api\modules\v1\controllers
 */
class AddressController extends ETRestController
{
    /**
     * 地址列表
     */
    public function actionIndex()
    {
        if(!$this->isLoggedIn()){
            return $this->jsonFail([], '您还没有登录');
        }

        $user_id = $this->getUserId();
        $addresses = Address::findByUser($user_id);
        $addressesArr = [];
        foreach($addresses as $address){
            $addrArr = $address->toArray([], ['area']);
            $addrArr['area']['path_names_4print'] = $address->area->getPathNames4Print();
            $addressesArr[] = $addrArr;
        }

        $data = [
            'addresses' => $addressesArr,
        ];
        return $this->jsonSuccess($data);
    }

    /**
     * 添加地址
     */
    public function actionCreate()
    {
        if(!$this->isLoggedIn()){
            return $this->jsonFail([], '您还没有登录');
        }

        $user_id = $this->getUserId();
//        $area_id = $this->getParam('area_id');
//        $telephone = $this->getParam('telephone');
//        $detail = $this->getParam('detail');
//        $fullname = $this->getParam('fullname');
//
//        //字段验证, 不能用
//        if(empty($area_id)){
//
//        }
//
//        //字段必须填写验证
//        if (StringUtils.isBlank(areaId)) {
//            result = false;
//            message = "区域地址areaId(:" + areaId + ") 不能为空";
//            return renderString(response, result, message, data);
//        }
//        if (StringUtils.isBlank(fullname)) {
//            result = false;
//            message = "请填写收货人姓名，用于收货";
//            return renderString(response, result, message, data);
//        }
//        if (StringUtils.isBlank(telephone)) {
//            result = false;
//            message = "请填写手机号码，用于收货";
//            return renderString(response, result, message, data);
//        }
//        if (!ValidateUtils.isMobile(telephone)) {
//            result = false;
//            message = ValidateUtils.getErrMsg();
//            return renderString(response, result, message, data);
//        }

        $area_id = $this->getParam('area_id');
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

    public function delete()
    {
        if(!$this->isLoggedIn()){
            return $this->jsonFail([], '您还没有登录');
        }

        $id = $this->getParam('id');
    }
}


