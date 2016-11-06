<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2015-06-10
 * @email 908601756@qq.com
 * @copyright Copyright © 2015年 EleTeam
 * @license The MIT License (MIT)
 */

namespace api\modules\v1\controllers;

use common\models\CartItem;
use common\components\ETRestController;

class CartItemController extends ETRestController
{
    /**
     * 删除购物车项
     */
    public function actionDelete()
    {
        $id = $this->getParam('id');
        $app_cart_cookie_id = $this->getAppCartCookieId();
        CartItem::deleteByMore($id, $this->getUserId(), $app_cart_cookie_id);
        return $this->jsonSuccess();
    }
}