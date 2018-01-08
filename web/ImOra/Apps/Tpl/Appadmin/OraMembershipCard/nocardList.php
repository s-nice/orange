<layout name="../Layout/Layout" />
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<div class="content_search">
				<div class="right_search">
                    <div class="search_text">
						<input class="textinput shop_width cursorpointer" type="text" placeholder="{$T->str_orangecard_please_input_shop_name}" title="{$T->str_orangecard_please_input_shop_name}" value="{$get.keyword}" autocomplete='off'/>
                    </div>
                    <div class="serach_namemanages menu_list search_width">
						<span class="span_name"><input id='select' val="{$get.cardtype}" type="text" title='{$T->str_orangecard_card_type}' value="{$T->str_orangecard_all}" readonly="true" autocomplete='off'/></span>
                        <em id="js_seltitle"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                        <ul id="js_selcontent">
                            <li class="on" val="" title="">{$T->str_orangecard_all}</li>
                            <foreach name="first" item='val' key='k'>
                            <li val="{$k}" title="{$val.name}">{$val.name}</li>
                            </foreach>
                        </ul>
                    </div>
                    <div class="serach_but">
                        <input id='js_searchbutton' class="butinput cursorpointer" type="button" value=""/>
                    </div>
				</div>
			</div>
			<div class="section_bin no_card_btn">
				<span class="span_span11">
					<i id="js_allselect"></i>
				</span>
				<button type="button" class='hand'>{$T->str_orangecard_add_template}</button>
			</div>
			<include file="@Layout/pagemain" />
            <div style="min-height:900px;">
			<div class="no_card_list userpushlist_name">
            	<span class="span_span11"></span>
            	<span class="span_span1 hand" order='id'>{$T->str_orangecard_shop_name}</span>
            	<span class="span_span2">{$T->str_orangecard_card_type}</span>
            	<span class="span_span5 hand" order='personnum'>
                	<u>{$T->str_orangecard_user_num}</u>
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
        	</div>
        	<input type='hidden' id='order' value='{$get.order}'>
            <input type='hidden' id='ordertype' value='{$get.ordertype}'>
        	<foreach name="list" item="val">
        	<div class="no_card_list checked_style userpushlist_c list_hover js_x_scroll_backcolor">
	        	<span class="span_span11"><i class="js_select" val="{$val.id}"></i></span>
	            <span class="span_span1" title='{$val.lssuername}'>{$val.lssuername}</span>
	            <span class="span_span2" title='{$val.firstname}'>{$val.firstname}</span>
	            <span class="span_span5">
	                <em class="hand">{$val.personnum}</em>
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
</div>
<script type="text/javascript">
var URL_ADD="{:U('Appadmin/OraMembershipCard/addTplFromUserCardList')}";
var URL_LIST="{:U('Appadmin/OraMembershipCard/nocardList')}";
var URL_SAVE_TMP_TPL="{:U('Appadmin/OraMembershipCard/saveTmpTplData')}";

var str_orangecard_nl_select_data = "{$T->str_orangecard_nl_select_data}";
//关闭子窗口，父窗口刷新
function closeWindow(object, isReload){
    object.close();
    isReload===true && window.location.reload();
}

$(function(){
	//搜索的卡类型
	var cardtype="{$get.cardtype}";
	var cardtypetwo="{$get.cardtypetwo}";
	if (!!cardtype){
		var $li=$('#js_selcontent li[val="'+cardtype+'"]').addClass('on')
		$li.siblings().removeClass('on');
		$('#select').val($li.html());
	}
	if (!!cardtypetwo){
		var $li=$('#js_selcontent2 li[val="'+cardtypetwo+'"]').addClass('on')
		$li.siblings().removeClass('on');
		$('#select2').val($li.html());
	}
	$.nocardList.init();
});
</script>