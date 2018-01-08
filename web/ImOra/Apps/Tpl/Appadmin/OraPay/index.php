<layout name="../Layout/Layout" />
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c js_listcontent">
            <div class="section_bin add_vipcard" style="margin-bottom:20px;">
                <button onclick="window.location.href='{:U(MODULE_NAME.'/OraPay/addPay','','',true)}'" type="button">新增</button>
                <!--<button type="button" class="js_h5_preview" data-type="0">H5页面预览</button>-->
            </div>
            <div class="vipcard_list gave_card userpushlist_name fa_card">
                <span class="span_span8">LOGO</span>
                <span class="span_span1 hand"><u>银行名称</u></span>
                <span class="span_span5">客服电话</span>
                <a href="{:U('/Appadmin/OraPay/index/sort/createdtime',$search)}" >
                <span class="span_span4 hand">
                    <u style="float:left;">{$T->str_orange_type_updatetime}</u>
                    <if condition="$search['types'] eq 'asc' and $listsort eq 'createdtime' ">
                        <em class="list_sort_asc "></em>
                        <elseif condition="$search['types'] eq 'desc' and $listsort eq 'createdtime' " />
                        <em class="list_sort_desc"></em>
                        <else />
                        <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                    </if>
                </span>
                </a>
                <span class="span_span2">借记卡</span>
                <span class="span_span8">信用卡</span>
                <span class="span_span5">操作</span>
            </div>
            <foreach name="list" item="val">
                <div class="vipcard_list gave_card checked_style userpushlist_c list_hover js_x_scroll_backcolor fa_card js_list_one">
                    <span class="span_span8"><img src="{$val['logo']}" alt=""></span>
                    <span class="span_span1" title="{$val['name']}">{$val['name']}</span>
                    <span class="span_span5" title="{$val['customer']}">{$val['customer']}</span>
                    <span class="span_span4">{:date('Y-m-d H:i',$val['createdtime'])}</span>
                    <span class="span_span2">{:$val['debitcard']==2?'支持':'/'}</span>
                    <span class="span_span8">{:$val['creditcard']==2?'支持':'/'}</span>
                        <span class="span_span5">
                            <em class="hand js_show_one"><a href = "{:U(MODULE_NAME.'/OraPay/editPay',array('id'=>$val['id']))}">修改</a></em> |
                            <em class="hand js_orapay_del"  data-id="{$val['id']}" ><a onclick="javascript:$.orapay.delconfirm(this);"  >删除</a></em>
                        </span>
                </div>
            </foreach>
            <div class="appadmin_pagingcolumn">
                <div class="page">{$pagedata}</div>
            </div>
        </div>
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
    var js_url_delorapay = "{:U(MODULE_NAME.'/OraPay/delPay','','',true)}";
    var js_url_index = "{:U(MODULE_NAME.'/OraPay/index','','',true)}";
    var js_url_h5list = "{:U(MODULE_NAME.'/OraPay/previewOraPay','','',true)}";
    var js_operat_error = "{$T->str_operat_error}";
    $(function(){
        $.orapay.init();
    })
</script>