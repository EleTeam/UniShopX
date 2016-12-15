<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2015-06-22
 * @email 908601756@qq.com
 * @copyright Copyright © 2015年 EleTeam
 * @license The MIT License (MIT)
 */

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\ProductCategory;
use common\models\ProductType;

/**
 * @var $this yii\web\View
 * @var $categories ProductCategory[]
 * @var $productTypes ProductType[]
 */

$this->title = Yii::t('app', 'Create Product');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<form action="<?=Url::toRoute('product/create-step2')?>" method="get" class="form form-horizontal" id="form-product-create-step1" style="">
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>选择商品分类：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <span class="select-box">
				<select name="" class="select">
                    <option value="">请选择...</option>
                    <?php foreach($categories as $category): ?>
                        <option value="<?=$category->id?>"><?=$category->name?></option>
                    <?php endforeach; ?>
                </select>
            </span>
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>选择商品类型：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <span class="select-box">
				<select name="" class="select">
                    <option value="">请选择...</option>
                    <?php foreach($productTypes as $productType): ?>
                        <option value="<?=$productType->id?>"><?=$productType->name?></option>
                    <?php endforeach; ?>
                </select>
            </span>
        </div>
    </div>
    <div class="row cl">
        <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
            <button class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 下一步填写商品信息</button>
        </div>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function(){

    });
//    $('#form-product-create-step1').submit(function(){
//        $(this).attr('action');
//    });
    function product_add(title, url){
        //layer.setTitle(title);
        location.href = url;
//        var index = layer.open({
//            type: 2,
//            title: title,
//            content: url
//        });
//        layer.full(index);
    }
</script>
