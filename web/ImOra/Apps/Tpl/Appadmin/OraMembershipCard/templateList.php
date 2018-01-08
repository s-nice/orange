<layout name="../Layout/Layout" />
<style>
<!--
#mCSB_1_scrollbar_vertical{width:4px !important;}
-->
</style>
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<div class="content_search">
				<div class="right_search">
					<div class="serach_namemanages border_w menu_list">
						<span class="span_name"><input class="width_w" id='select' type="text" title='{$T->str_orangecard_card_type1}' value="{$T->str_orangecard_all}" readonly="true" autocomplete='off'/></span>
                        <em id="js_seltitle"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                        <ul id="js_selcontent">
                            <li class="on" val="" title="">{$T->str_orangecard_all}</li>
                            <foreach name="first" item='val' key='k'>
                            <li val="{$val.id}" title="{$val.name}">{$val.name}</li>
                            </foreach>
                        </ul>
                    </div>
                    <input id='tempnumber' class="textinput key_width cursorpointer" type="text" title="{$T->str_orangecard_tplnum}" placeholder="{$T->str_orangecard_tplnum}" autocomplete='off' value="{$get.tempnumber}"/>
                    <input id='keyword' class="textinput key_width cursorpointer" type="text" title="{$T->str_orangecard_please_input_keyword}" placeholder="{$T->str_orangecard_please_input_keyword}" autocomplete='off' value="{$get.keyword}"/>
                    <div class="serach_namemanages border_w menu_list">
                    	<span class="span_name"><input class="width_w" id='select2' type="text" title='{$T->str_orangecard_iscoop}' value="{$T->str_orangecard_shop_all}" readonly="true" autocomplete='off'/></span>
                        <em id="js_seltitle"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                        <ul id="js_selcontent2">
                            <li class="on" val="">{$T->str_orangecard_shop_all}</li>
                            <li val="2">{$T->str_orangecard_shop_coop}</li>
                            <li val="1">{$T->str_orangecard_shop_nocoop}</li>
                        </ul>
                    </div>
                    <div class="select_time_c">
                        <span class="span_name">{$T->str_news_time}</span>
                        <div class="time_c">
                            <input id="js_begintime" class="time_input" type="text" readonly="readonly" name="start_time"  autocomplete='off' value="{$get['starttime']}" />
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </div>
                        <span>--</span>
                        <div class="time_c">
                            <input id="js_endtime" class="time_input" type="text" readonly="readonly" name="end_time" value="{$get['endtime']}"  autocomplete='off'/>
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                    	</div>
					</div>
					<div id='js_searchbutton' class="serach_but">
                        <input class="butinput cursorpointer" type="button" value=""/>
                    </div>
			</div>
		</div>
		<div class="section_bin add_vipcard">
			<span class="span_span11">
				<i id="js_allselect"></i>
			</span>
			<button type="button">{$T->str_orangecard_new_template}</button>
			<button type="button">{$T->str_orangecard_del}</button>
			<button type="button">{$T->str_orangecard_export}</button>
			<!-- <button type="button" class='button_disabel'>{$T->str_orangecard_add_label}</button> -->
		</div>
		<include file="@Layout/pagemain" />
        <div style="min-height:900px;">
		<div class="vipcard_list border_vipcard userpushlist_name">
            <span class="span_span11"></span>
            <span class="span_span1 hand" order='id'>
                	<u>ID</u>
                    <if condition="$get['order'] eq 'id'">
                	    <if condition="$get['ordertype'] eq 'desc'">
                    	   <em class="list_sort_desc" type="desc"></em>
                    	<elseif condition="$get['ordertype'] eq 'asc'"/>
                    	   <em class="list_sort_asc" type="asc"></em>
                    	<else/>
                    	   <em class="list_sort_none" type=""></em>
                    	</if>
                	<else/>
                	   <em class="list_sort_none" type=""></em>
                	</if>
                </span>
            <span class="span_span2">{$T->str_orangecard_card_type}</span>
            <span class="span_span2">{$T->str_orangecard_template_no}</span>
            <!--<span class="span_span9">二级卡类型</span>-->
            <!-- <span class="span_span3">{$T->str_orangecard_card_company}</span> -->
            <span class="span_span8">{$T->str_orangecard_template_desc}</span>
            <span class="span_span1">{$T->str_orangecard_shop_coop}</span>
            <span class="span_span5 hand" order='createdtime'>
                <u style="float:left;">{$T->str_orangecard_add_time}</u>
                <if condition="$get['order'] eq 'createdtime'">
            	    <if condition="$get['ordertype'] eq 'desc'">
                	   <em class="list_sort_desc" type="desc"></em>
                	<elseif condition="$get['ordertype'] eq 'asc'"/>
                	   <em class="list_sort_asc" type="asc"></em>
                	<else/>
                	   <em class="list_sort_none" type=""></em>
                	</if>
            	<else/>
            	   <em class="list_sort_none" type=""></em>
            	</if>
            </span>
            <span class="span_span6 hand" order='personnum'>
				<u style="float:left;">{$T->str_orangecard_used_num}</u>
				<if condition="$get['order'] eq 'personnum'">
            	    <if condition="$get['ordertype'] eq 'desc'">
                	   <em class="list_sort_desc" type="desc"></em>
                	<elseif condition="$get['ordertype'] eq 'asc'"/>
                	   <em class="list_sort_asc" type="asc"></em>
                	<else/>
                	   <em class="list_sort_none" type=""></em>
                	</if>
            	<else/>
            	   <em class="list_sort_none" type=""></em>
            	</if>
            </span>
            <span class="span_span7">{$T->str_orangecard_operation}</span>
        </div>
        <input type='hidden' id='order' value='{$get.order}'>
        <input type='hidden' id='ordertype' value='{$get.ordertype}'>
        <foreach name="list" item="val">
        <div class="vipcard_list userpushlist_c checked_style list_hover js_x_scroll_backcolor">
        	<span class="span_span11"><i class="js_select" val='{$val.id}' tagid='{$val.tagid}'></i></span>
            <span class="span_span1">{$val.id}</span>
            <span class="span_span2" title='{$val.cardtypename}'>{$val.cardtypename}</span>
            <span class="span_span2">{$val.tempnumber}</span>
            <span class="span_span8" title='{$val.description}'>{$val.description}</span>
            <span class="span_span1">
            <if condition="$val.iscoop eq '2'">{$T->str_yes}
            <else/>{$T->str_not}
            </if>
            </span>
            <span class="span_span5"><?php echo date('Y-m-d H:i', $val['createdtime']);?></span>
            <span class="span_span6">{$val.personnum}</span>
            <span class="span_span7">
                <em class="hand edit">{$T->str_orangecard_edit}</em>
                <em class="hand copy">复制</em>
            </span>
        </div>
        </foreach>
        <div class="appadmin_pagingcolumn">
            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" />
        </div>
        </div>
	</div>
