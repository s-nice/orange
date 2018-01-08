<!-- 兑换码列表 -->
<layout name="../Layout/Layout" />
<include file="head" />
<style>
    .edui-default .edui-toolbar{
        width:706px; /*设置ueditor 编辑器宽度*/
    }
    .right_search input.textinput {width: 100px;}
    .serach_name em {right: 140px;}
    .serach_name {width: 220px;}
</style>
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <div class="content_search">

                <div class="right_search">
                    <div class="serach_name menu_list js_select_div">
        				<span class="span_name">
                            <input name="search_type" type="text" value="兑换码"  readonly="true"/>
                        </span>
                        <em><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                        <ul>
                            <li class="on" val="mobile" title="">兑换码</li>
                            <li val="name" title="">兑换人ID</li>
                            <li val="redeemcode" title="">兑换人姓名</li>
                        </ul>
                        <input class="textinput cursorpointer" name="keyword" type="text" value="{$keyword}"/>
                        <input type="hidden" id="js_search_group_id" value="{$params['groupid']}">
                    </div>
                    <div class="select_time_c">
                        <span class="span_name">{$T->str_release_time}</span>
                        <div class="time_c">
                            <input id="js_begintime" class="time_input" type="text" readonly="readonly" name="start_time"  value="{$starttime}" />
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
            <!-- 翻页效果引入 -->
            <div class="appadmin_pagingcolumn">

                <!-- 翻页效果引入 -->
                <include file="@Layout/pagemain" />
            </div>
            <div class="scanner_gdtiao">
                <div class="sectionnot_list_name redeemcode_uselist" style="width:820px;">
                    <span class="span_span15"><u>兑换码</u></span>
                    <span class="span_span12">兑换人ID</span>
                    <span class="span_span16">兑换人姓名</span>
                    <span class="span_span12">兑换内容</span>
                    <span class="span_span5">状态</span>
                    <span class="span_span14">
                        <u>{$T->str_exchange_time}</u><a href="{$href_class_arr['usetime']['href']}"><em class="{$href_class_arr['usetime']['classname']}"></em></a>
                    </span>
                    <span class="span_span5">操作</span>
                </div>
                <if condition="$rstCount neq 0">
                    <foreach name="list" item="val">
                        <div class="sectionnot_list_c redeemcode_uselist list_hover js_x_scroll_backcolor" style="width:820px;">
                            <span class="span_span15">{$val['redeemcode']}</span>
                            <span class="span_span12" title="{$val['mobile']}">{$val['mobile']}</span>
                            <span class="span_span16">{$val['name']}</span>
                            <span class="span_span12"><if condition="$val['status'] eq 1">-<else /><if condition="$val['length']">{$val['length']}{$T->str_days_authorized}</if><if condition="$val['stock']"> {$val['stock']}{$T->str_stock}</if></if></span> 
                            <span class="span_span5">正常</span>
                            <span class="span_span14"><if condition="$val['status'] eq 1">-<else />{:date('Y-m-d H:i:s',$val['usetime'])}</if></span>
                            <span class="span_span5">作废</span>
                        </div>
                    </foreach>
                <else/>
                    No Data
                </if>
            </div>
            
            
        </div>
        <div class="appadmin_pagingcolumn">

            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" />
        </div>
    </div>
</div>
<!-- 配置文件 -->
<script type="text/javascript" src="__PUBLIC__/js/jsExtend/ueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="__PUBLIC__/js/jsExtend/ueditor/ueditor.all.js"></script>
<script>
    var searchurl="{:U('Appadmin/ActiveOperation/usedlist','','','',true)}";
	
    $(function(){
       	$.activeoperation.usedlist();
    	$.dataTimeLoad.init({minDate:{start:false,end:false},maxDate:{start:false,end:false}});
    })
</script>
<include file="unlockpop" />
