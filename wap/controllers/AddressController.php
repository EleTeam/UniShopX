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

use common\helpers\AreaHelper;
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
    //@todo 添加授权

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
        $fullname = Yii::$app->request->post('fullname');
        $area_id = Yii::$app->request->post('area_id');
        $detail_address = Yii::$app->request->post('detail_address');
        $telephone = Yii::$app->request->post('telephone');
        $is_default = Yii::$app->request->post('is_default') ? 1 : 0;

        if(!$fullname || !$area_id || !$detail_address || !$telephone){
            return $this->jsonFail([], "请把信息填写完整");
        }

        if(!is_numeric($telephone) || strlen($telephone) < 11 || substr($telephone,0,1) != '1'){
            return $this->jsonFail([], "请输入正确手机号");
        }

        $area = Area::findOne($area_id);
        if (!$area) {
            return $this->jsonFail([], "区域地址(ID:$area_id) 不存在");
        }

        //非店内消费必须填写门牌地址
        //if ($area->id != Area::SHIPPING_GROUP_STORE && empty($this->getParam('detail'))) {
          //  return $this->jsonFail([], '请填写门牌地址，用于收货');
        //}

        //取消默认地址
        if($is_default) {
            Address::updateAll(['is_default' => Address::NO], 'user_id=:user_id', [':user_id' => $user_id]);
        }

        //添加收货地址
        $address = new Address();
        $addressData = [
            'user_id' => $user_id,
            'is_default' => $is_default,
            'telephone' => $telephone,
            'detail_address' => $detail_address,
            'area_id' => $area_id,
            'fullname' => $fullname
        ];
        if(!($address->load($addressData, '') && $address->save())) {
            return $this->jsonFail([], $address->errorsToString());
        }

        //我的收货列表
//        $addresses = Address::findByUser($user_id);
//        $addressesArr = [];
//        foreach($addresses as $item){
//            $addressesArr[] = $item->toArray([], ['area']);
//        }
//
//        //带有区域对象的新地址
//        $addrArr = [];
//        $addrArr[] = $address->toArray();
//        $addrArr['area'] = $address->area->toArray();
//        $addrArr['area']['path_names_4print'] = $address->area->getPathNames4Print();
//
//        $data = [
//            'addresses' => $addressesArr,
//            'address' => $addrArr,
//        ];
        return $this->jsonSuccess([], '添加成功');

    }
}