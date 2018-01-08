<layout name="../Layout/Layout" />
<include file="head" />
<style>
    .edui-default .edui-toolbar{
        width:706px; /*设置ueditor 编辑器宽度*/
    }
    a u{color: #333;}
</style>
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <div class="content_search">

                <div class="right_search">
                    <div class="serach_status menu_list  js_select_div">
                        <div class="publish-type">
                            {$T->str_news_status}
                        </div>
                        <span class="span_name"><input name="status" type="text" value="{$status_name}" readonly="true" title="{$status_name}" val="{$status}" />
                        </span>
                        <em><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                        <ul>
                            <li class="on" val="0" title="{$T->str_job_all}">{$T->str_job_all}</li>
                            <li val="1" title="{$T->str_wait_bill}">{$T->str_wait_bill}</li>
                            <li val="2" title="{$T->str_wait_input}">{$T->str_wait_input}</li>
                            <li val="3" title="{$T->h5_pop_cancel}">{$T->h5_pop_cancel}</li>
                            <li val="4" title="{$T->str_already_refuse}">{$T->str_already_refuse}</li>
                        </ul>
                    </div>
                    
                    <div class="serach_name menu_list js_select_div">
                        <span class="span_name">
                            <input name="search_type" type="text" value="{$search_name}"  readonly="true" val="{$search_type}"/>
                        </span>
                        <em><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                        <ul>
                            <li class="on" val="order_no" title="{$T->str_card_share_order_account}">{$T->str_card_share_order_account}</li>
                            <li val="mobile" title="{$T->str_cr_user_id}">{$T->str_cr_user_id}</li>
                            <li val="real_name" title="{$T->str_account_name}">{$T->str_account_name}</li>
                        </ul>
                        <input title="{$keyword}" class="textinput cursorpointer" name="keyword" type="text" value="{$keyword}"/>

                    </div>
                    <div class="select_time_c">
                        <span class="span_name">{$T->str_create_time}</span>
                        <div class="time_c">
                            <input id="js_begintime" class="time_input" type="text" readonly="readonly" name="start_time" readonly="readonly" value="{$starttime}" />
                            <i class="js_selectTimeStr"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </div>
                        <span>--</span>
                        <div class="time_c">
                            <input id="js_endtime" class="time_input" type="text" readonly="readonly" name="end_time" value="{$endtime}"/>
                            <i class="js_selectTimeStr"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </div>
                    </div>
                    <div class="serach_but">
                        <input class="butinput cursorpointer" type="button" value="" id="js_searchbutton"/>
                    </div>
                </div>
            </div>
            <div class="appadmin_pagingcolumn">
                <!-- 翻页效果引入 -->
                <include file="@Layout/pagemain" />
            </div>
            <div class="scanner_gdtiao">
                <div class="scanner_lia_maxwidth">
                    <div class="orderlist_list_name">
                        <span class="span_span11"></span>
                        <span class="span_span1">
                            {$T->str_card_share_order_account}
                        </span>
                        <span class="span_span2">
                            <a href="{$href_class_arr['create_time']['href']}"><u>{$T->str_create_time}</u><em class="{$href_class_arr['create_time']['classname']}"></em></a>
                        </span>
                        <span class="span_span3">{$T->str_news_status}</span>
                        <span class="span_span3">{$T->str_invoice_type}</span>
                        <span class="span_span4">{$T->str_invoice_no}</span>
                        <span class="span_span5">{$T->str_dealing_price}</span>
                        <span class="span_span5">{$T->str_UserID}</span>
                        <span class="span_span7">{$T->str_account_name}</span>
                        <span class="span_span2">
                            <a href="{$href_class_arr['update_time']['href']}"><u>{$T->str_bill_time}</u><em class="{$href_class_arr['update_time']['classname']}"></em></a>
                        </span>
                        <span class="span_span9">{$T->str_g_operator}</span>
                    </div>
                    <if condition="$rstCount neq 0">
                        <foreach name="list" item="val">
                            <div class="orderlist_list_c list_hover js_x_scroll_backcolor">
                                <span class="span_span11"></span>
                                <span class="span_span1" title="{$val.order_no}">{$val.order_no}</span>
                                
                                <span class="span_span2" title="{$val.create_time}">{$val.create_time}</span>
                                <span class="span_span3">{$order_status[$val['status']]}</span>
                                <span class="span_span3">{$types[$val['type']]}</span>
                                <span class="span_span4"><empty name="val.invoice_no">-<else />{$val.invoice_no}</empty></span>
                                <span class="span_span5">{$val.price}</span>
                                <span class="span_span5" title="{$val.mobile}">{$val.mobile}</span>
                                <span class="span_span7" title="{$val.real_name}">{$val.real_name}</span>
                                <span class="span_span2"><empty name="val.update_time">-<else />{$val.update_time}</empty></span>
                                <span class="span_span9">
                                    <if condition="$val['status'] eq 1">
                                    <a href="__URL__/bill/id/{$val.id}"><em class="hand js_single_edit">{$T->str_bill}</em></a>
                                    <elseif condition="$val['status'] eq 2" />
                                    <a href="__URL__/bill/id/{$val.id}"><em class="hand js_single_edit">{$T->str_invoice_detail}</em></a>
                                    <elseif condition="$val['status'] eq 3" />
                                    <a href="__URL__/bill/id/{$val.id}"><em class="hand js_single_edit">{$T->str_invoice_detail}</em></a>
                                    <elseif condition="$val['status'] eq 4" />
                                    <a href="__URL__/bill/id/{$val.id}"><em class="hand js_single_edit">{$T->str_bill}</em></a>
                                    </if>
                                    
                                </span>
                            </div>
                        </foreach>
                    <else/>
                        No Data
                    </if>
                </div>
            </div>
        </div>
        <div class="appadmin_pagingcolumn">

            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" />
        </div>
    </div>
</div>
<div id="js_layer_div"></div>
<!-- 配置文件 -->
<script type="text/javascript" src="__PUBLIC__/js/jsExtend/ueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="__PUBLIC__/js/jsExtend/ueditor/ueditor.all.js"></script>
<script>
    var searchurl="{:U('Appadmin/FinanceManage/waitlist','','','',true)}";
    $(function(){
        $.finance.waitlist();
        //时间选择
        //日历插件
        $.dataTimeLoad.init({minDate:{start:false,end:false},maxDate:{start:false,end:false}});
        
    });
</script>
<include file="unlockpop" />