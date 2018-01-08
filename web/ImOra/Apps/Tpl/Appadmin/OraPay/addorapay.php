<layout name="../Layout/Layout" />
<div class="content_global">
    <div class="content_hieght js_formcontent">
        <form method="post" action="{:U(MODULE_NAME.'/OraPay/savaPay','','',true)}" >
        <div class="content_c js_orapay_content">
            <div class="newsCard_text">
                <div class="modle_info">
                    <span>银行名称：</span>
                    <input style="width:298px" value="{$data['name']}" name="bankname" maxlength="12" type="text" placeholder="输入银行名称，例如“招商银行" autocomplete="off">
                </div>
                <div class="modle_info">
                    <span>客服电话：</span>
                    <input style="width:298px" value="{$data['customer']}" name="phone" maxlength="12" type="text" placeholder="输入银行客服电话，例如“95555" autocomplete="off">
                </div>
                <div class="modle_info modle_more clear">
                    <span>支持银行卡类型：</span>
                    <label for=""><input type="checkbox" <if condition="$data['debitcard'] eq 2">checked</if>  name="debit">借记卡</label>
                    <input type="text" maxlength="12" value="{$data['debitcardcity']}" name="debitcity" placeholder="可输入仅支持的城市，例如“北京”" autocomplete="off">
                </div>
                <div class="modle_info modle_more clear">
                    <span></span>
                    <label for=""><input type="checkbox" <if condition="$data['creditcard'] eq 2">checked</if>  name="credit">信用卡</label>
                    <input type="text" maxlength="12" value="{$data['creditcardcity']}" name="creditcity" placeholder="" autocomplete="off">
                </div>
                <div class="num_BIN num_file clear js_orapay_logo">
                    <span>上传银行LOGO：</span>
                    <div class="file-gai" style="float:left;width:90px;height:30px;position:relative;">
                       <input type="file" style="width:90px;" id="js_logoimg" name="picfile"> 
                       <button type="button">上传</button>
                    </div>
                </div>
                <div class="i_logo clear js_logoimg_show">
                    <img src="{$data['logo']}" style="width:100%;height:100%;">

                    <empty name="data['logo']">
                        <em class="hand" >X</em>
                        <else />
                        <em class="hand" style="display:block;">X</em>
                    </empty>
                    <input type="hidden" value="{$data['logo']}" name="logoimg" id="js_logoimgHid">
                </div>
                <div class="modle_info js_orapay_sortnumb">
                    <span>列表顺序：</span>
                    <input style="width:298px" value="{$data['sorting']}" name="sortnumb" type="text" placeholder="可输入序号，数值越大，越靠前显示" autocomplete="off">
                </div>
                <dl>
                    <dt><img src="__PUBLIC__/images/u1784.png" alt=""></dt>
                    <dd>借记卡(北京)</dd>
                </dl>
            </div>
        </div>
        <div class="exchange_btn_b js_btn_hid">
            <input type="hidden" name="orapayid" value="{$data['id']}" >
            <!--<button type="button" class="js_submit_btn js_h5_preview" data-type="1">预览</button>-->
            <button type="button" onclick="$.orapay.checkData();" class="js_cancel_btn">保存</button>
        </div>
        </form>
    </div>
</div>
<!--  h5页面预览框   -->
<div class="h5_dialog js_h5_content">
    <div class="h5rank_logo">
        <h5>当前支持开通的银行</h5>
        <div class="rank_logo_list js_h5_list" id="js_scroll_dom" style="max-height:300px;overflow: hidden;">
            <div class="js_orapay_h5_list">

            </div>
        </div>
    </div>
    <img class="close js_h5_close" src="__PUBLIC__/images/appadmin_icon_popc.png" alt="">
</div>
<script>
    var js_uploadimg_url = "{:U(MODULE_NAME.'/OraPay/upLoadImgFile','','',true)}";
    var js_url_sortnumb_check = "{:U(MODULE_NAME.'/OraPay/checkSortnumb','','',true)}";
    var js_url_sortnumb_form = "{:U(MODULE_NAME.'/OraPay/savaPay','','',true)}";
    var js_url_index = "{:U(MODULE_NAME.'/OraPay/index','','',true)}";
    var js_url_h5list = "{:U(MODULE_NAME.'/OraPay/previewOraPay','','',true)}";
    var js_err_invoicetype_img_err_big = "{$T->str_finance_img_err_big}";
    var js_err_invoicetype_err_faild = "{$T->str_invoice_err_faild}";
    var js_operat_error = "{$T->str_operat_error}";

    $(function(){
        $.orapay.init();
        $.orapay.addOraPay();
    })
</script>