</div>
<include file="@Appadmin/OraMembershipCard/addCard" />
<script type="text/javascript">
var URL_ADD="{:U('Appadmin/OraMembershipCard/newCardTemplate')}";
var URL_EDIT="{:U('Appadmin/OraMembershipCard/editCardTemplate')}";
var URL_LIST="{:U('Appadmin/OraMembershipCard/templateList')}";
var URL_DEL="{:U('Appadmin/OraMembershipCard/delTemplate')}";
var URL_SAVE_TMP_TPL="{:U('Appadmin/OraMembershipCard/saveTmpTplData')}";
var URL_ADD_LABEL="{:U('Appadmin/OraMembershipCard/addLabelToTpl')}";
var URL_EXPORT="{:U('Appadmin/OraMembershipCard/export')}";

var str_orangecard_tl_using="{$T->str_orangecard_tl_using}";
var str_orangecard_tl_select_data="{$T->str_orangecard_tl_select_data}";
var str_orangecard_tl_select_label="{$T->str_orangecard_tl_select_label}";
var str_orangecard_tl_select_tpldata="{$T->str_orangecard_tl_select_tpldata}";
var str_orangecard_tl_del_confirm="{$T->str_orangecard_tl_del_confirm}";
var str_orangecard_cancel="{$T->str_orangecard_cancel}";
var str_orangecard_confirm="{$T->str_orangecard_confirm}";

//关闭子窗口，父窗口刷新
function closeWindow(object, isReload){
    object.close();
    isReload===true && window.location.reload();
}
$(function(){
	$.templateList.init();
	
	//卡类型搜索数据
	var cardtype="{$get.cardtype}";
	if (!!cardtype){
		$('#js_selcontent li[val="'+cardtype+'"]').click();
	}

	//合作商户搜索数据
	var iscoop="{$get.iscoop}";
	if (!!iscoop){
		$('#js_selcontent2 li[val="'+iscoop+'"]').click();
	}
});
</script>