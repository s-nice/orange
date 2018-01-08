<div class="waiflist_comment_pop">
	<div class="waiflist_comment_close"><img class="cursorpointer js_add_list_cancel" src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
	<div class="waiflist_commentpop_c">
		<div class="waiflist_title">{$T->str_choose_redeemcode}</div>
		<div class="waiflist_serach">
			<div class="waif_name">
	            <span class="span_name_codelist">
					{$T->str_redeemcode_group}
				</span>
	                	
	        </div>
			<input class="textinput search_code_list" name='search_word' type="text" value="{$k}" />
            <input class="butinput cursorpointer" type="button" value="" />
		</div>
		<div class="waiflist_list_name">
		     <span class="span_span11"></span>
		     <span class="span_span5">{$T->str_redeemcode_group}</span>
		     <span class="span_span4">{$T->str_authorized_time}</span>
		     <span class="span_span1">{$T->str_stock}</span>
		     <span class="span_span1">{$T->str_code_num}</u></span>
		</div>
		<if condition="sizeof($list)">
        <foreach name="list" item="val">
		<div class="waiflist_list_c list_hover">
             <span class="span_span11">
             	<i class="js_select_code" val="{$val['id']}"></i>
             </span>
             <span class="span_span5 js_name" title="{$val.name}">{$val.name}</span>
             <span class="span_span4" title="<if condition="$val['length'] neq 0">{$val['length']}{$T->str_day_unit}<else />--</if>"><if condition="$val['length'] neq 0">{$val['length']}{$T->str_day_unit}<else />--</if></span>
             <span class="span_span1" title="<if condition="$val['stock'] neq 0">{$val['stock']}<else />--</if>"><if condition="$val['stock'] neq 0">{$val['stock']}<else />--</if></span>
             <span class="span_span1" title="{$val.num}">{$val.num}</span>     
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
			<input class="dropout_inputr big_button cursorpointer js_add_list_cancel" type="button" value="{$T->str_cancel_del_new}" />
			<input class="dropout_inputl big_button cursorpointer js_add_list_sub" type="button" value="{$T->str_yes_del_new}" />
		</div>                    
	</div>
</div>