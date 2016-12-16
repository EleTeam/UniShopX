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
use backend\assets\AppAsset;
use common\models\ProductCategory;
use common\models\ProductType;

/**
 * @var $this yii\web\View
 * @var $category ProductCategory
 * @var $categories ProductCategory[]
 * @var $productType ProductType
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
$this->registerJsFile("@web/js/product-view.js");
?>
<div class="page-container">
    <form action="" method="post" class="form form-horizontal" id="form-article-add">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品分类：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <span class="select-box">
                    <select name="Product[category_id]" class="select">
                        <option value="<?=$category->id?>"><?=$category->name?></option>
                    </select>
				</span>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品类型：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <span class="select-box">
                    <select name="Product[product_type_id]" class="select">
                        <option value="<?=$productType->id?>"><?=$productType->name?></option>
                    </select>
				</span>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品标题：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" id="" name="">
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
                <div nctype="spec_group_dl" nc_type="spec_group_dl_<?=$specIndex?>" class="button-group button-group-small radio" <?if($specIndex==0):?>spec_img="t"<?endif;?> >
                    <ul class="spec">
                        <?php foreach($productTypeSpec->productSpec->productSpecValues as $specValue): ?>
                        <li>
                            <span nctype="input_checkbox">
                                <input style="30px;display:inline" type="checkbox" name="sp_val[<?=$specIndex?>][<?=$specValue->id?>]" nc_type="<?=$specValue->id?>" value="<?=$specValue->name?>">
                            </span>
                            <span nctype="pv_name"><?=$specValue->name?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <!-- 规格区-填写sku信息 -->
        <div id="spec-box" style="display:none;">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>SKU配置: </label>
            <div class="formControls col-xs-8 col-sm-9 button-group button-group-small radio">
                    <table class="table table-hover table_header tab_style_base table_view">
                        <thead nc_type="spec_thead">
                            <tr>
                                <?php foreach($productType->productTypeSpecs as $productTypeSpec): ?>
                                <th style="width:50px;" nctype="spec_name_<?=$productTypeSpec->productSpec->id?>"><?=$productTypeSpec->productSpec->name?></th>
                                <?php endforeach; ?>
                                <th style="width:50px;">价格</th>
                                <th style="width:50px;">库存</th>
                                <th style="width:50px;">SKU</th>
                            </tr>
                        </thead>
                        <tbody nc_type="spec_table"></tbody>
                    </table>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">排序值：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="0" placeholder="" id="" name="">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">价格计算单位：</label>
            <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select class="select">
                    <option>请选择</option>
                    <option value="1">件</option>
                    <option value="2">斤</option>
                    <option value="3">KG</option>
                    <option value="4">吨</option>
                    <option value="5">套</option>
                </select>
				</span> </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">产品重量：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="" id="" placeholder="" value="" class="input-text" style="width:90%">
                kg</div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">产品展示价格：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="" id="" placeholder="" value="" class="input-text" style="width:90%">
                元</div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">市场价格：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="" id="" placeholder="" value="" class="input-text" style="width:90%">
                元</div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">成本价格：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="" id="" placeholder="" value="" class="input-text" style="width:90%">
                元</div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">最低销售价格：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="" id="" placeholder="" value="" class="input-text" style="width:90%">
                元</div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">销售开始时间：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}'})" id="datemin" class="input-text Wdate" style="width:180px;">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">销售结束时间：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'#F{$dp.$D(\'datemin\')}'})" id="datemax" class="input-text Wdate" style="width:180px;">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">产品关键字：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="" id="" placeholder="多个关键字用英文逗号隔开，限10个关键字" value="" class="input-text">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">产品摘要：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea name="" cols="" rows="" class="textarea"  placeholder="说点什么...最少输入10个字符" datatype="*10-100" dragonfly="true" nullmsg="备注不能为空！" onKeyUp="textarealength(this,200)"></textarea>
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
                <button onClick="article_save_submit();" class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存并提交审核</button>
                <button onClick="article_save();" class="btn btn-secondary radius" type="button"><i class="Hui-iconfont">&#xe632;</i> 保存草稿</button>
                <button onClick="layer_close();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    //响应点击选择规格值
    $('div[nctype="spec_group_dl"]').on('click', 'span[nctype="input_checkbox"] > input[type="checkbox"]',function(){
        into_array();
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

    var V = new Array();

    //生成对应数量的规格数组
    <?php foreach($productType->productTypeSpecs as $key=>$productTypeSpec): ?>
    var spec_group_checked_<?=$key?> = new Array();
    <?php endforeach; ?>

    var count_sign = <?=count($productType->productTypeSpecs)?>;
    var specarr = new Array();

    //生成规格名称 specarr[0]='颜色'; specarr[1]='尺码';
    <?php foreach($productType->productTypeSpecs as $key=>$productTypeSpec): ?>
    specarr[<?=$key?>] = '<?=$productTypeSpec->productSpec->name?>';
    <?php endforeach; ?>

    // 将选中的规格放入数组
    function into_array(){
        <?php foreach($productType->productTypeSpecs as $key=>$productTypeSpec): ?>
        spec_group_checked_<?=$key?> = new Array();
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


    //======= start 生成库存配置
    function goods_stock_set(){
        var spectablestr = getSpecTable();

        if(spectablestr == ''){ //未选择任何规格时隐藏sku table
            $('#spec-box').hide();
        }else{
            //获取头部
            $('thead[nc_type="spec_thead"]').empty().html(getSpecHead());
            $('tbody[nc_type="spec_table"]').empty().html(spectablestr)
                .find('input[nc_type]').each(function(){
                    s = $(this).attr('nc_type');
                    try{$(this).val(V[s]);}catch(ex){$(this).val('');};
                    if($(this).attr('data_type') == 'price' && $(this).val() == ''){
                        $(this).val($('input[name="f_productprice"]').val());
                        //$(this).attr("class",);
                    }
                    if($(this).attr('data_type') == 'stock' && $(this).val() == ''){
                        $(this).val('0');
                    }
                }).end()
                .find('input[data_type="stock"]').change(function(){
                    computeStock();    // 库存计算
                }).end()
                .find('input[data_type="price"]').change(function(){
                    computePrice();     // 价格计算
                }).end()
                .find('input[data_type="marketprice"]').change(function(){
                    computeMarketPrice();     // 市场价格计算
                }).end()
                .find('input[data_type="costprice"]').change(function(){
                    computeCostPrice();     // 成本价格计算
                }).end()
                .find('input[nc_type]').change(function(){
                    s = $(this).attr('nc_type');
                    V[s] = $(this).val();
                });
            $('#spec-box').show();
        }
    }

    function getSpecTable(){
        //count_sign 为几种规格
        var selectspec = new Array();

        //找出哪些规格是勾选了的
        var count_td = 0;
        for(var i=0;i<count_sign;i++){
            if(spec_group_checked[i].length>0){
                selectspec[count_td] = spec_group_checked[i];
                count_td++;
            }
        }

        var speclist = getSpecList(0,selectspec,new Array());
        var str = '';

        if(speclist.length>0){
            for(var i=0;i<speclist.length;i++){
                str+="<tr>";
                var spec_bunch = 'i';
                for(var j=0;j<speclist[i].length;j++){
                    spec_bunch += "_"+speclist[i][j][1];
                }
                str += '<input type="hidden" name="spec['+spec_bunch+'][goods_id]" nc_type="'+spec_bunch+'|id" value="" />';
                for(var j=0;j<speclist[i].length;j++){
                    str+="<td>";
                    str+='<input type="hidden" name="spec['+spec_bunch+'][sp_value]['+speclist[i][j][1]+']" value="'+speclist[i][j][0]+'" />';
                    str+= '<input type="hidden" name="spec['+spec_bunch+'][color]" value="'+speclist[i][j][1]+'" />';
                    str+=speclist[i][j][0];
                    str+="</td>";
                }

                str +='<td><input class="text input price" style="width:90px;" type="text" name="spec['+spec_bunch+'][price]" data_type="price" nc_type="'+spec_bunch+'|price" value="" /><em class="add-on"><i class="icon-renminbi"></i></em></td>';
                str +='<td><input class="text input stock" style="width:90px;" type="text" name="spec['+spec_bunch+'][stock]" data_type="stock" nc_type="'+spec_bunch+'|stock" value="" /></td>';
                str +='<td><input class="text input sku" style="width:90px;" type="text" name="spec['+spec_bunch+'][sku]" nc_type="'+spec_bunch+'|sku" value="" /></td>';
                str +='</tr>\n';
            }
        }
        return str;
    }

    function getSpecList(index,data,t){
        var ret     = new Array();
        var tttt     = t.concat();

        for(var i=index;i<data.length;i++){
            for(var j=0;j<data[i].length;j++){
                tttt[tttt.length] = data[i][j];
                var aa = getSpecList(i+1,data,tttt);
                if(aa.length>0){
                    for(var l=0;l<aa.length;l++){
                        ret[ret.length]=aa[l];
                    }
                    tttt = new Array();
                    tttt=t.concat();
                }else{
                    if(data.length==tttt.length){
                        var ret_length  = ret.length;
                        ret[ret_length] = new Array();
                        for(var ct=0;ct<tttt.length;ct++){
                            var tmp_len = ret[ret_length].length;
                            ret[ret_length][tmp_len]=tttt[ct];
                        }

                    }

                    tttt = new Array();
                    tttt =t.concat();
                }
            }

            tttt = new Array();
        }
        return ret;
    }

    function getSpecHead(){
        var headstr = '';
        var selectspec = new Array();
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
        headstr+='<th style="width:100px;">SKU</th>\n';

        return headstr;
    }
    //======= end 生成库存配置
</script>
