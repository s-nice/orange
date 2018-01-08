<layout name="../Layout/Layout" />
<style>
    .right_search input.s_key {width: 130px;}
    .agreement_list span.span_span1 {
        width: 180px;
    }
    .agreement_list span.span_span8 {
        width: 100px;
    }
</style>
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <div class="right_search">
                <form id="js_search_form" method="get" action="{:U('Appadmin/HotelAccessCard/bssid','',false)}">
                    <input type="hidden" name="sort" value="{$sort}">

                    <input  class="s_key" type="text"  placeholder="输入酒店名称" name="hotelname"
                    <if condition="isset($params['hotelname'])"> value="{$params['hotelname']}"</if>>
                    <input  class="s_key" type="text"  placeholder="输入发卡单位" name="unitname"
                    <if condition="isset($params['unitname'])"> value="{$params['unitname']}"</if>>
                    <input  class="s_key" type="text"  placeholder="输入BSSID" name="bssid"
                    <if condition="isset($params['bssid'])"> value="{$params['bssid']}"</if>>
                    <div class="select_time_c">
                        <span class="span_name">时间</span>
                        <div class="time_c">
                            <input id="js_begintime" class="time_input" readonly="readonly" type="text" name="starttime" value="{$starttime}" />
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </div>
                        <span>--</span>
                        <div class="time_c">
                            <input id="js_endtime" class="time_input" readonly="readonly" type="text" name="endtime"  value="{$endtime}" />
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </div>
                    </div>
                    <div class="serach_but">
                        <input id="js_search" class="butinput cursorpointer" type="button" value="" />
                    </div>
                </form>
            </div>
            <div class="section_bin rule_btn" style="margin-bottom:8px;">
                <button type="button" id="js_add">添加</button>

            </div>
            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" />
            <div class="agreement_list userpushlist_name js_list_name_title">
            	<span class="span_span1 hand" order='id'>
                	<u>酒店名称</u>
                </span>
                <span class="span_span1">发卡单位</span>
                <span class="span_span1">BSSID</span>
            	<span class="span_span1 hand" >
           	    	<u>添加时间</u>
                    <a href="{$href_class_arr['createtime']['href']}"><em class="{$href_class_arr['createtime']['classname']} js_sort" type="asc"   ></em></a>
            	</span>
                <span class="span_span8">操作</span>
            </div>
            <if condition="$rstCount neq 0">
                    <foreach name="list" item="val">
                        <div class="agreement_list userpushlist_c checked_style list_hover js_x_scroll_backcolor">
                            <span class="span_span1" title="{$val.hotelname}">{$val.hotelname}</span>
                            <span class="span_span1" title="{$val.unitname}">{$val.unitname}</span>
                            <span class="span_span1"  title="{$val.bssid}">{$val.bssid}</span>
                            <span class="span_span1" title="{:date('Y-m-d H:i',$val['createtime'])}">{:date('Y-m-d H:i',$val['createtime'])}</span>
            	            <span class="span_span8">
                                <em class="hand js_edit" data-id="{$val.hotelid}">修改</em>|
                                <em class="hand js_del" data-id="{$val.id}">删除</em>
            	             </span>
                        </div>
                    </foreach>
                    <else/>
                    NO DATA
            </if>
            <div class="appadmin_pagingcolumn">
                <!-- 翻页效果引入 -->
                <include file="@Layout/pagemain" />
            </div>
        </div>
    </div>
</div>
<!--酒店BSSID弹框-->
<div id="js_add_edit_div" class="bssid-dialog" style="display:none;">
    <div class="menu-float">
        <div class="dai-menu-list dia-span-width">
            <span>发卡单位:</span>
            <div class="list-card js_div_list">
                <input data-val="" id="js_deal_unitname" type="text" value="" readonly="readonly" />
                <img class="dia-xia" src="__PUBLIC__/images/shoppingcart_select.jpg" alt="">
                <ul id="js_ul_unit">
                </ul>
            </div>
        </div>
        <div class="dai-menu-list dia-span-width">
            <span>酒店名称:</span>
            <div class="list-card js_div_list">
                <input data-val="" id="js_deal_hotelname" type="text" value="" readonly="readonly" />
                <img class="dia-xia" src="__PUBLIC__/images/shoppingcart_select.jpg" alt="">
                <ul id="js_ul_hotel">
                </ul>
            </div>
        </div>
    </div>
    <div class="menu-float js_bssid_ssid" data-val="">
        <div class="dai-menu-list dia-span-width">
            <span>BSSID:</span>
            <div class="list-card">
                <input type="text" class="js_deal_bssid"  value="" />
            </div>
        </div>
        <div class="dai-menu-list dia-span-width">
            <span>SSID:</span>
            <div class="list-card">
                <input type="text" class="js_deal_ssid" value="" />
            </div>
        </div>
        <div class="add-btn-b">
            <span class="add-span js_inc">+</span>
            <span class="let-span js_dec">-</span>
        </div>
    </div>
    <div class="q-btn q-btn-margin" id="js_div_btn">
        <button data-val="1" class="middle_button" type="button"  id="js_add_confirm">确定</button>
        <button class="middle_button" type="button" id="js_add_cancel">取消</button>
    </div>
</div>
<script>
    var searchurl = "__URL__/bssid";
    var delUrl = "__URL__/delBssidPost";
    var addUrl = "__URL__/getBssidDetail";
    var getHotelListUrl = "__URL__/getHotel";
    var addBssidPostUrl = "__URL__/addBssidPost";
    $(function(){
        $.dataTimeLoad.init();//日历插件
        $.hotelaccesscard.bssid();
    })
</script>