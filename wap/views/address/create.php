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

use yii\helpers\Url;
use common\models\Address;

/**
 * @var $this yii\web\View
 * @var $addresses Address[]
 */
?>
<div class="navbar">
    <div class="navbar-inner">
        <div class="left">
            <a href="#" class="back link">
                <i class="icon icon-back"></i>
                <span>返回</span>
            </a>
        </div>
        <div class="center sliding">添加收货地址</div>
    </div>
</div>
<div class="page no-tabbar address-create" data-page="address-create">
    <div class="page-content">
        <i style="display: none;" id="url-get-all-areas" data-url="<?=Url::toRoute('address/get-all-areas')?>"></i>

        <form class="list-block address-form" action="<?=Url::toRoute('address/create-post')?>">
            <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
            <ul>
                <!-- Text inputs -->
                <li>
                    <div class="item-content">
                        <div class="item-inner">
                            <div class="item-input">
                                <input required="required" name="fullname" placeholder="收货人姓名" type="text">
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="item-content">
                        <div class="item-inner">
                            <div class="item-input">
                                <input name="province" id="province" type="hidden">
                                <input name="city" id="city" type="hidden">
                                <input name="county" id="county" value="110101" type="hidden">
                                <input required="required" name="area_text" placeholder="所属地区" id="picker-dependent" readonly="readonly" class="" type="text">
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="item-content">
                        <div class="item-inner">
                            <div class="item-input">
                                <input required="required" name="detail_address" placeholder="您的详细地址" class="" type="text">
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="item-content">
                        <div class="item-inner">
                            <div class="item-input">
                                <input required="required" name="telephone" placeholder="手机号码" type="tel">
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="item-content">
                        <label class="label-checkbox box display-box-pack">
                            <input name="is_default" type="checkbox">
                            <div class="item-media"><i class="icon icon-form-checkbox"></i></div>
                            <div class="box-flex">设置成默认地址</div>
                        </label>
                    </div>
                </li>
                <li>
                    <div class="item-content">
                        <a href="#" class="btn btn-blue js-post" data-reload-page="<?=Url::toRoute('/address')?>">确 定</a>
                    </div>
                </li>
            </ul>
        </form>
    </div>
</div>