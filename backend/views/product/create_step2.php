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
use yii\bootstrap\ActiveForm;
use backend\assets\AppAsset;
use common\models\Product;
use common\models\ProductCategory;
use common\models\ProductType;

/**
 * @var $this yii\web\View
 * @var $product Product
 * @var $category ProductCategory
 * @var $categories ProductCategory[]
 * @var $productType ProductType
 * @var $skus array 提交的sku信息
 * @var $sp_val array 提交的规格信息
 * @var $spec_id_names array
 */

$this->title = Yii::t('app', 'Create Product');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

AppAsset::register($this);
$this->registerCssFile("@web/huiadmin/lib/webuploader/0.1.5/webuploader.css");
$this->registerJsFile("@web/huiadmin/lib/webuploader/0.1.5/webuploader.min.js");
$this->registerJsFile("@web/huiadmin/lib/ueditor/1.4.3/ueditor.config.js");
$this->registerJsFile("@web/huiadmin/lib/ueditor/1.4.3/ueditor.all.min.js");
$this->registerJsFile("@web/huiadmin/lib/ueditor/1.4.3/lang/zh-cn/zh-cn.js");
?>
<div class="page-container">
    <form action="" method="post" class="form form-horizontal" id="form-article-add">
        <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品分类：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <span class="select-box">
                    <select name="Product[category_id]" class="select">
                        <option value="<?=$category->id?>"><?=$category->name?></option>
                    </select>
                    <?php if(isset($product->errors['category_id'][0])): ?>
                        <span class="c-red">*<?=$product->errors['category_id'][0]?></span>
                    <?php endif; ?>
				</span>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品类型：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <span class="select-box">
                    <select name="Product[type_id]" class="select">
                        <option value="<?=$productType->id?>"><?=$productType->name?></option>
                    </select>
                    <?php if(isset($product->errors['type_id'][0])): ?>
                        <span class="c-red">*<?=$product->errors['type_id'][0]?></span>
                    <?php endif; ?>
				</span>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?=$product->name?>" placeholder="" id="" name="Product[name]">
                <?php if(isset($product->errors['name'][0])): ?>
                <span class="c-red">*<?=$product->errors['name'][0]?></span>
                <?php endif; ?>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">简略标题：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" id="" name="">
            </div>
        </div>

        <!-- 规格区-选择规格值 -->
        <?php /* foreach($productType->productTypeSpecs as $productTypeSpec): ?>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">规格-<?=$productTypeSpec->productSpec->name?>：</label>
            <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                <?php foreach($productTypeSpec->productSpec->productSpecValues as $specValue): ?>
                <div class="check-box">
                    <input type="checkbox" id="checkbox-<?=$specValue->id?>">
                    <label for="checkbox-<?=$specValue->id?>"><?=$specValue->name?></label>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; */?>
        <?php foreach($productType->productTypeSpecs as $specIndex => $productTypeSpec): ?>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>规格-<?=$productTypeSpec->productSpec->name?>：</label>
            <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                <div nctype="spec_group_dl" nc_type="spec_group_dl_<?=$specIndex?>" class="button-group button-group-small radio" <?php if($specIndex==0):?>spec_img="t"<?php endif;?> >
                    <ul class="spec">
                        <?php foreach($productTypeSpec->productSpec->productSpecValues as $specValue): ?>
                        <li>
                            <span nctype="input_checkbox">
                                <input style="30px;display:inline" type="checkbox" name="sp_val[<?=$productTypeSpec->productSpec->id?>][<?=$specValue->id?>]" nc_type="<?=$specValue->id?>" value="<?=$specValue->name?>">
                            </span>
                            <span nctype="pv_name"><?=$specValue->name?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <?php if(Yii::$app->request->isPost && empty($skus)): ?>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*请勾选以上规格</span></label>
        </div>
        <?php endif; ?>

        <!-- 规格区-填写sku信息 -->
        <div id="sku-box" style="display:none;">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>SKU配置: </label>
            <div class="formControls col-xs-8 col-sm-9 button-group button-group-small radio">
                <table class="table table-hover table_header tab_style_base table_view">
                    <thead nc_type="spec_thead"></thead>
                    <tbody nc_type="spec_table"></tbody>
                </table>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">产品摘要：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea name="" cols="" rows="" class="textarea" placeholder="说点什么...最少输入10个字符" datatype="*10-100" dragonfly="true" nullmsg="备注不能为空！" onKeyUp="textarealength(this,200)"></textarea>
                <p class="textarea-numberbar"><em class="textarea-length">0</em>/200</p>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">缩略图：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <div class="uploader-thum-container">
                    <div id="fileList" class="uploader-list"></div>
                    <div id="filePicker">选择图片</div>
                    <button id="btn-star" class="btn btn-default btn-uploadstar radius ml-10">开始上传</button>
                </div>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">图片上传：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <div class="uploader-list-container">
                    <div class="queueList">
                        <div id="dndArea" class="placeholder">
                            <div id="filePicker-2"></div>
                            <p>或将照片拖到这里，单次最多可选300张</p>
                        </div>
                    </div>
                    <div class="statusBar" style="display:none;">
                        <div class="progress"> <span class="text">0%</span> <span class="percentage"></span> </div>
                        <div class="info"></div>
                        <div class="btns">
                            <div id="filePicker2"></div>
                            <div class="uploadBtn">开始上传</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">详细内容：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <script id="editor" type="text/plain" style="width:100%;height:400px;"></script>
            </div>
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                <button class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存并提交审核</button>
                <button onClick="layer_close();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    var skuFields = []; //存储规格值，再次选中的时候可以搜索到最近保存的值, 键如skuFields['skus[_1_5_][price]']=5.55;
    <?php foreach($skus as $spec_value_id_set => $sku): ?>
    var namePrice = 'skus[<?=$spec_value_id_set?>][price]';
    var nameCount = 'skus[<?=$spec_value_id_set?>][count]';
    var nameCode = 'skus[<?=$spec_value_id_set?>][code]';
    skuFields[namePrice] = '<?=$sku["price"]?>';
    skuFields[nameCount] = '<?=$sku["count"]?>';
    skuFields[nameCode] = '<?=$sku["code"]?>';
    <?php endforeach; ?>

    //响应点击选择规格值
    $('div[nctype="spec_group_dl"]').on('click', 'span[nctype="input_checkbox"] > input[type="checkbox"]',function(){
        //保存skuFields
        $('tbody[nc_type="spec_table"]').find('input[type="text"]').each(function(){
            var name = $(this).attr('name');
            skuFields[name] = $(this).val();
        });

        into_array();

        //生成每行sku信息
        goods_stock_set();
    });

    //=========start 构造规格数组
    // 按规格存储规格值数据, 如 spec_group_checked = ['',''];
    var spec_group_checked = [<?php
            $str = '';
            foreach($productType->productTypeSpecs as $productTypeSpec){
                $str .= "'',";
            }
            $str = rtrim($str, ",");
            echo $str;
        ?>];

    var V = [];

    //生成对应数量的规格数组
    <?php foreach($productType->productTypeSpecs as $key=>$productTypeSpec): ?>
    var spec_group_checked_<?=$key?> = [];
    <?php endforeach; ?>

    var count_sign = <?=count($productType->productTypeSpecs)?>;
    var specarr = [];

    //生成规格名称 specarr[0]='颜色'; specarr[1]='尺码';
    <?php foreach($productType->productTypeSpecs as $key=>$productTypeSpec): ?>
    specarr[<?=$key?>] = '<?=$productTypeSpec->productSpec->name?>';
    <?php endforeach; ?>

    // 将选中的规格放入数组
    function into_array(){
        <?php foreach($productType->productTypeSpecs as $key=>$productTypeSpec): ?>
        spec_group_checked_<?=$key?> = [];
        $('div[nc_type="spec_group_dl_<?=$key?>"]').find('input[type="checkbox"]:checked').each(function(){
            i = $(this).attr('nc_type');
            v = $(this).val();
            c = null;
            if ($(this).parents('div:first').attr('spec_img') == 't') {
                c = 1;
            }
            spec_group_checked_<?=$key?>[spec_group_checked_<?=$key?>.length] = [v,i,c];
        });
        spec_group_checked[<?=$key?>] = spec_group_checked_<?=$key?>;
        <?php endforeach; ?>
    }
    //==========end 构造规格数组


    //======= start 生成每行sku信息
    function goods_stock_set(){
        var spectablestr = getSpecTable();

        if(spectablestr == ''){ //未选择任何规格时隐藏sku table
            $('#sku-box').hide();
        }else{
            //获取头部
            $('thead[nc_type="spec_thead"]').empty().html(getSpecHead());
            $('tbody[nc_type="spec_table"]').empty().html(spectablestr)
                .find('input[nc_type]').each(function(){
                    s = $(this).attr('nc_type');
                    try{$(this).val(V[s]);}catch(ex){$(this).val('');};
                    if($(this).attr('data_type') == 'price' && $(this).val() == ''){
                        $(this).val($('input[name="price"]').val());
                        //$(this).attr("class",);
                    }
                    if($(this).attr('data_type') == 'count' && $(this).val() == ''){
                        $(this).val('0');
                    }
                }).end()
                .find('input[nc_type]').change(function(){
                    s = $(this).attr('nc_type');
                    V[s] = $(this).val();
                });
            $('#sku-box').show();
        }
    }

    function getSpecTable(){
        //count_sign 为几种规格
        var selectspec = [];

        //找出哪些规格是勾选了的
        var count_td = 0;
        for(var i=0;i<count_sign;i++){
            if(spec_group_checked[i].length>0){
                selectspec[count_td] = spec_group_checked[i];
                count_td++;
            }
        }

        var speclist = getSpecList(0,selectspec, []);
        var str = '';

        if(speclist.length>0){
            for(var i=0;i<speclist.length;i++){
                str+="<tr>";

                //spec_value_ids字符串
                var spec_value_ids = '_';
                for(var j=0;j<speclist[i].length;j++){
                    spec_value_ids += speclist[i][j][1] + '_';
                }
                //sku对应的字段
                var priceName = 'skus[' + spec_value_ids + '][price]';
                var countName = 'skus[' + spec_value_ids + '][count]';
                var codeName = 'skus[' + spec_value_ids + '][code]';
                var price = skuFields[priceName] != 'undefined' ? skuFields[priceName] : '';
                var count = skuFields[countName] != 'undefined' ? skuFields[countName] : '';
                var code = skuFields[codeName] != 'undefined' ? skuFields[codeName] : '';

                for(var j=0;j<speclist[i].length;j++){
                    str += "<td>";
                    str += '<input type="hidden" name="skus[' + spec_value_ids + '][sp_value][' + speclist[i][j][1] + ']" value="' + speclist[i][j][0] + '" />';
                    str += speclist[i][j][0];
                    str += "</td>";
                }

                str += '<td><input class="text input price" style="width:90px;" type="text" name="skus['+spec_value_ids+'][price]" data_type="price" nc_type="'+spec_value_ids+'|price" value="' + price + '" /><em class="add-on"><i class="icon-renminbi"></i></em></td>';
                str += '<td><input class="text input count" style="width:90px;" type="text" name="skus['+spec_value_ids+'][count]" data_type="count" nc_type="'+spec_value_ids+'|count" value="' + count + '" /></td>';
                str += '<td><input class="text input code" style="width:90px;" type="text" name="skus['+spec_value_ids+'][code]" nc_type="'+spec_value_ids+'|code" value="' + code + '" /></td>';
                str += '</tr>\n';
            }
        }
        return str;
    }

    function getSpecList(index,data,t){
        var ret  = [];
        var tttt = t.concat();

        for(var i=index;i<data.length;i++){
            for(var j=0;j<data[i].length;j++){
                tttt[tttt.length] = data[i][j];
                var aa = getSpecList(i+1,data,tttt);
                if(aa.length>0){
                    for(var l=0;l<aa.length;l++){
                        ret[ret.length]=aa[l];
                    }
                    tttt = [];
                    tttt = t.concat();
                }else{
                    if(data.length==tttt.length){
                        var ret_length  = ret.length;
                        ret[ret_length] = [];
                        for(var ct=0;ct<tttt.length;ct++){
                            var tmp_len = ret[ret_length].length;
                            ret[ret_length][tmp_len]=tttt[ct];
                        }

                    }

                    tttt = [];
                    tttt =t.concat();
                }
            }

            tttt = [];
        }
        return ret;
    }

    function getSpecHead(){
        var headstr = '';
        var selectspec = [];
        //找出哪些规格是勾选了的
        var count_td = 0;

        for(var i=0;i<count_sign;i++){
            if(spec_group_checked[i].length>0){
                selectspec[count_td] = i;
                count_td++;
            }
        }

        for(var i=0;i<selectspec.length;i++){
            headstr+='<th style="width:100px;">'+specarr[selectspec[i]]+'</th>\n';
        }

        headstr+='<th style="width:100px;">价格</th>\n';
        headstr+='<th style="width:100px;">库存</th>\n';
        headstr+='<th style="width:100px;">SKU编码</th>\n';

        return headstr;
    }
    //======= end 生成每行sku信息

    //========提交后失败重新生成之前提交的规格
    <?php if(Yii::$app->request->isPost): ?>
    $(function(){
        var sp_val_names = [];  //提交的规格id和规格值id列表, 存储如sp_val_names['sp_val[10][8237]']
        var E_SPV = []; //提交的规格值列表id-name

        //php规格和规格值对象转为js对象
        <?php foreach ($sp_val as $spec_id => $spec_value_ids): ?>
        <?php foreach ($spec_value_ids as $spec_value_id => $spec_value_name): ?>
        var key = 'sp_val[<?=$spec_id?>][<?=$spec_value_id?>]';
        sp_val_names[key] = '<?=$spec_value_name?>';
        <?php endforeach; ?>
        <?php endforeach; ?>

        <?php
        $string = '';
        foreach ($skus as $k => $v) {
            $string .= "E_SPV['{$k}'] = '标准';";
        }
        echo $string;
        ?>

        //勾选已选中的规格
        $('div[nctype="spec_group_dl"]').find('input[type="checkbox"]').each(function(){
            var name = $(this).attr('name');
            if (typeof(sp_val_names[name]) != 'undefined'){
                $(this).attr('checked',true);
            }
        });

        into_array();   // 将选中的规格放入数组
        goods_stock_set();
    });
    <?php endif; ?>
</script>