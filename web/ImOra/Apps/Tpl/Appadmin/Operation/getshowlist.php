<div class="waiflist_comment_pop">
	<div class="waiflist_comment_close"><img class="cursorpointer js_add_list_cancel" src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
	<div class="waiflist_commentpop_c">
		<div class="waiflist_title">{$T->str_choose_news}</div>
		<div class="waiflist_serach">
			<div class="waif_name layer_showlist menu_list">
	            <span class="span_name_1">
					<input id="js_state_value" class="js_select_value" val="{$newsState}" type="text" title="{$stateName}" readonly="true" seltitle="title" value="{$stateName}">
				</span>
	            <em id="js_sel_type"><img src="__PUBLIC__/images/appadmin_icon_xiala.png"></em>
	            <ul id="js_sel_state" class="select_items">
					<li class="on" title="{$T->push_pushed}" val="6">{$T->push_pushed}</li>
					<li title="{$T->str_waiting_push}" val="3">{$T->str_waiting_push}</li>
				</ul>
	        </div>
			<div class="waif_name layer_showlist menu_list">
	            <span class="span_name_1">
					<input id="js_type_value" class="js_select_value" val="{$t}" type="text" title="{$tname}" readonly="true" seltitle="title" value="{$tname}">
				</span>
	            <em id="js_sel_type"><img src="__PUBLIC__/images/appadmin_icon_xiala.png"></em>
	            <ul id="js_sel_type_content" class="select_items">
					<li class="on" title="{$T->str_news_title}" val="1">{$T->str_news_title}</li>
					<li title="ID" val="2">ID</li>
				</ul>
	        </div>
			<input class="textinput" name='search_word' type="text" value="{$k}" />
            <input class="butinput cursorpointer" type="button" value="" />
		</div>
		<div class="waiflist_list_name">
		     <span class="span_span11"></span>
		     <span class="span_span13"><u>ID</u><a href="{$href_class_arr['id']['href']}"><em class="{$href_class_arr['id']['classname']}"></em></a></span>
		     <span class="span_span3">{$T->str_news_title}</span>
		     <span class="span_span1">{$T->collection_category}</span>
		     <span class="span_span12"><u>{$T->str_publish_time}</u><a href="{$href_class_arr['releasetime']['href']}"><em class="{$href_class_arr['releasetime']['classname']}"></em></a></span>
		     <span class="span_span11">{$T->str_news_publish_user}</span>
		</div>
		<if condition="sizeof($list)">
        <foreach name="list" item="val">
		<div class="waiflist_list_c">
             <span class="span_span11">
             	<i class="js_select_code" val="{$val['showid']}"></i>
             </span>
             <span class="span_span13" title="{$val.id}">{$val.id}</span>
             <span class="span_span3 js_title" title="{$val.title}">{$val.title}</span>
             <span class="span_span1" title="<if condition="$val['category']">{$val.category}<else />{$T->str_news_null}</if>"><if condition="$val['category']">{$val.category}<else />{$T->str_news_null}</if></span>

             <span class="span_span12" title="{:date('Y-m-d H:i:s',$val['releasetime'])}">{:date('Y-m-d H:i:s',$val['releasetime'])}</span>
             <span class="span_span11" title="{$val.num}">{$val.realname}</span>
        </div>
        </foreach>
		<else />
			<div class="waiflist_list_empty"><span class="search_empty">{$T->str_no_data}</span></div>
		</if>
        <div class="waiflist_pagingcolumn">
            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" />
        </div>
        <div class="faq_bin">
			<input class="dropout_inputr cursorpointer js_add_list_cancel middle_button" type="button" value="{$T->str_cancel_del_new}" />
			<input class="dropout_inputl cursorpointer js_add_list_sub middle_button" type="button" value="{$T->str_yes_del_new}" />
		</div>
	</div>
</div>